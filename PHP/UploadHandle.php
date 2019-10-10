
<?php
session_start();
$username = $_SESSION['user'];
if (isset($_SESSION['artworkID'])){
    $artworkID=$_SESSION['artworkID'];
}
require_once 'config.php';
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_errno());
}
mysqli_query($conn, 'set names utf8');
$queryUser = "SELECT * FROM users WHERE name= '$username'";
$resultUser = mysqli_query($conn, $queryUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$userID = $rowUser['userID'];


if (isset($_POST['artist'])) {

    if (isset($_SESSION['artworkID'])) {

        $img = $_FILES['img'];
        $savePath = "../img/";
        $saveName = $artworkID.".jpg";
        $res = move_uploaded_file($_FILES["img"]["tmp_name"], $savePath.$saveName );
        $query = "UPDATE  artworks  SET   artist='{$_POST['artist']}',
                  description='{$_POST['details']}',
                  title='{$_POST['title']}',
                  yearOfWork={$_POST['yearOfWork']},
                  genre='{$_POST['genre']}',
                  width={$_POST['width']},
                  height={$_POST['height']},
                  price={$_POST['price']}  WHERE artworkID=$artworkID";
             mysqli_query($conn,$query);

    } else {
        $img = $_FILES['img'];
        $savePath = "../img/";
        $queryName="SELECT * FROM artworks ORDER BY artworkID DESC lIMIT 2";
        $rowName=mysqli_fetch_assoc(mysqli_query($conn,$queryName));
        $artworkID=$rowName['artworkID']+1;
        $saveName = $artworkID.".jpg";

        $res = move_uploaded_file($_FILES["img"]["tmp_name"], $savePath.$saveName );


        $query = "INSERT INTO artworks (artworkID,artist,imageFileName,description,title,yearOfWork,genre,width,height,price,ownerID)
                  VALUES ('$artworkID','{$_POST['artist']}','{$saveName}','{$_POST['details']}','{$_POST['title']}',
                  '{$_POST['yearOfWork']}','{$_POST['genre']}','{$_POST['width']}','{$_POST['height']}','{$_POST['price']}','$userID')";

        mysqli_query($conn,$query);


    }
}
?>
<script>
    history.back();
</script>