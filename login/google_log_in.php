<?php 
    session_start();
    require_once '../google_client.php';

    // Google Client oluşturma
    $client = getGoogleClient();
    
    // Google login URL'si
    $login_url = $client->createAuthUrl();
?>
    <a href="<?php echo $login_url; ?>"> Google ile Giriş Yap </a>
