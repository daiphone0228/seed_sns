<?php 
$db = mysqli_connect('localhost', 'root', 'mysql', 'seed_sns') or die (mysqli_connect_error());
mysqli_set_charset($db, 'utf8');

// DB接続準備 ※これでも同じ
// $dsn = 'mysql:dbname=seed_sns;host=localhost';
// $user = 'root';
// $password = '';
// $dbh = new PDO($dsn,$user,$password);
// $dbh->query('SET NAMES utf8');


 ?>