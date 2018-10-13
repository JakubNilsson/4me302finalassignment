<?php

session_start();

include 'src/autoload.php';

$config = [
    'callback' => 'https://jakubnilsson.000webhostapp.com/twitter_login.php',

    'providers' => [
        'Twitter' => [
            'enabled' => true,
            'keys' => [
                'key'    => 'BeRj2cA6D3ay0ZtBsbL42587y',
                'secret' => 'yDW9LXaALKz7b3LOnQcySoJfedAvPEjV0q5JRl69OkbaxCMK4M'
            ]
        ]
    ]
];

try{
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate('Twitter');
    $isConnected = $adapter->isConnected();
    $userProfile = $adapter->getUserProfile();
    $adapter->disconnect();
    $doctorEmail = 'doc@hospital.com';
    echo "<p>Hello, ".$userProfile->firstName."! You are seeing this page the way you would if your email was ".$doctorEmail. "</p>";
}

catch(\Exception $e){
    echo 'Oops, something went wrong! ' . $e->getMessage();
}

//get user's ID by email
$db = new PDO('mysql:host=localhost;dbname=id3169691_pd_db', 'id3169691_admin', 'id3169691_pd_dbPaSS');
$sql = 'SELECT userID FROM User WHERE email = :doctorEmail';
$select = $db->prepare($sql);
$select->bindParam(':doctorEmail', $doctorEmail, PDO::PARAM_INT);
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);
$userID = $row['userID'];

include 'physician_content.php';


    
