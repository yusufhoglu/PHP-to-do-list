<?php
require_once 'vendor/autoload.php';

// Looing for .env at the root directory
if(getenv('APPLICATION_ENV') !== 'production') { 
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

function getGoogleClient() {
    $config = [
        'client_id' => $_ENV['GOOGLE_CLIENT_ID'],
        'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'] ,
        'redirect_uri' => $_ENV['GOOGLE_REDIRECT_URI']
    ];

    $client = new Google_Client();
    $client->setClientId($config['client_id']);
    $client->setClientSecret($config['client_secret']);
    $client->setRedirectUri($config['redirect_uri']);
    $client->addScope('email');
    $client->addScope('profile');

    
    return $client;
}
