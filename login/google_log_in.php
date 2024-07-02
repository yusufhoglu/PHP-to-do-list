<?php 
    session_start();
    require_once '../google_client.php';

    // Google Client oluşturma
    $client = getGoogleClient();
    
    // Google login URL'si
    $login_url = $client->createAuthUrl();
    header('Location: ' . $login_url);
    exit()
?>
