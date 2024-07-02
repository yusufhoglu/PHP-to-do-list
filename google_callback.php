<?php
session_start();   
require_once 'google_client.php';

include 'config.php';
// Google Client oluşturma
$client = getGoogleClient();

if (isset($_GET['code'])) {
    try {
        // Access token almayı dene
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        // Hata varsa günlüğe kaydet
        if (isset($token['error'])) {
            throw new Exception('Error fetching access token: ' . $token['error_description']);
        }

        // Access token'i ayarla
        $client->setAccessToken($token['access_token']);

        // OAuth 2.0 hizmetini oluşturma
        $oauth2 = new Google_Service_Oauth2($client);
        $userinfo = $oauth2->userinfo->get();

        // Kullanıcı bilgilerini al ve oturuma kaydet
        $_SESSION['user_email'] = $userinfo->email;
        $_SESSION['user_name'] = $userinfo->name;

        // Kullanıcı veritabanı ilişkiisi 
        $stmt = $conn->prepare("SELECT * FROM `user` WHERE `username` = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('s',$_SESSION['user_email']);
        try{
         
            $stmt->execute();
        
        }catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }

        if($stmt->error) {
            die(" Execute failed: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_assoc($result)){
                $_SESSION['user_id'] = $row['user_id'];
                header('Location: ./to_do.php');
                exit();
            }
        }
        $stmt = $conn->prepare("INSERT INTO `user` (`username`) VALUES (?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('s',$_SESSION['user_email']);
        try{
         
            $stmt->execute();
        
        }catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }

        if($stmt->error) {
            die(" Execute failed: " . $stmt->error);
        }

        $userid = $conn->insert_id;
        $_SESSION['user_id'] = $userid;

        // Ana sayfaya yönlendirme
        header('Location: ./to_do.php');
        exit();
    } catch (Exception $e) {
        echo 'Hata: ' . $e->getMessage();
    }
} else {
    echo 'Authorization code not received';
}