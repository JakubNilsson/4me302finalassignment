<?php
error_reporting(E_ALL ^ E_DEPRECATED);

// Make sure SimplePie is included. You may need to change this to match the location of autoloader.php
// For 1.0-1.2:
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
#require_once('../simplepie.inc');
// For 1.3+:
require_once('php/autoloader.php');
 
// We'll process this feed with all of the default options.
$feed = new SimplePie();
 
// Set which feed to process.
//$medicalFeed = "http://www.news-medical.net/tag/feed/Parkinsons-Disease.aspx";
$feed-> set_feed_url('http://www.news-medical.net/tag/feed/Parkinsons-Disease.aspx');
// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="plotly-latest.min.js"></script>

        <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      div.item {
		padding:5px 0;
		border-bottom:1px solid #999;
	}
  a:hover {
		background-color:#333;
		color:#fff;
		text-decoration:none;
	}
  a {
		color:#326EA1;
		text-decoration:underline;
		padding:0 1px;
	}

      html, body {
        height: 100%;

        padding: 0;
        margin:50px auto;
		padding:0;
      }
    </style>
    </head>
    <body>

        <?php
$researcherEmail = 'res@uni.se' ;

define("DB_HOST", "localhost");
define("DB_USER", "id3217783_admin");
define("DB_PASS", "id3217783Pass");
define("DB_NAME", "id3217783_pd_db");

try {
//PDO connection to the database
$db = new PDO('mysql:host=localhost;dbname=id3169691_pd_db', 'id3169691_admin', 'id3169691_pd_dbPaSS');
$sql = 'SELECT userID FROM User WHERE email = :researcherEmail';
$select = $db->prepare($sql);
$select->bindParam(':researcherEmail', $researcherEmail, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$userID = $row['userID'];


$dbc = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset-utf8",DB_USER,DB_PASS);
}catch(PDOException $e){ echo $e->getMessage();}

if($dbc <> true){
    die("<p>Error!</p>");

}
$print = "";
//Select items that fit criteria from database, this time without WHERE clause
$stmt = $dbc->query("SELECT Therapy.*, Therapy.*, Test.*, Test_Session.*, Note.*
FROM Therapy
  LEFT JOIN Test
        ON Test.Therapy_IDtherapy = Therapy.therapyID
    LEFT JOIN Test_Session
        ON Test_Session.Test_IDtest = Test.testID
    LEFT JOIN Note
        ON Note.User_IDmed = Test_Session.Test_IDtest");

        
$stmt->setFetchMode(PDO::FETCH_OBJ);

if($stmt->execute() <> 0)
{

    $print .= '<table border="1px">';
    $print .= '<th>Patient ID</th>';
    $print .= '<th>Physician ID</th>';
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
        $print .= "<td>{$names->User_IDmed}</td>";
        $print .= "<td>{$names->therapyID}</td>";
        $print .= "<td>{$names->testID}</td>";
        $print .= "<td>{$names->test_SessionID}</td>";
        $print .= "<td>{$names->dateTime}</td>";

        $print .= "<td> <form method='POST'>
                <input id='edit' type='button' name='action' value='$names->DataURL' onclick='makeplot(this.value);' />
                    </post>
               </td>";
        $print .= "<td>{$names->note}</td>";
        $print .= "<td>{$names->type}</td>";
        $print .= '</tr>';

    }
    $print .= "</table>";
    echo $print;

}


?>
   <form action="insert.php" method="post">
  <h1>Add note to data:</h1>
    <p>
    <select name="dataID">
      <option value="Data1">Data1</option>
      <option value="Data2">Data2</option>
      <option value="Data3">Data3</option>
      <option value="Data4">Data4</option>
      <option value="Data5">Data5</option>
      <option value="Data6">Data6</option>
    </select>
        
        <label for="note">note</label>
        <input type="text" name="dataNote" id="dataNote">
    </p>
    <p>
        <label for="researcherID">Researcher ID:</label>
        <input type="text" value="<?= $userID ?>" name="researcherID" id="researcherID" readonly>
    </p>
    <input type="submit" value="Submit">

    <?php
$username="id3169691_admin";
$password="id3169691_pd_dbPaSS";
$database="id3169691_pd_db";
$servername = "localhost";
$dbname = "id3169691_pd_db";

$connect = ("$servername, $username, $password, $dbname") or die ("ERROR DURING CONNECTION");





?>




     <div id="myDiv" style="width: 480px; height: 400px;"> </div>
     <script>

     function makeplot(val) {

    //assign the result the value of (dataX - data)
    var result = val.substring(4);
    //execute different functions based on if result is odd or even
    if(result % 2 === 0)

    {


        Plotly.d3.csv(val+".csv", function(data){ processData2(data) } );
    }
    else{
    Plotly.d3.csv(val+".csv", function(data){ processData(data) } );

    }

};



function processData(allRows) {

  console.log(allRows);
  var x = [], y = [];

  for (var i=0; i<allRows.length; i++) {
    row = allRows[i];
    x.push( row['X'] );
    y.push( row['Y'] );
  }
  console.log( 'X',x, 'Y',y);
  makePlotly( x, y);
}

function processData2(allRows) {

  console.log(allRows);
  var x = [], y = [];

  for (var i=0; i<allRows.length; i++) {
    row = allRows[i];
    x.push( row['X'] );
    y.push( row['Y'] );
  }
  console.log( 'X',x, 'Y',y);
  makePlotly2( x, y);
}

function makePlotly( x, y ){
  var plotDiv = document.getElementById("plot");
  var traces = [{
    x: x,
    y: y,
    mode: 'lines',
    line: {
    color: 'rgb(25, 12, 18)',
    width: 3
  },
  type: 'scatter'
	}]
	;



var layout = {
  xaxis: {
   // range: [ 0, 205 ]
  },
  yaxis: {
  //  range: [0, 70]
  },
  title:''
};

  Plotly.newPlot('myDiv', traces,
    {title: 'Spiral drawing result'});
};

function makePlotly2( x, y ){
  var plotDiv = document.getElementById("plot");
  var traces = [{
    x: x,
    y: y,
    mode: 'markers',
  type: 'scatter'
	}]
	;



var layout = {
  xaxis: {
   // range: [ 0, 205 ]
  },
  yaxis: {
  //  range: [0, 70]
  },
  title:''
};

  Plotly.newPlot('myDiv', traces,
    {title: 'Tapping excercise results'});
};
  makeplot();

//
     </script>

<?php
//retrieve patient location
//require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node


// Opens a connection to a MySQL server
//require("id3169691_admin-id3169691_pd_db");

$username="id3169691_admin";
$password="id3169691_pd_dbPaSS";
$database="id3169691_pd_db";

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "SELECT * FROM User WHERE Role_IDrole = 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

//header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  //$dom->documentURI = "markerz.xml";
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['userID']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);

}
 // save XML as string or file 
 $test1 = $dom->saveXML(); // put string in test1
 $dom->save('test1.xml'); // save as file
