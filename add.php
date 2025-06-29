<?php 
    // AUTH AND DB CONNECTION
    include "../includes/auth.php";
    include "../includes/db.php";
    $title = $_POST['title'];
    $due = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, due_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $due);
    $stmt->execute();

    header("Location: ../public/index.php");

?>