<?php
require_once 'config.php';
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from users";
    $result = $pdo->query($sql);
    if (isset($_POST['Name'])) {
        $existed = false;
        while ($row = $result->fetch()) {
            if ($_POST['Name'] == $row['name']) {
                $existed = true;
            }
//         echo $_POST['Name'] ;
        }
        echo $existed;
    }

    $pdo = null;
} catch (PDOException $exception) {
    die($exception->getMessage());
}