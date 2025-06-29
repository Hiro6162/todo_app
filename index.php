<!DOCTYPE html>
<html>
<head>
    <title>To-Do App</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
    include "../includes/auth.php";
    include "../includes/db.php";

    $user_id = $_SESSION['user_id'];

    // Show success message
    $success_msg = '';
    if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
        $success_msg = "✅ Task deleted successfully.";
    }

    // Fetch tasks
    $tasks = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<h2>To-Do List</h2>
<a href="logout.php">Logout</a>

<?php if ($success_msg): ?>
    <p style="color: green; font-weight: bold;"><?= $success_msg ?></p>
<?php endif; ?>

<form method="POST" action="../tasks/add.php">
    <input type="text" name="title" placeholder="Task Title" required>
    <input type="date" name="due_date">
    <button type="submit">Add Task</button>
</form>

<ul>
    <?php while ($task = $tasks->fetch_assoc()): ?>
        <li>
            <form action="../tasks/toggle.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                <button type="submit"><?= $task['status'] === 'completed' ? '✔' : '✖' ?></button>
            </form>

            <?= htmlspecialchars($task["title"]) ?> (<?= $task["due_date"] ?>)
            <a href="../tasks/edit.php?id=<?= $task["id"] ?>">Edit</a>
            <a href="../tasks/delete.php?id=<?= $task["id"] ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
        </li>
    <?php endwhile; ?>
</ul>
