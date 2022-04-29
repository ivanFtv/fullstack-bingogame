<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bet = htmlspecialchars($_POST['money']);
        $score = htmlspecialchars($_POST['score']);
        $win = htmlspecialchars($_POST['win']);
        $email = $_SESSION['email'];
        include "../connect.php";
        $stat = $connection->prepare("INSERT INTO history (bet, result, email, win) VALUES (:bet, :score, :email, :win)");
        $stat->bindParam(':bet', $bet);
        $stat->bindParam(':score', $score);
        $stat->bindParam(':email', $email);
        $stat->bindParam(':win', $win);
        if ($stat->execute()) {
            echo 'true';
        } else echo 'false';
    }
?>