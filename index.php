<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <?php 
            $task_id = isset($_GET['id']) ? $_GET['id'] : 0;
        ?>
        <form action="add_task.php" method="POST">
            <input type="text" name="title" placeholder="Görev Başlığı" required>
            <input type="hidden" name="nested_id" value="<?php echo $task_id; ?>">
            <button type="submit">Görev Ekle</button>
        </form>
        <div class="task-list">
            <?php
                include 'config.php';
                function fetchTasks() {
                    global $conn, $task_id;

                    $stmt = $conn->prepare("SELECT * FROM `to-do` WHERE nested_id = ?");
                    $stmt->bind_param("i", $task_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<form action="delete_task.php" method="POST" id="form_' . $row['id'] . '">';
                                echo '<div class="task">';
                                    echo '<input type="hidden" name="task_id" value="' . $row['id'] . '">';
                                    echo '<input type="hidden" name="curr_id" value="' . $task_id . '">';
                                    echo '<input type="checkbox" name="is_done" onchange="submitForm(' . $row['id'] . ')">';
                                    echo '<a href="index.php?id='. $row['id']. '">' . $row['name'] . '</a>';
                                echo '</div>';
                            echo '</form>';
                        }
                    }
                }
                fetchTasks();
            ?>
        </div>
    </div>
    <script>
        function submitForm(taskId) {
            document.getElementById('form_' + taskId).submit();
        }
    </script>
</body>
</html>
