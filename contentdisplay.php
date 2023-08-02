<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  1/30/23
  * Time:  2:12 PM
*/

$pageName = "Home";
session_start();
require_once "header.php";

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'title';


$sql = "SELECT title, ID FROM content ORDER BY $sort_by ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>Community Content</h1>

<?php
if (count($contents) > 0) {
    echo "<ul>";
    foreach ($contents as $content) {
        echo "<li><a href='contentview.php?content_ID=" . $content['ID'] . "'>" . $content['title'] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "<p>No content entries found.</p>";
}

?>

<form method="get" action="">
    <label for="sort_by">Sort by:</label>
    <select name="sort_by" id="sort_by">
        <option value="title">Title</option>
        <option value="creationDate">Date Created</option>
    </select>
    <input type="submit" value="Sort">
</form>



<?php
require_once "footer.php";
?>
