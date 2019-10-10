<?php
header("Content-type:text/html;charset=utf-8");
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../CSS/font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../CSS/Nav.css">
    <link rel="stylesheet" href="../CSS/Home.css">
    <link rel="stylesheet" href="../CSS/Sign_Log.css">
</head>
<body>
<?php include "Header.html" ?>
<main>
    <section class="recommend" id="box">
        <div class="owl">
            <div id="owl-stage" class="owl-carousel">
                <?php
                require_once 'config.php';
                try {
                    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $pdo->exec("set names utf8");
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM artworks  WHERE orderID IS  NULL ORDER BY view DESC LIMIT 5";
                    $result = $pdo->query($sql);

                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $description = explode(" ", $row['description']);
                        $words = implode(" ", array_splice($description, 0, 20));
                        echo "<div class=\"owl-stage-figure\">";
                        echo " <a class=\"items\"><img src=\"../img/" . $row['imageFileName'] . "\"></a>";
                        echo " <div>";
                        echo " <p class=\"owl-name\">" . $row['title'] . "</p>";
                        echo " <p class=\"owl-author\">" . $row['artist'] . "</p>";
                        echo "<p class=\"owl-description\">" . $words . "...</p>";
                        echo "<a class=\"owl-more\" href=\"Details.php?title=" . $row['artworkID'] . "\">LEARN MORE</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                    $pdo = null;
                } catch (PDOException $exception) {
                    die($exception->getMessage());
                }
                ?>

            </div>
            <div class="owl-controls">

            </div>

            <div id="arr">
                <span id="left"> <</span>
                <span id="right">></span>
            </div>

        </div>


    </section>

    <section class="hot">

        <?php
        require_once 'config.php';
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");
            $sql = "SELECT * FROM artworks WHERE orderID IS  NULL ORDER BY timeReleased DESC LIMIT 3";


            $result = $pdo->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $description = explode(" ", $row['description']);
                $words = implode(" ", array_splice($description, 0, 60));
                echo "<div class=\"works\">";
                echo " <img src=\"../img/" . $row['imageFileName'] . " \" class=\"hot-image\">";
                echo " <p class=\"hot-name\">" . $row['title'] . "</p>";
                echo "<p class=\"hot-description\">" . $words . "...</p>";
                echo "<a  href=\"Details.php?title=" . $row['artworkID'] . "\">LEARN MORE</a>";
                echo "</div>";
            }
            $pdo = null;
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
        ?>


</main>

<?php
if (isset($_FILES['img'])) {
    $img = $_FILES['img'];
    $savePath = "../img/";
    $queryName="SELECT artworkID FROM artworks ORDER BY artworkID DESC lIMIT 1";
    $rowName=mysqli_fetch_assoc(mysqli_query($queryName));
    $artworkID=$rowName['artworkID']+1;
    $saveName = $artworkID."jpg";

    $res = move_uploaded_file($_FILES["file"]["tmp_name"], $savePath.$saveName );

    if (isset($_GET['artworkID'])) {
        $query = "UPDATE  artworks  SET
                  artist='{$_POST['artworkID']}',
                  imageFileName='{$img['name']}',
                  description='{$_POST['details']}',
                  title='{$_POST['title']}',
                  yearOfWork='{$_POST['yearOfWork']}',
                  genre='{$_POST['genre']}',
                  width='{$_POST['width']}',
                  height='{$_POST['height']}',
                  price='{$_POST['price']}',
                   WHERE artworkID='{$row['artworkID']}'";
        mysqli_query($conn,$query);
    } else {
        $query = "INSERT INTO artworks (artworkID,artist,imageFileName,description,title,yearOfWork,genre,width,height,price)
                  VALUES ('$artworkID','{$_POST['artist']}','{$img['name']}','{$_POST['details']}','{$_POST['title']}',
                  '{$_POST['yearOfWork']}','{$_POST['genre']}','{$_POST['width']}','{$_POST['height']}','{$_POST['price']}')";
                 mysqli_query($conn,$query);
    }
}
?>


<footer>
    <p>Produced by yanyanyan</p>
</footer>

<?php include "Sign_Log.html" ?>

<script src="../JS/Sign_Log.js"></script>
<script src="../JS/Home.js"></script>
<script src="../JS/Footprint.js"></script>
</body>

</html>
