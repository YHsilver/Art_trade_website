<?php
$wherelist = array();
$urlist = array();
if (isset($_GET['Name']) || isset($_GET['Details']) || isset($_GET['Details'])) {
    if (!empty($_GET['Name']) && $_GET['Name'] != " ") {
        $wherelist[] = " title like '%" . $_GET['Name'] . "%'";
        $urllist[] = "Name=" . $_GET['Name'];

    }
    if (!empty($_GET['Details']) && $_GET['Details'] != " ") {
        $wherelist[] = " description like '%" . $_GET['Details'] . "%'";
        $urllist[] = "Details=" . $_GET['Details'];
    }
    if (!empty($_GET['Artist']) && $_GET['Artist'] != " ") {
        $wherelist[] = " artist like '%" . $_GET['Artist'] . "%'";
        $urllist[] = "Artist=" . $_GET['Artist'];
    }
}

$wherelist[] = " orderID IS  NULL ";
if (count($wherelist) > 0) {
    $where = " where " . implode(' and ', $wherelist);
    $url = '&' . implode('&', $urlist);
}


require_once 'config.php';

$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$pdo->exec("set names utf8");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "select * from artworks {$where} ";
$result = $pdo->query($sql);
//$totalnum =0;
//while ($nua = $result->fetch()) {
//    $totalnum +=1;
//}

$totalnum = count($result->fetchAll());
if ($totalnum > 0) {
    $pagesize = 6;  //每页显示条数
    $maxpage = ceil($totalnum / $pagesize);         //总共有几页
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if ($page < 1) {
        $page = 1;
    }
    if ($page > $maxpage) {
        $page = $maxpage;
    }
    $limit = " limit " . ($page - 1) * $pagesize . ",$pagesize";
    $order = "view";
    if (isset($_GET['order'])) {
        if (!empty($_GET['order'])) {
            if ($_GET['order'] != "undefined") {
                $order = $_GET['order'];
            }
        }
    }
    $upDown = "asc";
    if (isset($_GET['upDown'])) {
        if (!empty($_GET['upDown'])) {
            if ($_GET['upDown'] != "undefined") {
                $upDown = $_GET['upDown'];
            }
        }
    }

    $sql1 = "select * from artworks {$where}  order by {$order} {$upDown} {$limit}";
    $res = $pdo->query($sql1);

    while ($row = $res->fetch()) {
        $description = explode(" ", $row['description']);
        $words = implode(" ", array_splice($description, 0, 20));

        echo " <div class=\"result\" totalnum=\"" . $totalnum . "\">";
        echo " <img src=\"../img/" . $row['imageFileName'] . "\" >";
        echo " <p class=\"name\">" . $row['title'] . "</p>";
        echo " <p class=\"author\">" . $row['artist'] . "</p>";
        echo "<p class=\"description\">" . $words . "...</p>";
        echo "<a  href=\"Details.php?title=" . $row['artworkID'] . "\">more</a>";
        echo " </div>";
    }

} else {
    echo "搜索结果不存在";
}
$pdo = null;
?>
