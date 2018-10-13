<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="plotly-latest.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
    
        <?php
        
        
        try{
    $pdo = new PDO("mysql:host=localhost;dbname=id3169691_pd_db", "id3169691_admin", "id3169691_pd_dbPaSS");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
 
// Table to hold data from XML file reached via provided API
try{
    // create prepared statement
    $sql = "DROP TABLE IF EXISTS temp_metadata;
        CREATE TABLE temp_metadata (
      `test_sessionID` int NOT NULL,
      `therapyID` int(10),
      `User_IDmed` varchar(10),
      `User_IDpatient` text,
      `medicineID` varchar(10),
      `therapy_listID` varchar(10),
      `testID` varchar(10),
      `test_datetime` varchar(10),
      `DataURL` varchar(10)
    )";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute();
   
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

    $db = new mysqli('localhost', 'id3169691_admin', 'id3169691_pd_dbPaSS', 'id3169691_pd_db');
     
     //work in progress, intended to use provided API to distribute requested data into table and output a .csv file
//$completeurl = "http://vhost11.lnu.se:20090/final/getFilterData.php?parameter=User_IDpatient&value=3";
//$xml = simplexml_load_string(file_get_contents($completeurl));

        
define("DB_HOST", "localhost");
define("DB_USER", "id3217783_admin");
define("DB_PASS", "id3217783Pass");
define("DB_NAME", "id3217783_pd_db");

try {    
//PDO connection to the database
$dbc = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset-utf8",DB_USER,DB_PASS);
}catch(PDOException $e){ echo $e->getMessage();}

if($dbc <> true){
    die("<p>Error!</p>");
    
}
$print = ""; 
//Select items that fit criteria from database. UserID can be applied in a clause to specify data to return
$stmt = $dbc->query("SELECT Therapy.*, Therapy.*, Test.*, Test_Session.*, Note.*
FROM Therapy
  LEFT JOIN Test
        ON Test.Therapy_IDtherapy = Therapy.therapyID
    LEFT JOIN Test_Session
        ON Test_Session.Test_IDtest = Test.testID
    LEFT JOIN Note
        ON Note.User_IDmed = Test_Session.Test_IDtest
        WHERE Therapy.User_IDpatient = $userID;");
$stmt->setFetchMode(PDO::FETCH_OBJ);

if($stmt->execute() <> 0)
{


    $print .= '<table border="1px">';
    $print .= '<th>Patient ID</th>';
    $print .= '<th>Therapy ID</th></th>';
    $print .= '<th>Test ID</th></th>';
    $print .= '<th>Test session ID</th></th>';
    $print .= '<th>Time/Date</th></th>';
    $print .= '<th>Data</th></th>';
    $print .= '<th>Note</th></th>';
    $print .= '<th>Test type</th></th>';
    

    while($names = $stmt->fetch()) // loop and display the items
    {

        $print .= '<tr>';
        $print .= "<td>{$names->User_IDpatient}</td>";
        $print .= "<td>{$names->therapyID}</td>";
        $print .= "<td>{$names->testID}</td>";
        $print .= "<td>{$names->test_SessionID}</td>";
        $print .= "<td>{$names->dateTime}</td>";
        $print .= "<td>{$names->DataURL}</td>";
        $print .= "<td>{$names->note}</td>"; 
        $print .= "<td>{$names->type}</td>";
        $print .= '</tr>';
    }   
    $print .= "</table>";
    echo $print;  

}


?>


</form>
        
      
        

      
      
     <script>

     
       
        
    </body>
</html>
