<?php

/*
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/10/23
  * Time:  4:48 PM
*/
session_start();

$pageName = "Authentication Confirmation";

require_once "header.php";

$state = $_GET['state'];

?>
<h1>Login Confirmation</h1>

<?php
if($state == 1){
    echo "You have been logged out.";
}
if($state == 2){
    echo "Welcome back, <strong>{$_SESSION['fname']}</strong>";
}
?>



<?php
require_once "footer.php";
?>
