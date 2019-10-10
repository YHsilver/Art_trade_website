<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <link rel="stylesheet" href="../CSS/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/Nav.css">
    <link rel="stylesheet" href="../CSS/Detail.css">
    <link rel="stylesheet" href="../CSS/Sign_Log.css">
    <link rel="stylesheet" href="../CSS/tips.css">
</head>
<body>
<?php include "Header.html" ?>
<main>

    <?php
    if (isset($_GET['title'])){
    $id = $_GET['title'];
    }else {
        die("请通过详情访问或url输入艺术品ID");
    }
    require_once 'config.php';
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM artworks WHERE artworkID='{$id}' LIMIT 1";
        $result = $pdo->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $view = $row['view'] + 1;
        $sql = "update artworks set view = '{$view}' WHERE artworkID='{$id}'";
        $pdo->query($sql);

$saleStatus="";

if ($row['orderID']==NULL) $saleStatus="For Sale";
else $saleStatus="Sold Out";


        echo "<p id=\"detail-name\">" . $row['title'] . "</p>";
        echo "  <p id=\"detail-author\"><a href=\"Search.php?Artist=" . $row['artist'] . "\">" . $row['artist'] . "</a></p>";
        echo " <div>";
        echo " <img src=\"../img/" . $row['imageFileName'] . " \" class=\"detail-image\">";
        echo "   <div id=\"right-text\"><p id=\"detail-description\">" . $row['description'] . "</p>";
        echo " <p id=\"detail-price\">PRICE: " . $row['price'] . "</p>";
        echo " <div id=\"buttons\">
          
                <input type=\"button\" value=\"Add to Shopping Cart\"  id='addCart' artworkID='".$row['artworkID']."'>
            </div>";

        echo "<table id=\"detail-table\">
                <thead>
                <tr>
                    <td colspan=\"2\">Product Details</td>
                </tr>
                </thead>
                <tr>
                    <td>Price</td>
                    <td>" . $row['price'] . "</td>
                </tr>
                 <tr>
                    <td>Status</td>
                    <td>" . $saleStatus . "</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>" . $row['yearOfWork'] . "</td>
                </tr>
                <tr>
                    <td>Dimensions</td>
                    <td>" . $row['width'] . " cm X " . $row['height'] . " cm</td>
                </tr>
               
                <tr>
                    <td>Genres</td>
                    <td>" . $row['genre'] . "</td>
                </tr>
               
                <tr>
                    <td>Heat</td>
                    <td>" . $row['view'] . "</td>
                </tr>
         </table>";
        echo "</div>";
        echo "</div>";
        $pdo = null;
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
    ?>

</main>
<footer>
    <p>Produced by yanyanyan</p>
</footer>

<?php include "Sign_Log.html" ?>


<div>
    <div id="popLayer_add" class="popLayer"></div>
    <div id="popBox_add" class="popBox">
        <div class="tips">提示</div>
        <div class="content">添加成功！</div>
        <input type="button" onclick="closeBox_add()" value="确定">
    </div>
</div>


<script src="../JS/Sign_Log.js"></script>
<script src="../JS/Footprint.js"></script>
<script src="../JS/tips.js"></script>
<script src="../JS/Details.js"></script>
</body>
</html>