<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $curr_id = $_POST['curr_id'];
        $is_done = isset($_POST['is_done']) ? 1 : 0;
        if($is_done == 1){
            // Veritabanında görevin durumunu güncelle
            $stmt = $conn->prepare("DELETE FROM `to-do` WHERE `id` = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("i",$task_id);
            $stmt->execute();

            if ($stmt->error) {
                die("Execute failed: " . $stmt->error);
            }

            $stmt->close();
        }
    }
    // İşlem tamamlandıktan sonra yönlendirme yap
    header('Location: index.php?id='. $curr_id);
    exit();
}
?>
