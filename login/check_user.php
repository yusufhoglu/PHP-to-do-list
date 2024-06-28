<?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        include '../config.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("SELECT * FROM `user` WHERE `username` = ?");
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param('s', $username);
        
        try{
         
            $stmt->execute();
        
        }catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }

        if ($stmt->error) {
            die("Execute failed: " . $stmt->error);
        }
        

        $result = $stmt->get_result();

        if (mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_assoc($result)){
                if(password_verify($password, $row['password'])){
                    header('Location: ../to_do.php?user_id=' . $row['user_id']);
                }else {
                    echo $password;
                    echo $row['password'];
                    echo "Wrong password";
                }   
            }
        }else {
            echo "User not found";
        }
        exit();
    }

?>