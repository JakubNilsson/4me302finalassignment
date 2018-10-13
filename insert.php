<?php
$username="id3169691_admin";
$password="id3169691_pd_dbPaSS";
$database="id3169691_pd_db";
$servername = "localhost";
$dbname = "id3169691_pd_db";

$connect = mysql_connect($servername, $username, $password, $dbname) or die ("ERROR DURING CONNECTION");

$name = $_POST["dataID"];
$lastname = $_POST["researcherID"];
$radio = $_POST["dataID"];
//$sql_insert = mysql_query (INSERT INTO data_notes (id, name, lastname, radio) VALUES ('', '$name', '$lastname', '$radio', '$drop', '$check'));

//$sql_insert = mysql_query(INSERT INTO 'data_notes' (dataNoteID, dataID, researcherID, dataNote) VALUES (null, '".$name."', ".$lastname.", ".$radio.");

//$sql_insert = mysql_query(INSERT INTO 'test-table' (id, name, lastname, radio, drop, check) VALUES ('', '$name', '$lastname', '$radio', '$drop', '$check'));
//$sql_insert = mysql_query(INSERT INTO 'data_notes' (dataNoteID, dataID, researcherID, dataNote) VALUES (null, '".$name."', '".$lastname."', '".$radio.")");



?>