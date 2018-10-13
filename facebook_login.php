<?php
session_start();

include 'src/autoload.php';

$config = [
    'callback' => 'https://nilssonjakub.000webhostapp.com/dashboard.php',

    'providers' => [
        'Facebook' => [
            'enabled' => true,
            'keys' => [
                'key'    => '60613670394-cmh40bkrdaqu2jakfb8j0olldpa5vdkp.apps.googleusercontent.com',
                'secret' => 'Dlm3Nf0msxcz5LwesDDQwTqe'
            ]
        ]
    ]
];

try{
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate('Facebook');

    //Returns a boolean of whether the user is connected with Twitter
    $isConnected = $adapter->isConnected();

    //Retrieve the user's profile
    $userProfile = $adapter->getUserProfile();

    //Inspect profile's public attributes
    var_dump($userProfile);

    //Disconnect the adapter
    $adapter->disconnect();
}
catch(\Exception $e){
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}