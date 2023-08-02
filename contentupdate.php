<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/14/23
  * Time:  3:24 PM
*/
$pageName = "Update Content";
session_start();
require_once "header.php";

$showForm = 1;
$errExists = 0;

checkLogin();

$err_title = "";
$err_details = "";

$ID = $_SESSION['ID'];

//This sets the content_ID but then overwrites it to '' after an error is encountered with form submission
//The $content_ID is then bound by the $_POST['content_ID'] after an error is encountered with submission
$content_ID = isset($_GET['content_ID']) ? $_GET['content_ID'] : '';



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //Form variables
    $title = trim($_POST['title']);
    $details = $_POST['details'];
    $content_ID = isset($_POST['content_ID']) ? $_POST['content_ID'] : $content_ID;



    $sql = "SELECT title FROM content WHERE title = :title AND ID != :content_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':content_ID', $content_ID);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['title'])) {
        $dup_title = $row['title'];
    } else {
        $dup_title = '';
    }


    //Error checking
    if (empty($title) || $_POST['title'] == "") {
        $errExists = 1;
        $err_title = "Missing a title.<br>";
    }

    if (empty($_POST['details'])) {
        $errExists = 1;
        $err_details = "Missing the details.<br>";
    }


    //Select the number of rows that == the $title
//    if (!empty($_POST['title'])){
//        $sql = "SELECT COUNT(*) FROM content WHERE title = :title AND ID != :content_ID";
//        $stmt = $pdo->prepare($sql);
//        $stmt->bindValue(':title', $title);
//        $stmt->bindValue(':content_ID', $content_ID);
//        $stmt->execute();
//        $count = $stmt->fetchColumn();
//        if ($count > 0) {
//            $errExists = 1;
//            $err_title = "Title already exists. Please choose a different title.";
//        }
//    }elseif (empty($_POST['title']) || $_POST['title'] == "") {
//        $errExists = 1;
//        $err_title = "Missing a title.<br>";
//    }elseif ($title != $dup_title) {
//        $dupetitle = check_duplicates_title($pdo, $title, $content_ID);
//        if ($dupetitle && $dupetitle != $title){
//            $errExists = 1;
//            $err_title = "<span class = 'error'>That title is taken. Please choose a new title.</span>";
//        }
//    }

    if (empty($_POST['details'])) {
        $errExists = 1;
        $err_details = "Missing the details.<br>";
    }


    if ($errExists == 1) {
        echo "<p class='error'>There are errors with your submission. Please make changes and re-submit.</p>";

        //content_ID is not making it back into form if duplicate title is submitted


    } else {
        $added = date("Y-m-d h:i");

        //Updating the content in the content database
        $sql = "UPDATE content SET title = :title, details = :details, creationDate = :added WHERE ID = :content_ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':details', $details);
        $stmt->bindValue(':added', $added);
        $stmt->bindValue(':content_ID', $content_ID);
        $stmt->execute();

        $showForm = 0;
        echo "<p class='success'>Content updated successfully.</p>";
    }
}//submit


if($showForm == 1){
    //$content_ID = $_GET['content_ID'];

    if (isset($_GET['content_ID'])) {
        $content_ID = $_GET['content_ID'];
    }else {
        $content_ID = $_POST['content_ID'];
    }

    //This sets the content_ID but then overwrites it to '' after an error is encountered with form submission
    //$content_ID = isset($_GET['content_ID']) ? $_GET['content_ID'] : '';

    $sql = "SELECT content.title, content.details, content.ID FROM content JOIN users ON content.userID = users.ID WHERE content.ID = :content_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':content_ID', $content_ID);
    $stmt->execute();
    $row = $stmt->fetch();

    ?>

    <p>Fill out each field to update your content.</p>


    <form name="Update Content" id="contentupdate" method="post" action="contentupdate.php">
        <label for="title"><strong>Title:</strong></label><span class="error"> <?php echo $err_title;?></span><br>
        <input type="text" id="title" name="title" placeholder="Enter a title:" size="45" value="<?php if(isset($title)){ echo htmlspecialchars($title);} else { echo htmlspecialchars($row['title']);}?>">
        <br>

        <label for="details"><strong>Details:</strong></label><span class="error"> <?php echo $err_details;?></span><br>
        <textarea name="details" id="details" placeholder="Enter the details here:"><?php if (isset($details)) { echo htmlspecialchars($details); } else { echo htmlspecialchars($row['details']);}?> </textarea>
        <br>

        <input type="hidden" name="content_ID" value="<?php echo $content_ID; ?>">

        <label for="submit"></label> <input type="submit" name="submit" id="submit" value="submit">
    </form>

    <?php
}
require_once "footer.php";
?>