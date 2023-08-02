<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  4/14/23
  * Time:  3:06 PM
*/

$pageName = "Manage Content";
session_start();
require_once "header.php";

checkLogin();

$showForm = 1;
$errExists = 0;


//if($showForm == 1){
$sql = "SELECT ID, title, userID FROM content ORDER BY title ASC ";
$stmt = $pdo->prepare($sql);
$stmt->execute();


?>
<h1>Manage Your Content</h1>

<?php

if ($stmt->rowCount() > 0) {
    echo "<table><tr><th>Options</th><th>ID</th><th>Title</th></tr>";


    while ($row = $stmt->fetch()) {
        $user_ID = $row['userID'];

        if ($_SESSION['ID'] != $user_ID) {
            echo "<tr><td><a href='contentview.php?content_ID=" . $row['ID'] . "'>View</a></td><td>" . $row['ID'] . "</td><td>" . $row['title'] . "</td></tr>";

        } elseif ($_SESSION['ID'] == $user_ID) {
            $ID = $row['ID'];
            echo "<tr><td><a href='contentview.php?content_ID=" . $row['ID'] . "'>View</a>
                                <a href='contentupdate.php?content_ID=" . $row['ID'] . "'>Update</a>
                                <a href='contentdelete.php?content_ID=" . $row['ID'] . "'>Delete</a></td>
                            <td>" . $row['ID'] . "</td><td>" . $row['title'] . "</td></tr>";


        } else {
            echo "Both conditions false.";
        }
    }
    echo "</table>";
} else {
    echo "0 results";
}



?>


<?php
//}
require_once "footer.php";
?>
