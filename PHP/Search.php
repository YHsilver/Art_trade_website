<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="../CSS/Nav.css">
    <link rel="stylesheet" href="../CSS/Search.css">
    <link rel="stylesheet" href="../CSS/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/Sign_Log.css">
    <script src="../JS/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php include "Header.html" ?>

<main>
    <div class="search-main">
        <div class="bootstrap-frm">
            <label for="Name"> Name：</label><input type="text" name="Name" autocomplete="off" id="NameS" value="<?php
            if (isset($_GET['Name'])) echo $_GET['Name'];
            else echo "";

            ?>" size="8">
            <label for="Details">Details:</label> <input type="text" name="Details" autocomplete="off" id="DetailsS"
                                                         value="<?php
                                                         if (isset($_GET['Details'])) echo $_GET['Details'];
                                                         else echo "";
                                                         ?>" size="8">
            <label for="Artist">Artist：</label> <input type="text" name="Artist" autocomplete="off" id="ArtistS"
                                                       value="<?php
                                                       if (isset($_GET['Artist'])) echo $_GET['Artist'];
                                                       else echo "";

                                                       ?>" size="8">
            <input type="button" value="查看全部" class="button" id="searchAll">
            <input type="button" value="搜索" onclick="doSearch(1);" class="button" id="searchOpt">
        </div>
    </div>


    <div class="search-top">
        <p>Search Result: </p>

        <div class="sort">

            <p>sort order:</p>

            <form>
                <div id="upDown">
                    <span class="fa fa-sort-up fa-lg select" id="order-asc"></span>
                    <span class="fa fa-sort-down fa-lg" id="order-desc" ></span>
                </div>
                <input type="radio" name="order" id="price" value="price">
                <label for="price">Price</label>
                <input type="radio" name="order" value="hot" id="hot" checked>
                <label for="hot">Hot</label>
                <input type="radio" name="order" value="name" id="name">
                <label for="name">Name</label>
            </form>
        </div>
    </div>
    <div class="search-middle" id="searchResult">


    </div>

    <div class="search-bottom">
        <div id="pageBar"><!--这里添加分页按钮栏--></div>
    </div>
</main>

<footer>
    <p>Produced by yanyanyan</p>
</footer>

<?php include "Sign_Log.html" ?>
<script src="../JS/Sign_Log.js"></script>
<script src="../JS/Footprint.js"></script>
<script src="../JS/Search.js"></script>

</body>
</html>