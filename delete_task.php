<?php
include 'config.php';
function deleteTaskAndSubtasks($conn, $taskId) {
    // Find all subtasks
    $sql = "SELECT id FROM `to-do` WHERE nested_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Recursively delete each subtask
    while ($row = $result->fetch_assoc()) {
        deleteTaskAndSubtasks($conn, $row['id']);
    }

    // Delete the task itself
    $stmt = $conn->prepare("DELETE FROM `to-do` WHERE id = ?");
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ./login/log_in.php");
        exit();
    }
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $curr_id = $_POST['curr_id'];
        $is_done = isset($_POST['is_done']) ? 1 : 0;
        $user_id = $_SESSION['user_id'];
        if($is_done == 1){  
            deleteTaskAndSubtasks($conn, $task_id);
        }
    }

    // İşlem tamamlandıktan sonra yönlendirme yap
    header('Location: to_do.php?id='. $curr_id );
    exit();
}
?>
