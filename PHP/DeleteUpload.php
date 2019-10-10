<?php
session_start();
$username = $_SESSION['user'];
require_once 'config.php';
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_errno());
}
mysqli_query($conn, 'set names utf8');
$query = "SELECT * FROM users WHERE name= '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$userID = $row['userID'];

if (isset($_POST['delete'])) {
    $query = "SELECT *  FROM artworks WHERE ownerID='$userID' AND artworkID='{$_POST['delete']}' AND orderID IS NULL ";
    if ($row1 = mysqli_fetch_assoc(mysqli_query($conn, $query))) {
        $url = "../img/" . $row1['imageFileName'];

        if (unlink($url)) {
            $queryDelete = "Delete FROM artworks WHERE ownerID='$userID' AND artworkID='{$_POST['delete']}' AND orderID IS NULL";
            mysqli_query($conn, $queryDelete);
            echo "success";
        } else echo "delete file defeat";

    } else echo "no arg";
}


?>
