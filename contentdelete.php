<?php

/*
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/14/23
  * Time:  3:22 PM
*/

$pageName = "Delete Content";
session_start();

require_once "header.php";

checkLogin();

$showForm = 1;
$errExists = 0;
$content_ID = isset($_GET['content_ID']) ? $_GET['content_ID'] : '';


if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $sql = "DELETE FROM content  WHERE ID = :content_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':content_ID', $_POST['content_ID']);
    $stmt->execute();

    $showForm = 0;
    echo "<p class='success'>The title was deleted successfully.</p>";

    header("contentmanage.php");
    exit();

}//submit

if($showForm == 1){

    $sql = "SELECT * FROM content WHERE ID = :content_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':content_ID', $content_ID);
    $stmt->execute();
    $row = $stmt->fetch();

    $title = $row['title'];
    ?>
    <h3>Are you sure you want to delete this content?</h3>

    <?php
    echo "<table>
            <tr>
                <td><strong>Title:</strong></td>
                <td>" . $title . "</td>
            </tr>";
    echo "</table>";
    ?>

    <form name="Delete Content" id="deletecontent" method="post" action="contentdelete.php">
        <label for="submit"></label> <input type="submit" name="submit" id="submit" value="submit">
        <input type="hidden" name="content_ID" value="<?php echo $content_ID; ?>">
    </form>


    <?php
}
require_once "footer.php";
?>
