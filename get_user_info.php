<?php
  include("utils/utils.php");
  $user_info=get_user($_GET['nickname']);
  echo '{"name":"'.$user_info[0].'","tier":"'.$user_info[1].'",
    "ratio":"'.$user_info[3].'","most_champ":"'.implode($user_info[4]).'","power":"'.$user_info[2].'"}';
?>
