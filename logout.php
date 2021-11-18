<?php

session_start();

$_SESSION = array();

// 세션 종료
session_destroy();

// 메인 페이지로 돌아가기
header("location: restList.php");
exit;
?>
