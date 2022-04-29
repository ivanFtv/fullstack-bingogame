<?php

    function history() {
        $email = $_SESSION['email'];
        include "connect.php";
        $stat = $connection->prepare("SELECT * FROM history WHERE email = :email ORDER BY date DESC");
        $stat->bindParam(':email', $email);
        if ($stat->execute()) {
            $history = $stat->fetchAll(PDO::FETCH_ASSOC);
            return $history;
        } else return false;
    }
    
?>