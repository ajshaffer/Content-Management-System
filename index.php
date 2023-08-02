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
?>

<h1>Myrtle Beach Golf Courses</h1>

<p>This website was developed as a way to keep track of the available golf courses in Myrtle Beach, SC. The features of this website allow users to
    keep track of the courses they have played through blog posts, view posts from other users regarding their experiences,
    and subscribe to monthly emails.</p>

<h3>Features:</h3>

<ul>
    <li>Home Page</li>
    <li>User Registration</li>
    <li>Add Content</li>
    <li>Content List</li>
    <li>Content Display Details</li>
    <li>Delete Content</li>
    <li>Update Profile</li>
    <li>Content Search</li>
</ul>






<?php
require_once "footer.php";
?>
