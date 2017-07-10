<?php
  function selectChampion(){
    include("dbconnect.php");

    $query="SELECT * FROM champion_list";
    $champ_list=array();
    if($result=mysqli_query($con,$query)){
      while($row=mysqli_fetch_row($result)){
        array_push($champ_list,$row[1]);
      }
    }
    return $champ_list;
  }
?>
