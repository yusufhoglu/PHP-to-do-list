<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/log_in.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $nested_id = $_POST['nested_id'];
    $user_id = $_SESSION['user_id'];
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO `to-do` (`name`, `nested_id`,`user_id`) VALUES (?, ?, ?)");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("sii",$title, $nested_id, $user_id);
    
    // Execute the statement
    try{
        
        $stmt->execute();
    
    }catch(Exception $e)
    {
        echo "Error: " . $e->getMessage();
    }
    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }
    
    // Redirect to the index page
    header('Location: to_do.php?id='. $nested_id);
    exit();
}
?>
