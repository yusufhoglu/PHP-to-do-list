<?php
session_start();
session_destroy();
header('Location: ./login/log_in.php');
exit();
?>