<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请先登陆')
    </script>";
    die("<a href=\"Home.php\">点此返回主页</a>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <link rel="stylesheet" href="../CSS/Upload.css">
    <link rel="stylesheet" href="../CSS/Nav.css">
    <link rel="stylesheet" href="../CSS/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/tips.css">
    <link rel="stylesheet" href="../CSS/Sign_Log.css">
    <script src="../JS/jquery-3.3.1.min.js"></script>

</head>
<body>
<?php include "Header.html" ?>

<main>
    <?php
    if (isset($_GET['artworkID'])) {
        $artworkID=$_GET['artworkID'];
        $_SESSION['artworkID']= $artworkID;
        $username = $_SESSION['user'];
        require_once 'config.php';
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if (mysqli_connect_errno()) {
            die(mysqli_connect_errno());
        }
        mysqli_query($conn, 'set names utf8');
        $query = "SELECT * FROM artworks WHERE artworkID= '{$_GET['artworkID']}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        echo " <form class=\"m-warp\" id=\"modifyForm\" action=\"UploadHandle.php\" method=\"post\" enctype=\"multipart/form-data\">
        <div class=\"item\">
            <input type=\"file\" name=\"img\"  value=\"../img/" . $row['imageFileName'] . "\" id=\"img\" accept=\"image/gif,image/jpeg,image/jpg,image/png,image/svg\" hidden>
            <label for=\"img\" id=\"chooseImg\">选择图片</label><span id='img-rem' class='rem'>&nbsp;</span>
        </div>
        <div class=\"item clearfix\">
            <div class=\"col col-1\">
                <img src=\"../img/" . $row['imageFileName'] . "\" class=\"cvsMove\" id=\"cvsMove\" >
            </div>

            <div class=\"thum col-2 col\">
                <p>艺术品信息</p>
                <p>名称：<input type=\"text\" name='title' id=\"title\"  value='" . $row['title'] . "'>* <span id='title-rem' class='rem'>&nbsp;</span></p>
                <p>作者：<input type=\"text\" name='artist' id=\"artist\" value='" . $row['artist'] . "'  > * <span id='artist-rem' class='rem'>&nbsp;</span></p>
                <p>年份：<input type=\"text\" name='yearOfWork' id=\"yearOfWork\" value='" . $row['yearOfWork'] . "'> * <sapn id='year-rem' class='rem'>&nbsp;</sapn></p>
                <p>流派：<input type=\"text\" name='genre' id=\"genre\" value='" . $row['genre'] . "'> * <sapn id='genre-rem' class='rem'>&nbsp;</sapn></p>
                 <p>价格：<input type=\"text\" name='price' id=\"price\" value='" . $row['price'] . "'> * <sapn id='price-rem' class='rem'>&nbsp;</sapn></p>
                <p>尺寸：<label for=\"\">长度: </label><input type=\"text\" class=\"size\" name='width' id=\"width\" value='" . $row['width'] . "'>
                    <label for=\"\">宽度: </label><input type=\"text\" class=\"size\" id=\"height\" name='height' value='" . $row['height'] . "'> *单位：cm<sapn id='size-rem' class='rem'>&nbsp;</sapn></p>
                <p class=\"f-text-l f-marTop-20\">
                <p>简介：<textarea name=\"details\" id=\"description\" cols=\"30\" rows=\"10\" > " . $row['description'] . "</textarea> * <sapn id='des-rem' class='rem'>&nbsp;</sapn></p>
                <input type=\"button\" id='submitBtn' value=\"提交\">
                </p>
            </div>
        </div>
    </form>";

    } else {
        unset($_SESSION['artworkID']);
        echo " <form class=\"m-warp\" id=\"modifyForm\" action='UploadHandle.php' method='post' enctype=\"multipart/form-data\">
        <div class=\"item\">
            <input type=\"file\" name=\"img\" id=\"img\" accept=\"image/gif,image/jpeg,image/jpg,image/png,image/svg\" hidden>
            <label for=\"img\" id=\"chooseImg\">选择图片</label><span id='img-rem' class='rem'>&nbsp;</span>
        </div>
        <div class=\"item clearfix\">
            <div class=\"col col-1\">
                <img src=\"../img/\" class=\"cvsMove\" id=\"cvsMove\" >
            </div>

            <div class=\"thum col-2 col\">
                <p>艺术品信息</p>
                <p>名称：<input type=\"text\" name='title' id=\"title\"  >* <span id='title-rem' class='rem'>&nbsp;</span></p>
                <p>作者：<input type=\"text\" name='artist' id=\"artist\" > * <span id='artist-rem' class='rem'>&nbsp;</span></p>
                <p>年份：<input type=\"number\" name='yearOfWork' id=\"yearOfWork\"> * <sapn id='year-rem' class='rem'>&nbsp;</sapn></p>
                <p>流派：<input type=\"text\" name='genre' id=\"genre\" > * <sapn id='genre-rem' class='rem'>&nbsp;</sapn></p>
                 <p>价格：<input type=\"text\" name='price' id=\"price\" > * <sapn id='price-rem' class='rem'>&nbsp;</sapn></p>
                <p>尺寸：<label for=\"\">长度: </label><input type=\"text\" class=\"size\" name='width' id=\"width\" >
                    <label for=\"\">宽度: </label><input type=\"text\" class=\"size\" id=\"height\" name='height' > *单位：cm<sapn id='size-rem' class='rem'>&nbsp;</sapn></p>
                <p class=\"f-text-l f-marTop-20\">
                <p>简介：<textarea name=\"details\" id=\"description\" cols=\"30\" rows=\"10\" ></textarea> * <sapn id='des-rem' class='rem'>&nbsp;</sapn></p>
                <input type=\"button\" id='submitBtn' value=\"提交\">
                </p>
            </div>
        </div>
    </form>";
    }
    ?>
</main>

<footer>
    <p>Produced by yanyanyan</p>
</footer>
<?php include "Sign_Log.html" ?>



<script src="../JS/Sign_Log.js"></script>
<script src="../JS/tips.js"></script>
<script src="../JS/Footprint.js"></script>
<script src="../JS/Upload.js"></script>

</body>
</html>