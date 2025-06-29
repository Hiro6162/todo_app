<?php
    session_start();
    include '../includes/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result(); // Required to check num_rows

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed);
            $stmt->fetch();

            if (password_verify($password, $hashed)) {
                $_SESSION['user_id'] = $id;
                header("Location: ../public/index.php");
                exit;
            } else {
                echo "❌ Invalid email or password.";
            }
        } else {
            echo "❌ User not found.";
        }

        $stmt->close();
        $conn->close();
    }
?>

<form method="POST">
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
