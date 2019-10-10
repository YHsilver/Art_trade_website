<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "   <script>alert('请先登陆')
    </script>";
    die("<a href=\"Home.php\">点此返回主页</a>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ShoppingCart</title>
    <link rel="stylesheet" href="../CSS/Nav.css">
    <link rel="stylesheet" href="../CSS/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/Shopping.css">
    <link rel="stylesheet" href="../CSS/Sign_Log.css">
    <link rel="stylesheet" href="../CSS/tips.css">
    <script src="../JS/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php include "Header.html" ?>



<?php
//输出购物车物品
$username = $_SESSION['user'];
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

$queryCart = "SELECT * FROM carts WHERE userID='$userID'";
$resultCart = mysqli_query($conn, $queryCart);
$Sum = 0;
?>
<main>
    <h2>Shopping Cart</h2>
    <div>
        <div id="cart">

            <?php
            if (mysqli_fetch_assoc($resultCart)) {
                $resultCart = mysqli_query($conn, $queryCart);
                while ($rowCart = mysqli_fetch_assoc($resultCart)) {
                    $artworkID = $rowCart['artworkID'];
                    $queryArtwork = "SELECT * FROM artworks WHERE artworkID='$artworkID'";
                    $resultArtwork = mysqli_query($conn, $queryArtwork);
                    $rowArtwork = mysqli_fetch_assoc($resultArtwork);
                    if ($rowArtwork) {
                        echo "   <div class=\"shopping\">";
                        echo "  <a href=\"Details.php?title=" . $rowArtwork['artworkID'] . "\"> <img src=\"../img/" . $rowArtwork['imageFileName'] . "\"></a>";
                        echo "  <div>";
                        echo " <p class=\"name\"><a href=\"Details.php?title=" . $rowArtwork['artworkID'] . "\">" . $rowArtwork['title'] . "</a></p>";
                        echo "  <p class=\"author\" >" . $rowArtwork['description'] . "</p>";
                        echo "<div>";
                        echo "  <p class=\"price\">PRICE:" . $rowArtwork['price'] . "</p>";
                        $Sum += $rowArtwork['price'];
                        echo "<input type=\"button\" value=\"Delete\"  class='deleteBtn' index='" . $artworkID . "'> ";
                    } else {
                        echo "   <div class=\"shopping\">";
                        echo "  <a href=\"Details.php?title=" . $rowArtwork['artworkID'] . "\"> <img src=\"../img/delete.jpg\"></a>";
                        echo "  <div>";
                        echo " <p class=\"name\">商品不存在或已被下架！</p>";
                        echo "  <p class=\"author\" >商品ID：" . $artworkID . "</p>";
                        echo "<div>";
                        echo "<input type=\"button\" value=\"Delete\"  class='deleteBtn' index='" . $artworkID . "'> ";
                    }
                    echo "
                    </div>
                </div>
            </div>";
                }
                echo "  <input type=\"button\" value=\"Pay:" . $Sum . "\"  id=\"totalBtn\">";
            } else echo "You add nothing to shopping cart";
            echo "   </div>
    </div>"
            ?>


</main>

<footer >
    <p>Produced by yanyanyan</p>
</footer>
<div>
    <div id="popLayer_delete" class="popLayer"></div>
    <div id="popBox_delete" class="popBox">
        <div class="tips">提示</div>
        <div class="content">删除成功 ！</div>
        <input type="button" onclick="closeBox_delete()" value="确定">
    </div>
</div>


<div>
    <div id="popLayer_pay" class="popLayer"></div>
    <div id="popBox_pay" class="popBox">
        <div class="tips">提示</div>
        <div class="content">支付成功，祝您购物愉快 ！</div>
        <input type="button" onclick="closeBox_pay()" value="确定">
    </div>
</div>


<?php include "Sign_Log.html" ?>
<script src="../JS/Sign_Log.js"></script>
<script src="../JS/tips.js"></script>
<script src="../JS/Footprint.js"></script>
<script src="../JS/ShoppingCart.js"></script>
</body>
</html>