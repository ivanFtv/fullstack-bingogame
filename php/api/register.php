<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        include "../connect.php";
        $stat = $connection->prepare("INSERT INTO users (firstname, lastname, username, password, email) VALUES (:firstname, :lastname, :username, :password, :email)");
        $stat->bindParam(':firstname', $firstname);
        $stat->bindParam(':lastname', $lastname);
        $stat->bindParam(':username', $username);
        $stat->bindParam(':email', $email);
        $stat->bindParam(':password', $password);
        if ($stat->execute()) {
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['credits'] = 10;
            echo 'true';
        } else echo 'false';
    }
?>
