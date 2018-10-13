<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

include 'src/autoload.php';

$config = [
    'callback' => 'https://jakubnilsson.000webhostapp.com/linkedin_login.php',

    'providers' => [
        'LinkedIn' => [
            'enabled' => true,
            'keys' => [
                'key'    => '863cdohj8lbijq',
                'secret' => 'deTOVj5qz5N3gmED'
            ]
        ]
    ]
];

try{
  $hybridauth = new Hybridauth\Hybridauth($config);
  $adapter = $hybridauth->authenticate('LinkedIn');
  $isConnected = $adapter->isConnected();
  $userProfile = $adapter->getUserProfile();
  $adapter->disconnect();
  $patientEmail = 'x@gmail.com';
  echo "<p>Hello, ".$userProfile->firstName."! You are seeing this page the way you would if your email was ".$patientEmail. "</p>";

}


catch(\Exception $e){
  echo 'Oops, something went wrong! ' . $e->getMessage();
}

//session_start();
$servername = "localhost";
$username = "id3169691_admin";
$password = "id3169691_pd_dbPaSS";
//echo $username;
$dbname = "id3169691_pd_db";
/* $connection = mysqli_connect("localhost", "id3169691_admin", "id3169691_pd_dbPaSS", "id3169691_pd_db");
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, $username);
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
//if (isset($_POST['username']) and isset($_POST['password'])){
  //3.1.1 Assigning posted values to variables.
//  $username = $_POST['username'];
 // $password = $_POST['password'];
  //3.1.2 Checking the values are existing in the database or not
  $query = "SELECT * FROM `User` WHERE email='$patientEmail'";
  
  $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
  $count = mysqli_num_rows($result);
  //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
  if ($count == 1){
  $userID  = "SELECT 'userID' FROM `User` WHERE email='$patientEmail'";
  $_SESSION['userID'] =  $userID;
  }else{
  //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
  $fmsg = "Invalid Login Credentials.";
  }
  
  //3.1.4 if the user is logged in Greets the user with message
  if (isset($_SESSION['userID'])){
  $userID = $_SESSION['userID'];
  echo "Hai " . $userID . "
  ";
  echo "This is the Members Area
  ";
  echo "<a href='logout.php'>Logout</a>";
   
  } */

  //3.2 When the user visits the page first time, simple login form will be displayed.
 




$playlistId =  "PL5jg5UxfmH0iPoRulWl5YPI9DmXCZY-oW";
$api_url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=PL5jg5UxfmH0iPoRulWl5YPI9DmXCZY-oW&key=AIzaSyC-umxprvRevENiX529ziwPi72nHpkIHlw";

$data = json_decode(file_get_contents($api_url));
?>

<script src="jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="container">
<div class="row" style="margin-top:50px;">
<div class="col-xs-12 col-md-8 col-sm-8 video-container">
<iframe width="100%" height="450px" src="https://www.youtube.com/embed/<?php echo $data->items[0]->snippet->resourceId->videoId;?>"
  frameborder="0" allowFullscreen="">
</iframe>
</div>

<div class="col-xs-12 col-md-4 col-sm-4" style="padding:0px;background-color:#cc;"> 
<ul style="padding:0px">
<?php
  foreach($data->items as $video){
    $title = $video->snippet->title;
    $description = $video->snippet->description;
    $thumbnail = $video->snippet->thumbnails->high->url;
    $videoId = $video->snippet->resourceId->videoId;
    $date = $video->snippet->publishedAt;

//  }
 ?>



   <li>
   <span style="cursor:pointer;margin-bottom:10px;" onclick="switchVideo('<?php echo $videoId;?>');">
     <div class="col-xs-12" id="vid<?echo $videoId;?>" style="padding-right:0px;padding-top:8px;padding-bottom:1px solid white;">
     <div style="padding-left:0px;" class="image col-md-4 col-lg-4">
       <img src="https://i.ytimg.com/vi/<?php echo $videoId;?>/default.jpg">
     </div>
     <div class="text col-md-8 col-lg-8">
       <?php echo $title;?>
       <p class="date"><?php echo date('M j, Y',strtotime($date));?></p>
     </div>
     </div>
  </span>
</li>
<?php } ?>
</ul>
</div>
</div>
</div>


<script>
$("#vid-<?php echo $data->items[0]->snippet->resourceId->videoId;?>").addClass('selected');

function switchVideo(videoId){
  $(".video-container iframe").attr('src', 'https://www.youtube.com/embed/' + videoId);
  $(".selected").removeClass('selected');
  $("#vid-"+videoId).addClass('selected');

}

</script>

<?php

// $servername = "localhost";
// $username = "id3169691_admin";
// $password = "id3169691_pd_dbPaSS";
// $dbname = "id3169691_pd_db";

// Get userID from email
$db = new PDO('mysql:host=localhost;dbname=id3169691_pd_db', 'id3169691_admin', 'id3169691_pd_dbPaSS');
$sql = 'SELECT userID FROM User WHERE email = :patientEmail';
$select = $db->prepare($sql);
$select->bindParam(':patientEmail', $patientEmail, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$userID = $row['userID'];

include 'patient_content.php';


