<?php
  $src_name=$_POST["src_name"];
  $src_power=$_POST["src_power"];
  $src_ratio=$_POST["src_ratio"];
  $src_most_champ=$_POST["src_most_champ"];

  $dst_name=$_POST["dst_name"];
  $dst_power=$_POST["dst_power"];
  $dst_ratio=$_POST["dst_ratio"];
  $dst_most_champ=$_POST["dst_most_champ"];

  // $src_name="Def Soronto";
  // $src_power=2454;
  // $src_ratio="344W 326L Win Ratio 51%";
  // $src_most_champ=" Ivern - 109W 68L Win Ratio 62% Morgana - 87W 84L Win Ratio 51% Zac - 71W 76L Win Ratio 48% Nautilus - 48W 57L Win Ratio 46% Braum - 48W 46L Win Ratio 51%";
  //
  // $dst_name="노력은인정하마";
  // $dst_power=2335;
  // $dst_ratio="318W 317L Win Ratio 50%";
  // $dst_most_champ=" Zac - 107W 75L Win Ratio 59% Morgana - 41W 44L Win Ratio 48% Katarina - 46W 38L Win Ratio 55% Fizz - 45W 39L Win Ratio 54% Lux - 26W 35L Win Ratio 43%";

  function ratio_generator($ratio_str){
    $ratio_str=preg_match("/o[^%]*/",$ratio_str,$outs);
    $ratio=str_replace("o ","",$outs[0]);
    return $ratio;
  }
  function power_correction($power,$ratio){
    return $power+($power*($ratio/100));
  }
  function most_champ_generator($champ_str){
    $champ_str=str_replace("%",",%",$champ_str);
    $most_champ_list=split("\%",$champ_str);
    $champ_list=array();
    foreach($most_champ_list as $v){
      list($champ,$odd)=split("-",$v);
      $champ=trim($champ);
      preg_match("/o[^,]*/",$odd,$outs);
      $odd=str_replace("o ","",$outs[0]);
      array_push($champ_list,array($champ,$odd));
    }
    return $champ_list;
  }
  $src_ratio=ratio_generator($src_ratio);
  $dst_ratio=ratio_generator($dst_ratio);
  $src_power=power_correction($src_power,$src_ratio);
  $dst_power=power_correction($dst_power,$dst_ratio);
  $src_most_champ=most_champ_generator($src_most_champ);
  $dst_most_champ=most_champ_generator($dst_most_champ);
  $result_json=array();
  include("db/selectChampionOdd.php");
  foreach($src_most_champ as $src_champ){
    foreach($dst_most_champ as $dst_champ){
      if($src_champ[0]==''||$dst_champ[0]=='')continue;
      // echo "src :".$src_champ[0]."odd :".$src_champ[1]."<br>";
      // echo "dst :".$dst_champ[0]."odd :".$dst_champ[1]."<br>";
      $tmp=selectChampionOdd($src_champ[0],$dst_champ[0]);
      if($tmp[0]==null)continue;
      foreach($tmp as $v){
        $result='{"src_champ":"'.$src_champ[0].'","dst_champ":"'.$dst_champ[0].'",
          "src_power":"'.power_correction($src_power,$src_champ[1]+50-$v[2]).'"
          ,"dst_power":"'.power_correction($dst_power,$dst_champ[1]).'",
          "line":"'.$v[3].'"}';
        array_push($result_json,$result);
      }
    }
  }
  $array_json='{"array":[';
  foreach($result_json as $v){
    $array_json=$array_json.$v.",";
  }
  $array_json=substr($array_json,0,-1);
  $array_json=$array_json.']}';
  echo $array_json;
?>
