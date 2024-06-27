<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $nested_id = $_POST['nested_id'];
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO `to-do` (`name`, `nested_id`) VALUES (?, ?)");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("si",$title, $nested_id);
    
    // Execute the statement
    $stmt->execute();
    
    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }
    
    // Redirect to the index page
    header('Location: index.php?id='. $nested_id);
    exit();
}
?>
