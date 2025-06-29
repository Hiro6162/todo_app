<?php
    include '../includes/auth.php';
    include '../includes/db.php';

    $user_id = $_SESSION['user_id'];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int) $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, status = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssssii", $title, $description, $due_date, $status, $id, $user_id);
        $stmt->execute();

        header("Location: ../public/index.php");
        exit;
    }

    // Show form
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("Invalid Task ID");
    }

    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Task not found");
    }

    $task = $result->fetch_assoc();
?>

<h2>Edit Task</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= $task['id'] ?>">
    <input name="title" value="<?= htmlspecialchars($task['title']) ?>" required><br>
    <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea><br>
    <input type="date" name="due_date" value="<?= $task['due_date'] ?>"><br>
    <select name="status">
        <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
    </select><br>
    <button type="submit">Update Task</button>
</form>
<a href="../public/index.php">Cancel</a>
