<?php
    // BASIC REGISTRATION SCRIPT
    include "../includes/db.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            $stmt->execute();
            header("Location: ../public/login.php");

        }
?>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    
    <button type="submit"Register></button>
</form>