<?php
require_once 'config.php';
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if (isset($_POST['username'])) {
        $username = $_POST["username"];
        $password = $_POST["pass"];
        $tel = $_POST["tel"];
        $address = $_POST["address"];
        $email = $_POST["email"];
        $sql = "INSERT INTO users (name,email,password,tel,address) VALUES ('$username','$email','$password','$tel','$address')";
        $pdo->query($sql);
    }
    $pdo = null;
} catch (PDOException $exception) {
    die($exception->getMessage());
}

session_start();
$_SESSION['user'] = $username;
if (isset($_POST['message'])) {
    if ($_POST['message'] == 'logout') {
        unset($_SESSION['user']);
    }
}
?>
<script>
    history.back();
</script>