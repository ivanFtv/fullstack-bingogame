<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        include "../connect.php";
        $stat = $connection->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stat->bindParam(':username', $username);
        $stat->bindParam(':password', $password);
        if ($stat->execute()) {
            $users = $stat->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($users) > 0) {
            $_SESSION['logged'] = true;
            $_SESSION['firstname'] = $users[0]['firstname'];
            $_SESSION['email'] = $users[0]['email'];
            $_SESSION['credits'] = $users[0]['credits'];
            echo 'true';
        } else echo 'false';
    }
}
?>