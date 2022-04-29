<?php

    session_start();
    $email = $_SESSION['email'];
    include "../connect.php";
    $stat = $connection->prepare("SELECT credits FROM users WHERE email = :email");
    $stat->bindParam(':email', $email);
    if ($stat->execute()) {
        $credits = $stat->fetch(PDO::FETCH_ASSOC);
        echo json_encode($credits);
    } else echo 'false';
    
?>