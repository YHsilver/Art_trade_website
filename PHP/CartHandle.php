<?php
//获得当前用户
session_start();
if (!isset($_SESSION['user'])) {
    echo "notLog";
    return;
}
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

//处理删除功能
if (isset($_POST['Delete'])) {
    $queryDelete = "DELETE FROM carts WHERE userID='$userID' and artworkID='{$_POST['Delete']}' ";
    mysqli_query($conn, $queryDelete);
    echo 'DeleteSuccess';
}

//处理结账功能

//从数据库读购物车
if (isset($_POST['Pay'])) {
    $queryCarts = "SELECT * FROM carts WHERE userID='$userID'";
    $result = mysqli_query($conn, $queryCarts);
    $sum = 0;


//从数据库直接计算总价
    while ($row = mysqli_fetch_assoc($result)) {
        $queryArtwork = "SELECT * FROM artworks WHERE artworkID='{$row['artworkID']}'";
        $resultArtwork = mysqli_query($conn, $queryArtwork);
        $rowArtwork = mysqli_fetch_assoc($resultArtwork);
       if (!$rowArtwork){
           echo $row['artworkID']."delete";
           return;
       }else if ($rowArtwork['orderID']!=NULL){
           echo $rowArtwork['title']."sold";
           return;
       }
        $sum += $rowArtwork['price'];
    }

    if ($sum > $rowUser['balance']) {
        echo "BalanceLack";
    } else {
        $arr = array();
        $result = mysqli_query($conn, $queryCarts);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr[] = $row['artworkID'];
            $queryArtwork = "SELECT * FROM artworks WHERE artworkID='{$row['artworkID']}'";
            $resultArtwork = mysqli_query($conn, $queryArtwork);
            $rowArtwork = mysqli_fetch_assoc($resultArtwork);


            //更新购买者的购物车
            $queryDelete = "DELETE FROM carts WHERE userID='$userID' and artworkID='{$rowArtwork['artworkID']}' ";
            mysqli_query($conn, $queryDelete);

            //增加钱到卖家（artwork的owner）
            $queryOwner = "SELECT *FROM users WHERE userID=' {$rowArtwork['ownerID']}'";
            $resultOwner = mysqli_query($conn, $queryOwner);
            $rowOwner = mysqli_fetch_assoc($resultOwner);
            $ownerBalance = $rowOwner['balance'] + $rowArtwork['price'];
            $queryBalance = "UPDATE users SET balance='$ownerBalance' WHERE userID='{$rowArtwork['ownerID']}'";
            mysqli_query($conn, $queryBalance);

        }
        //插入order记录
        $queryInsertOrder = "INSERT INTO orders (ownerID , sum) VALUES ('$userID','$sum')";
        mysqli_query($conn, $queryInsertOrder);

        //artworks给对应图片记录上orderID   (有问题：多用户无法唯一确认)
        $queryOrder = "SELECT * FROM orders ORDER BY timeCreated DESC LIMIT 1";
        $resultOrder = mysqli_query($conn, $queryOrder);
        $rowOrder = mysqli_fetch_assoc($resultOrder);
        $lastOrder = $rowOrder['orderID'];
        foreach ($arr as $value) {
            $queryArtwork = "UPDATE  artworks  SET orderID='$lastOrder'  WHERE artworkID='$value'";
            mysqli_query($conn, $queryArtwork);
        }

        //扣除购买者的钱
        $balance = $rowUser['balance'] - $sum;
        $queryBalance = "UPDATE users SET balance='$balance' WHERE name='$username'";
        mysqli_query($conn, $queryBalance);

        echo "PaySuccess";

    }


}


//处理添加到购物车功能
if (isset($_POST['Add'])) {
    $artworkID = $_POST['Add'];
    $queryCarts = "SELECT * FROM carts WHERE userID='$userID' and artworkID='$artworkID'";
    $queryArtwork = "SELECT * FROM artworks WHERE artworkID='$artworkID' ";
    if (mysqli_fetch_assoc(mysqli_query($conn, $queryCarts))) {
        echo "alreadyExisted";
    } else if (mysqli_fetch_assoc(mysqli_query($conn, $queryArtwork))['orderID'] != NULL) {
        echo "soldOut";
    } else {
        $queryCarts = "INSERT INTO carts (userID , artworkID) VALUES ('$userID','$artworkID')";
        mysqli_query($conn, $queryCarts);
        echo "AddSuccess";

    }

}