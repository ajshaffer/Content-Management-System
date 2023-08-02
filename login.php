<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/10/23
  * Time:  4:47 PM
*/
session_start();

$pageName = "Login";

require_once "header.php";

//Initial variables
$showForm = 1;
$errExists = 0;

//Error variables
$err_email = "";
$err_pwd = "";



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //Form variables
    $email = trim(strtolower($_POST['email']));
    $pwd = $_POST['pwd'];
    $pwd_hashed = password_hash('pwd', PASSWORD_DEFAULT);

    if (empty($email)) {
        $errExists = 1;
        $err_email = "Please enter your email.<br>";
    }

    if (empty($pwd)) {
        $errExists = 1;
        $err_pwd = "Please enter your password.<br>";
    }


    if ($errExists == 1) {
        echo "<p class='error'>There are errors with your submission. Please make changes and re-submit.</p>";
    } else {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        if(!$row){
            echo "<p class = 'error'>The email and password combination could not be found.</p>";
            echo "<p class = 'error'>You must register first before logging in.</p>";
        }else {
            if (password_verify($pwd, $row['pwd'])) {
                // SET SESSION VARIABLES
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['status'] = $row['status'];

                // REDIRECT TO CONFIRMATION PAGE
                header("Location: confirm.php?state=2");

            }else{
                echo "<p class = 'error'> Invalid password.</p>";
            }

        }//Closes !row else statement

    }//Closes errExists else statement

}//Closes if POST statement

if($showForm == 1){
    ?>

    <h1>Login</h1>
    <form name="LoginForm" id="login" method="post" action="login.php">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email:" value="<?php if(isset($email)){ echo htmlspecialchars($email);}?>" size="30">
        <span class="error"> <?php echo $err_email;?></span><br><br>
        <br>

        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd" placeholder="Enter your password:" size="30">
        <span class="error"> <?php echo $err_pwd;?></span><br>
        <br>

        <label for="submit"></label> <input type="submit" name="submit" id="submit" value="submit">
    </form>

    <ul style="list-style-type: none;">
        <li><a href="register.php" id="register-button">Register</a></li>
    </ul>



    <?php
}
require_once "footer.php";
?>
