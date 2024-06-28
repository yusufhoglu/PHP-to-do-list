<?php  
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        include '../config.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO `user` (`username`, `password`) VALUES (?, ?)");
        
        if(!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $hashed_password);
        try{
         
            $stmt->execute();
        
        }catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
        if($stmt->error) {
            die("Execute failed: " . $stmt->error);
        }
        
        header("Location: ./log_in.php");
        exit();
    }

?>