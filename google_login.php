<?php
session_start();

include 'login.php';
include 'content.php';
$connection= mysqli_connect( "localhost", "id3217783_admin", "id3217783Pass", "id3217783_pd_db" );
$servername = "localhost";
$username = "id3217783_admin";
$password = "id3217783Pass";
$dbname = "id3217783_pd_db";
//get user ID
$db = new PDO('mysql:host=localhost;dbname=id3169691_pd_db', 'id3169691_admin', 'id3169691_pd_dbPaSS');
$sql = 'SELECT userID FROM User WHERE email = :researcherEmail';
$select = $db->prepare($sql);
$select->bindParam(':researcherEmail', $researcherEmail, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$userID = $row['userID'];
$userID = $_SESSION['userID'];

