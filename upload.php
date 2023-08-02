<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/10/23
  * Time:  2:39 PM
*/

$pageName = "File Uploads";
require_once "header.php";

$showForm = 1;  // show form is true
$errExists = 0; // initially no errors
$errFile = ""; // initially no error

if ($_SERVER['REQUEST_METHOD'] == "POST") {

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
        echo "<p class='error'>Errors Exist!</p>";
    } else {
        echo "<p class='success'>Success!</p>";
        echo "<p>View your file: <a href='/ajshaffer/csci303sp23/uploads/" . $newfile . "' target='_blank''>" . $newfile . "</a></p>";
    }
}

if ($showForm == 1) {
    ?>
    <h3>Upload File Form</h3>
    <form name="upload" id="upload" method="post" action="<?php echo $currentFile;?>" enctype="multipart/form-data">
        <?php if (!empty($errFile)) {echo "<span class='error'>" . $errFile . "</span>";}?>
        <label for="myfile">Upload Your File:</label><input type="file" name="myfile" id="myfile">
        <br>
        <label for="submit">Submit:</label><input type="submit" name="submit" id="submit" value="UPLOAD">
    </form>
    <?php
}

require_once "footer.php";
?>
