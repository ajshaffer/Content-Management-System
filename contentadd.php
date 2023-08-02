<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/14/23
  * Time:  1:18 PM
*/


$pageName = "Add Content";
session_start();
require_once "header.php";

checkLogin();

$ID = $_SESSION['ID'];

$showForm = 1;
$errExists = 0;

//Error variables
$err_title = "";
$err_details = "";
$err_image = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //Form variables
    $title = trim($_POST['title']);
    $details = $_POST['details'];
    $image = $_FILES['myfile'];

    //Error checking
    if (empty($title)) {
        $errExists = 1;
        $err_title = "Missing a title.<br>";
    }

    if (empty($details)) {
        $errExists = 1;
        $err_details = "Missing the details.<br>";
    }

    if ($image['error'] != UPLOAD_ERR_OK) {
        $errExists = 1;
        $err_image = "Error uploading image.<br>";
    }

    if ($_FILES['myfile']['error'] != 0) {
        $errExists = 1;
        $errFile = "Error uploading file.";
    } else {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $pinfo = pathinfo($_FILES['myfile']['name']);
        $dirname = $pinfo['dirname'];
        $basename = $pinfo['basename'];
        $extension = $pinfo['extension'];
        $filename = $pinfo['filename'];
        $newfile = strtolower("ajshaffer" . date('YmdHis') . "." . $pinfo['extension']);
        $filepath = "/var/students/ajshaffer/csci303sp23/uploads/" . $newfile;

        if (file_exists($filepath)) {
            $errExists = 1;
            $errFile = "<p class='error'>File already exists.<p>";
        } else {
            if (!move_uploaded_file($_FILES['myfile']['tmp_name'], $filepath)){
                $errExists = 1;
                $errFile = "File cannot be moved.";
            }
        }
    }

    if ($errExists == 1) {
        echo "<p class='error'>There are errors with your submission. Please make changes and re-submit.</p>";
    } else {
        $creationDate = date("Y-m-d h:i");

        $sql = "INSERT INTO content (title, details, creationDate, userID, updatedDate, image_filename) VALUES (:title, :details, :creationDate, :userID, :updatedDate, :image)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userID', $ID);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':details', $details);
        $stmt->bindValue(':creationDate', $creationDate);
        $stmt->bindValue(':updatedDate', $creationDate);
        $stmt->bindValue(':image', $filepath);
        $stmt->execute();

        echo "<p class='success'>Content submitted successfully.</p>";
        $showForm = 0;
    }
}

if ($showForm == 1){
    ?>
    <h1>Create a Post</h1>
    <p>Fill out each field to add your content.</p>

    <form name="Add Content" id="addcontent" method="post" action="contentadd.php" enctype="multipart/form-data">
        <label for="title"><strong>Title:</strong></label><span class="error"> <?php echo $err_title;?></span><br>
        <input type="text" id="title" name="title" placeholder="Enter a title:" size="45" value="<?php if(isset($title)){ echo htmlspecialchars($title);}?>">
        <br>

        <label for="details"><strong>Details:</strong></label><span class="error"> <?php echo $err_details;?></span><br>
        <textarea name="details" id="details" placeholder="Enter the details here:"><?php if (isset($details)) { echo $details; }?> </textarea>
        <br>

        <label for="image"><strong>Image:</strong></label><span class="error"> <?php echo $err_image;?></span><br>
        <input type="file" name="myfile" id="myfile">
        <br>

        <label for="submit"></label> <input type="submit" name="submit" id="submit" value="submit">
    </form>
    <?php
}
require_once "footer.php";
?>
