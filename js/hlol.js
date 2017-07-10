var src=null;
var dst=null;
function detect_text(self){
  document.getElementById('loading_image').style.display="block";
  $.get("get_user_info.php",{nickname:self.value}).done((result)=>{

    document.getElementById('loading_image').style.display="none";
    var json=JSON.parse(result);
    var str=json.name+"<br>";
    str=str+json.tier+"<br>";
    str=str+json.ratio+"<br>";
    str=str+json.most_champ.replace(/%/gi,"%<br>")+"<br>";
    //alert(json.power);
    if(self.id.indexOf("src")!=-1){
      document.getElementById('src_result').innerHTML=str;
      src=json;
    }else{
      document.getElementById('dst_result').innerHTML=str;
      dst=json;
    }
  });
}
function start_calc(){
  if(src==null||dst==null){
    alert("두 플레이어를 입력해주셔야 합니다.");
  }
  $.post("calc_both_player.php",{src_name:src.name,
    src_power:src.power,src_ratio:src.ratio,src_most_champ:src.most_champ,
  dst_name:dst.name,dst_power:dst.power,dst_ratio:dst.ratio,dst_most_champ:dst.most_champ}).done((result)=>{
    var json=JSON.parse(result);
    document.getElementById('content').innerHTML="";
    for(var i=0;i<json.array.length;i++){
      var power=json.array[i].src_power-json.array[i].dst_power;
      var color="";
      if(power<0){
        color="red";
      }
      else{
        color="blue";
      }
      var str='<div class="content_line back_'+color+'">';
      str+='<img class="image_circle content_line_image" src="Images/'+json.array[i].src_champ+'.png">';
      str+='<h1 class="content_line_text">VS</h1>';
      str+='<img class="image_circle content_line_image" src="Images/'+json.array[i].dst_champ+'.png">';
      str+='<h1 class="content_line_text result">'+power+'</h1>';
      str+='<h1 class="content_line_text line">'+json.array[i].line+'</h1>';
      str+='</div>';
      document.getElementById('content').innerHTML+=str;
    }
    document.getElementById('content').innerHTML+="<button onclick='location.reload()'>다시하기</button>";
  });
}
