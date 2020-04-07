<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img {
            width: 1rem;
        }

        .pageination a {
            color: green;
        }

        .selectedpage {
            color: blue !important;
            font-weight: bold;
        }
    </style>
</head>
<?php

include("config.php");
include("connect.php");
include("libery.php");

if (isset($_SESSION['bantime']) && ($_SESSION['bantime'] > time())) {
    echo ($_SESSION['bantime'] - time());
}



$result_count = $mysqli->query('SELECT count(*) FROM guests'); //считаем количество строк в таблице
$count = $result_count->fetch_array(MYSQLI_NUM)[0];
echo "количество записей: <b>$count</b>";
$result_count->free();
// echo $pagesize;

$pagecount = ceil($count / $pagesize);

$currientpage = $_GET['page'] ?? 1;

$startrow = ($currientpage - 1) * $pagesize;

$pageination = "<div class='pageination'>\n";

for ($i = 1; $i <= $pagecount; $i++) {
    // if ($currientpage == $i) {
    //     $str = " class='selectedpage'";
    // } else {
    //     $str = "";
    // }
    $str = ($currientpage == $i) ? " class='selectedpage'" : "";
    $pageination .= "<a href='?page=$i'$str>$i</a>\n";
}

$pageination .= "</div>";

$result = $mysqli->query("SELECT * FROM guests LIMIT $startrow, $pagesize");

echo $pageination;

echo "<table border='1'>\n";
while ($row = $result->fetch_object()) {
    echo "<tr>";
    echo "<td>" . smile($row->text) . "</td>";
    echo "<td>" . $row->name . "</td>";
    echo "</tr>";
}
echo "</table>\n";

echo $pageination;

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