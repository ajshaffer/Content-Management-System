<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/14/23
  * Time:  3:22 PM
*/

$pageName = "View Content";
session_start();
require_once "header.php";


if (isset($_GET['content_ID'])) {
    $content_ID = $_GET['content_ID'];

    $sql = "SELECT content.title, users.fname, users.lname, content.creationDate, content.updatedDate, content.details, content.image_filename FROM content JOIN users ON content.userID = users.ID WHERE content.ID = :content_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':content_ID', $content_ID);
    $stmt->execute();
    $row = $stmt->fetch();

    $title = $row['title'];
    $full_name = $row['fname'] .  " " . $row['lname'];
    $added = $row['creationDate'];
    $updated = $row['updatedDate'];
    $details = $row['details'];
    $image_path = $row['image_filename'];

}else {
    $sql = "SELECT content.title, users.fname, users.lname, content.creationDate, content.updatedDate, content.details FROM content JOIN users ON content.userID = users.ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();

    $title = $row['title'];
    $full_name = $row['fname'] . " "  . $row['lname'];
    $added = $row['creationDate'];
    $updated = $row['updatedDate'];
    $details = $row['details'];

}


?>
<h3>Here is your content</h3>

<?php

if ($stmt->rowCount() > 0) {
    echo "<table>
            <tr>
                <td><strong>Title:</strong></td>
                <td>" . $title . "</td>
            </tr>
            <tr>
                <td><strong>Author:</strong></td>
                <td>" . $full_name . "</td>
            </tr>
            <tr>
                <td><strong>Date Published:</strong></td>
                <td>" . $added . "</td>
            </tr>
            <tr>
                <td><strong>Date Updated:</strong></td>
                <td>" . $updated . "</td>
            </tr>
            <tr>
                <td><strong>Details:</strong></td>
                <td>" . $details . "</td>
            </tr>";
    echo "</table>";

    if (!empty($image_path)) {
        echo "<p><strong>A user-uploaded picture:</strong></p>";
        $image_name = basename($image_path);
        $image_url = "https://ccuresearch.coastal.edu/ajshaffer/csci303sp23/uploads/" . $image_name;
        echo '<img src="' . $image_url . '" alt="Uploaded image" style="width: auto; height: 500px";>';
    }
}







?>



<?php
require_once "footer.php";
?>
