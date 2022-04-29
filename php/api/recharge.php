<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $credits = htmlspecialchars($_POST['newamount']);
        $email = $_SESSION['email'];
        include "../connect.php";
        $stat = $connection->prepare("UPDATE users SET credits = :credits WHERE email = :email");
        $stat->bindParam(':credits', $credits);
        $stat->bindParam(':email', $email);
        if ($stat->execute()) {
            $_SESSION['credits'] = $credits;
            echo 'true';
        } else echo 'false';
    }
?>