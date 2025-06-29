<?php
    include '../includes/auth.php';
    include '../includes/db.php';

    // Validate input
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("Invalid task ID.");
    }

    $task_id = (int) $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Use prepared statement to securely delete the task
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();

    // Optional: Check if a row was actually deleted
    if ($stmt->affected_rows > 0) {
        // Success
        header("Location: ../public/index.php?msg=deleted");
    } else {
        echo "❌ Task not found or you do not have permission to delete it.";
    }

    $stmt->close();
    $conn->close();
?>