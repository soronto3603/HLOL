<?php
  function selectChampionOdd($src,$dst){
    include("dbconnect.php");

    $query="SELECT src,dst,odd,line FROM champion_win_odd WHERE src='$src' AND dst='$dst'";
    $champ_list=array();
    if($result=mysqli_query($con,$query)){
      while($row=mysqli_fetch_row($result)){
        array_push($champ_list,$row);
      }
    }
    return $champ_list;
  }
?>
