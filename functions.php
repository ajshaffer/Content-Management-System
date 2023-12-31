<?php

/* 
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  1/30/23
  * Time:  2:12 PM
*/
function check_duplicates($pdo, $sql, $field)
{
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':field', $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function checkLogin()
{
    if (!isset($_SESSION['ID'])) {
        echo "<p class='error'>This page requires authentication.  Please log in to view details.</p>";
        require_once "footer.php";
        exit();
    }
}