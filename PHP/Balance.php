<?php
require_once 'config.php';
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['charge'])) {

        session_start();
        $username = $_SESSION["user"];

        $sql = "SELECT * FROM users WHERE name='$username'";
        $res = $pdo->query($sql);
        $row = $res->fetch();
        $balance = $_POST["charge"] + $row['balance'];

        $sql1 = "UPDATE users SET balance='$balance' WHERE name='$username'";
        $pdo->query($sql1);
        echo $balance;
    }
    $pdo = null;
} catch (PDOException $exception) {
    die($exception->getMessage());
}