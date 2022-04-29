<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = htmlspecialchars($_POST['email']);
        include "../connect.php";
        $stat = $connection->prepare("SELECT * FROM users WHERE email = :email");
        $stat->bindParam(':email', $email);
        if ($stat->execute())
        $users = $stat->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($users) > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
?>