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
    <title>Information</title>
    <link rel="stylesheet" href="../CSS/Nav.css">
    <link rel="stylesheet" href="../CSS/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/tips.css">
    <link rel="stylesheet" href="../CSS/Sign_Log.css">
    <link rel="stylesheet" href="../CSS/Information.css">
    <script src="../JS/jquery-3.3.1.min.js"></script>
</head>
<body>

<?php include "Header.html" ?>
<?php
$username = $_SESSION['user'];
require_once 'config.php';
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_errno());
}
mysqli_query($conn, 'set names utf8');
$query = "SELECT * FROM users WHERE name= '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result)
?>
<aside>
    <ul>
        <li>User: <span> <?php echo $row['name']
                ?></span></li>
        <li>Tel: <span><?php echo $row['tel'] ?></span></li>
        <li>Address: <span><?php echo $row['address'] ?></span></li>
        <li>Mail: <span><?php echo $row['email'] ?></span></li>
        <li>Balance: <span><?php echo $row['balance'] ?></span></li>
        <li><input type="button" value="Recharge" onclick="popBox_recharge()" class="chargeBtn recharge"></li>
    </ul>
</aside>
<main>
    <?php
    $userID = $row['userID'];
    $queryUpload = "SELECT * FROM artworks WHERE ownerID='$userID'  AND  orderID IS NULL";
    $resultUpload = mysqli_query($conn, $queryUpload);
    echo " <nav id=\"upload\" class=\"information\">";
    echo "  <p>The artworks I uploaded:  </p>";

    if (mysqli_fetch_assoc($resultUpload)) {
        $resultUpload = mysqli_query($conn, $queryUpload);
        echo " <table style='height: 50px'>";
        while ($row = mysqli_fetch_assoc($resultUpload)) {
            echo "<tr>";
            echo "<td><a class=\"owl-more\" href=\"Details.php?title=" . $row['artworkID'] . "\">Name:" . $row['title'] . "</a></td>";
            echo "<td>Author:" . $row['artist'] . "</td>";
            echo "<td>Time:" . $row['timeReleased'] . "</td>";
            echo "<td><input type='button' value='Modify' class='modifyBtn' artworkID='" . $row['artworkID'] . "'></td>";
            echo "<td><input type='button' id='ssss' value='Delete' class='deleteBtn' artworkID='" . $row['artworkID'] . "'></td>";
            echo "</tr>";
        }
        echo " </table>";
    } else {
        echo "You haven't upload any artworks";
    }
    echo "<input type='button' value='Upload New' id='uploadBtn' onclick=\"location.href='Upload.php' \" >";
    echo " </nav>";


    $queryOrder = "SELECT * FROM orders WHERE ownerID= '$userID'";
    $resultOrder = mysqli_query($conn, $queryOrder);

    echo "  <nav id=\"purchase\" class=\"information\">
        <p>The artwork I purchased:</p>";
    if ($row = mysqli_fetch_assoc($resultOrder)) {
        $resultOrder = mysqli_query($conn, $queryOrder);
        echo " <table >";
        while ($row = mysqli_fetch_assoc($resultOrder)) {
            $queryArtworks = "SELECT * FROM artworks WHERE orderID='{$row['orderID']}'";
            $resultDetails = mysqli_query($conn, $queryArtworks);

            echo "<tr>";
            echo "<td>OrderID: " . $row['orderID'] . "</td>";
            echo "<td>";
            while ($rowDetails = mysqli_fetch_assoc($resultDetails)) {
                echo "<a class=\"owl-more\" href=\"Details.php?title=" . $rowDetails['artworkID'] . "\">Name: " . $rowDetails['title'] . "</a><br>";
            }
            echo "</td>";
            echo "<td>Sum: " . $row['sum'] . "</td>";
            echo "<td>Time: " . $row['timeCreated'] . "</td>";

            echo "</tr>";
        }
        echo " </table>";
    } else {
        echo "You haven't purchased any artworks";
    }
    echo " </nav>";

    //艺术品详情
    $querySold = "SELECT * FROM artworks WHERE ownerID= '$userID' and orderID IS NOT NULL ";
    $resultSold = mysqli_query($conn, $querySold);

    echo "  <nav id=\"sold\" class=\"information\">
        <p>The artwork I sold:</p>";
    if ($row = mysqli_fetch_assoc($resultSold)) {
        $resultSold = mysqli_query($conn, $querySold);
        echo " <table >";
        while ($rowWork = mysqli_fetch_assoc($resultSold)) {

//订单详情
            $orderID = $rowWork['orderID'];
            $queryOrder2 = "SELECT * FROM orders WHERE orderID='$orderID'";
            $resultOrder2 = mysqli_query($conn, $queryOrder2);
            $rowOrder2 = mysqli_fetch_assoc($resultOrder2);

//购买者详情
            $ownerID = $rowOrder2['ownerID'];
            $queryBuyer = "SELECT * FROM users WHERE userID='$ownerID'";
            $resultBuyer = mysqli_query($conn, $queryBuyer);
            $rowBuyer = mysqli_fetch_assoc($resultBuyer);


            echo "<tr>";
            echo "<td><a class=\"owl-more\"  href=\"Details.php?title=" . $rowWork['artworkID'] . "\" >Name: " . $rowWork['title'] . "</a></td>";
            echo "<td>price: " . $rowWork['price'] . "</td>";
            echo "<td colspan='2'>Time: " . $rowOrder2['timeCreated'] . "</td>";


            echo "</tr>";
            echo "<tr>";
            echo "<td>Buyer Name: " . $rowBuyer['name'] . "</td>";
            echo "<td>Buyer Email: " . $rowBuyer['email'] . "</td>";
            echo "<td>Buyer Tel: " . $rowBuyer['tel'] . "</td>";
            echo "<td>Buyer Address: " . $rowBuyer['address'] . "</td>";
            echo "</tr>";
        }
        echo " </table>";
    } else {
        echo "You haven't sold any artworks";
    }

    echo " </nav>";
    ?>




</main>

<?php include "Sign_Log.html" ?>

<div>
    <div id="popLayer_recharge" class="popLayer"></div>
    <div id="popBox_recharge" class="popBox bootstrap-frm" style="height: 300px;width: 400px">
        <div class="tips">提示</div>
        <div class="content">
            <label for="">请输出充值金额（整数）</label>
            <input type="text" id="recharge" name="recharge">
            <p id="confirm_charge">&nbsp;</p>
        </div>
        <input type="button" onclick="closeBox_recharge()" value="取消" id="charge_cancel" class="chargeBtn">
        <input type="button"  onclick="closeBox_recharge()" value="确定" id="charge_confirm" class="chargeBtn">
    </div>
</div>


<script src="../JS/Sign_Log.js"></script>
<script src="../JS/tips.js"></script>
<script src="../JS/Footprint.js"></script>
<script src="../JS/Information.js"></script>
<footer >
    <p>Produced by yanyanyan</p>
</footer>

</body>
</html>