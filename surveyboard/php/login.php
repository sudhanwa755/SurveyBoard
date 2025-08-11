<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            header("Location: ../dashboard.php");
            exit;
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='../index.html';</script>";
        }
    } else {
        echo "<script>alert('Email not found.'); window.location.href='../index.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
