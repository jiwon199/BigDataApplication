<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'pw');
define('DB_NAME', 'db');

// mysql과 연결
$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// 연결 확인, false이면 error msg
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