echo $dom->saveXML();
?>


<h1>Locate patients:</h1>
     <div id="map"></div>
    
       <script>
         var customLabel = {
           restaurant: {
             label: 'R'
           },
           bar: {
             label: 'B'
           }
         };

           function initMap() {
           var map = new google.maps.Map(document.getElementById('map'), {
             center: new google.maps.LatLng( 58.48676, -40.51406),
             zoom: 1
           });
           var infoWindow = new google.maps.InfoWindow;

             // Change this depending on the name of your PHP or XML file
             downloadUrl('https://jakubnilsson.000webhostapp.com/test1.xml', function(data) {
               var xml = data.responseXML;
               var markers = xml.documentElement.getElementsByTagName('marker');
               Array.prototype.forEach.call(markers, function(markerElem) {
                 var id = markerElem.getAttribute('id');
                 var name = markerElem.getAttribute('name');
                 var address = markerElem.getAttribute('address');
                 var type = markerElem.getAttribute('type');
                 var point = new google.maps.LatLng(
                     parseFloat(markerElem.getAttribute('lat')),
                     parseFloat(markerElem.getAttribute('lng')));

                 var infowincontent = document.createElement('div');
                 var strong = document.createElement('strong');
                 strong.textContent = "Patient, user ID: "+ id
                 infowincontent.appendChild(strong);
                 infowincontent.appendChild(document.createElement('br'));

                 var text = document.createElement('text');
                 text.textContent = address
                 infowincontent.appendChild(text);
                 var icon = customLabel[type] || {};
                 var marker = new google.maps.Marker({
                   map: map,
                   position: point,
                   label: icon.label
                 });
                 marker.addListener('click', function() {
                   infoWindow.setContent(infowincontent);
                   infoWindow.open(map, marker);
                 });
               });
             });
           }



         function downloadUrl(url, callback) {
           var request = window.ActiveXObject ?
               new ActiveXObject('Microsoft.XMLHTTP') :
               new XMLHttpRequest;

           request.onreadystatechange = function() {
             if (request.readyState == 4) {
               request.onreadystatechange = doNothing;
               callback(request, request.status);
             }
           };

           request.open('GET', url, true);
           request.send(null);
         }

         function doNothing() {}
       </script>
       <script async defer
       src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-umxprvRevENiX529ziwPi72nHpkIHlw&callback=initMap">
       </script>

<div>
		<h1><a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title(); ?></a></h1>
		<p><?php echo $feed->get_description(); ?></p>
	</div>
 
	<?php
	/*
	Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
	*/
	foreach ($feed->get_items() as $item):
	?>
 
		<div class="item">
			<h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
			<p><?php echo $item->get_description(); ?></p>
			<p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
		</div>
 
	<?php endforeach; ?>


    </body>
</html>
