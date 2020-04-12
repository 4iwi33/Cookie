<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='style.css' rel='stylesheet'>
</head>
<?php
include("config.php");
include("conect.php");
include("function.php");

// Время посещения страницы
if (!empty($_REQUEST['resetCountdown'])) {
    unset($_SESSION['startTime']);
}

if (empty($_SESSION['startTime'])) {
    $_SESSION['startTime'] = time();
}


$startTime = time() - $_SESSION['startTime'];
echo "<div class = 'time'>$startTime  секунд назад вы посещали эту страницу </div><br>";

// Счетчик посещения страницы с разных браузеров и устройств
$home = $_SERVER["DOCUMENT_ROOT"];

$domen = $_SERVER["HTTP_X_FORWARDED_PROTO"] . "://" . $_SERVER["HTTP_HOST"];

$parse_url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$real_page = $domen . $parse_url;

$count_looks = file_get_contents('session.txt');

if (!$_SESSION["count"]) {

    file_put_contents('session.txt', ($count_looks + 1));

    $_SESSION["count"] = 1;
}

echo "<div class = 'count'>Kоличество посещений сайта $count_looks </div><br>";

// Банлист

if (isset($_SESSION['bantime']) && ($_SESSION['bantime'] > time())) {
    echo "<div class = 'ban'>Вы забанины на: " . ($_SESSION['bantime'] - time()) . " c </div>";
}

// Добавления таблицы
$result_count = $mysqli->query('SELECT count(*) FROM `table`'); //считаем количество строк в таблице
$count = $result_count->fetch_array(MYSQLI_NUM)[0];
echo "количество записей: " . $count;
$result_count->free();

$pagecount = ceil($count / $pagesize);

$currientpage = $_GET['page'] ?? 1;

$startrow = ($currientpage - 1) * $pagesize;

$pagenation = "<div class='pagenation'>";

for ($i = 1; $i <= $pagecount; $i++) {
    if ($currientpage == $i) {
        $str = " class = 'selectedpage'";
    } else {
        $str = "";
    }
    $pagenation .= " <a href = '?page=$i'$str> $i </a>";
}
$pagenation .= "</div>";

// Заполнение таблицы
$result = $mysqli->query("SELECT * FROM `table` LIMIT $startrow, $pagesize");
echo $pagenation;
echo "<table border='1'>\n";
while ($row = $result->fetch_object()) {
    echo "<tr>";
    echo "<td>" . smile($row->text) . "</td>";
    echo "<td>" . $row->name . "</td>";
    echo "</tr>";
}
echo "</table>\n";
echo $pagenation;
$result->free();

$mysqli->close();
?>

<body>

    <form action="add.php" method="POST">
        <textarea name="text" cols="30" rows="10"></textarea><br>
        <input type="text" name="name"><br>
        <button type="submit">отправить</button>
    </form>


</body>

</html>