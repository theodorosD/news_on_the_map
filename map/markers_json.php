<?php
require("db.php");
DEFINE('DATABASE_USER', $username);
DEFINE('DATABASE_PASSWORD', $password);
DEFINE('DATABASE_HOST', 'localhost');
DEFINE('DATABASE_NAME', $dbname);

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
header('Content-Type: text/javascript; charset=UTF-8');
$altype=$_GET["alt"];

$pdo=new PDO("mysql:dbname=".DATABASE_NAME.";host=localhost",DATABASE_USER,DATABASE_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",  PDO::ATTR_PERSISTENT => true));

$statement=$pdo->prepare("SELECT id, title, content,date, feed_town.lng, feed_town.lat, source, feed.town,link FROM feed LEFT JOIN feed_town ON feed.town = feed_town.town WHERE date BETWEEN (SYSDATE() - INTERVAL 13 DAY) AND SYSDATE()");

$pdo->exec("SET NAMES 'utf8'");
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode(array('places' => $results));
echo $json;
$pdo=null;
?>