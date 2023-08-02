<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/10/23
  * Time:  4:50 PM
*/

session_start();
session_unset();
session_destroy();

$state = 1;

header("Location: confirm.php?state=1");

echo "<h3>You have been logged out. Log back in to continue.</h3>"

?>