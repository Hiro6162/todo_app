<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'to-do_app';
    $port = 3307; // or 3306 depending on your XAMPP

    $conn = new mysqli($host, $user, $pass, $db, $port);

    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

?>