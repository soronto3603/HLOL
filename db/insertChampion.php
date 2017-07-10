<?php
  function insertChampion($champ_name,$tag=''){
    include("dbconnect.php");

    $query="SELECT * FROM champion_list WHERE name='$champ_name'";
    if($result=mysqli_query($con,$query)){
      while($row=mysqli_fetch_row($result)){
        //print_r($result);
        return 0;
      }
    }
    $query="INSERT INTO champion_list(no,name,tag) VALUES(NULL,'$champ_name','$tag')";
    mysqli_query($con,$query);
    return 1;
  }
?>
