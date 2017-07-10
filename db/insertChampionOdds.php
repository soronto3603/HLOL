<?php
  function insertChampionOdds($src,$dst,$odd,$tag='',$line){
    include("dbconnect.php");

    $query="INSERT INTO champion_win_odd(no,src,dst,odd,tag,line) VALUES(NULL,'$src','$dst',$odd,'$tag','$line')";
    mysqli_query($con,$query);
    return 1;
  }
?>
