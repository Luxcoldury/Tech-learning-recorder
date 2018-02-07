<?php
require_once("waf.php");
error_reporting(0);
date_default_timezone_set('ASIA/Shanghai');
session_start();

function saltgenerator(){
	$saltarray=array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
	shuffle($saltarray);
	$salt="";
	for($i=0;$i<6;$i++){
		$salt=$salt.$saltarray[$i];
	}
	return $salt;
}

if(empty($_POST['pic'])){echo '<!DOCTYPE html>
<html>

<head>
<title>通用技术学业考评</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="jquery.min.js"></script>
<script>$(document).ready(function(){setTimeout(function(){window.location.href="input.php";},1000);});</script></head>
			<body>请上传图片</body></html>';}else{
$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query("INSERT INTO content (author_id,course_id,time,pic,duration) VALUES ('".$_SESSION['id']."','".$_SESSION["course"]."','".time()."','".$_POST["pic"]."','".$_SESSION['duration']."')");
			mysql_query("UPDATE members SET `in` = '0' WHERE id = '".$_SESSION['id']."'");
			mysql_query("UPDATE members SET `out` = '0' WHERE id = '".$_SESSION['id']."'");
			echo '<!DOCTYPE html>
<html>

<head>
<title>通用技术学业考评</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="jquery.min.js"></script>
<script>$(document).ready(function(){setTimeout(function(){window.location.href="login.php";},1000);});</script></head>
			<body>录入成功</body></html>';
			session_destroy();
		}}
?>