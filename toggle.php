<?php
    // DB AND AUTH CONNECTION
    include '../includes/auth.php';
    include '../includes/db.php';

    $id = $_GET["id"];
    $conn->query("UPDATE tasks SET status = IF(status='pending', 'completed', 'pending') WHERE id = $id AND user_id = " . $_SESSION['user_id']);
    header("Location: ../public/index.php");
?>