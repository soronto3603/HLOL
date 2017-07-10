<?php

function getPage($url){
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);

  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

  curl_setopt($ch,CURLOPT_POST,false);   //GET 전송방식
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  if(curl_error($ch)){
    exit("CURL Error(".curl_errno($ch).")".curl_error($ch));
  }
  return $response=curl_exec($ch);
}
function get_champion_list(){
  $html_page=getPage("https://www.op.gg/champion/statistics");
  preg_match_all("/<div class=\"ChampionName\">\S*[^<]<\/div>/",$html_page,$outs);
  return $outs[0];
}
// 챔피언 목록 db 저장
// include("../db/insertChampion.php");
// foreach(get_champion_list() as $k=>$v){
//   insertChampion(substr($v,26,-6));
// }
function image_downloader($url,$path,$file_name){
		if(!preg_match('/http/',$url))$url='http:'.$url;
		$fp = fopen("./".$path.$file_name, "w");
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)");
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_exec($ch);
		fclose($fp);
		curl_close($ch);
}
//챔피언 Image 저장
// include("../db/selectChampion.php");
// foreach(selectChampion() as $k=>$v){
//   $v=str_replace("&#039;","",$v);
//   image_downloader("http://ddragon.leagueoflegends.com/cdn/6.24.1/img/champion/$v.png",
//   "../Images/","$v.png");
// }

//챔피언 확률 메타데이터
// $lines=array("top","mid","support","adc","jungle");
// include("../db/selectChampion.php");
// include("../db/insertChampionOdds.php");
//
// foreach($lines as $line){
//   foreach(selectChampion() as $champ){
//     echo "https://na.op.gg/champion/$champ/statistics/$line/matchup";
//     $html_page=getPage("https://na.op.gg/champion/$champ/statistics/$line/matchup");
//     preg_match_all("/Cell Champion([^<]*<){8}/",$html_page,$outs);
//     foreach($outs[0] as $k=>$v){
//       if(strpos($v,"Games")!=0)continue;
//
//       $v=preg_replace("/Cell Champion[^<]*<[^>]*>/","",$v);
//       $v=preg_replace("/<[^>]*>/",":",$v);
//       $v=str_replace("<","",$v);
//       $v=preg_replace("/\s/","",$v);
//       $v=str_replace(":::",":",$v);
//       $v=str_replace("::",":",$v);
//       $v=split(":",$v);
//
//       insertChampionOdds($champ,$v[0],str_replace("%","",$v[3]),implode(",",$v),$line);
//     }
//   }
// }

//get User Info
function get_user($nickname){
  include("tier_points.php");
  $result=array();
  $nickname=urlencode($nickname);
  $html_page=getPage("https://www.op.gg/summoner/userName=$nickname");
  preg_match_all("/<meta[^>]*>/",$html_page,$outs);
  $user_data=substr($outs[0][2],34,-3);
  $user_data=split("/",$user_data);
  array_push($result,$user_data[0]);
  //echo "Summoner_name:".$user_data[0];

  $user_tier=split(" ",$user_data[1]);
  array_push($result,$user_tier[1].$user_tier[2]);
  //echo "User_Tier:".$user_tier[1].$user_tier[2];
  $power=$tier_point_table[$user_tier[1].$user_tier[2]];
  array_push($result,$power);
  //echo " power:".$power;
  $win_ratio=$user_data[2];
  array_push($result,$win_ratio);
  //echo $win_ratio;
  $most_champ=split(",",$user_data[3]);
  array_push($result,$most_champ);
  //print_r($most_champ);
  return $result;
}

?>
