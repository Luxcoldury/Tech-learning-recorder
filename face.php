<?php
require_once("waf.php");
//error_reporting(0);
date_default_timezone_set('ASIA/Shanghai');
session_start();
$db=mysql_connect("localhost","root","tyjs");
		if(!$db){}else{
			mysql_select_db("tongyongjishu",$db);
			$row=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE card =".$_GET['id']));
			if(empty($row)==true){
			}else{
				$_SESSION['id']=$row['id'];
				$_SESSION["name"]=$row["name"];
				$_SESSION["char"]=$row["char"];
				$_SESSION["course"]=$row["course"];
			}
		}
if($_SESSION['action']=='in'):
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>面部识别</title>
<link rel="stylesheet" href="bootstrap.min.css">  
<script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="scriptcam/swfobject.js"></script>
<script src="scriptcam/scriptcam.min.js"></script>
<script>$(document).ready(function() {

		$("#webcam").scriptcam({
			width:320,
			height:240
		});



	$("#btn_face").click(function(){
		$("#button").html('<div class="progress"><div class="progress-bar progress-bar-striped active" style="width: 100%"></div>');
		$.post("faceverify.php",{face:$.scriptcam.getFrameAsBase64()},function(data){
		if(data=="登录成功"){
			$("#button").html('<span class="alert alert-success" role="alert">登录成功</span>');
			setTimeout(function(){window.location.href="login.php"},1000);
		}else{
			$("#button").html('<span class="alert alert-danger" role="alert">'+data+'</span>');
			setTimeout(function(){window.location.href="login.php"},1000);}
		});
	});
});</script>
</head>

<body style="background-image:url(background.jpg); background-attachment:fixed; background-size:cover; margin:00px 0px 0px 0px"><div class="container">
<br>
<nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand"><a href="login.php">通用技术学业考评</a></span>
    </div><p class="navbar-text navbar-right">复旦大学附属中学 版权所有&nbsp;&nbsp; </p>
  </div>
</nav>
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8"><div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">
            面部识别登录
            </h4>
         </div><div class="modal-body" id="body_study" style="text-align:center">
<div id="webcam">
</div>
<div id="button">
<button type="button" class="btn btn-default" id="btn_face">面部识别登录</button></div></div></div></div></div></div>
</nav></div></body>
</html><?php else:?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>面部识别</title>
<link rel="stylesheet" href="bootstrap.min.css">  
<script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="scriptcam/swfobject.js"></script>
<script src="scriptcam/scriptcam.min.js"></script>
<script>$(document).ready(function() {

		$("#webcam").scriptcam({
			width:320,
			height:240
		});



	$("#btn_face").click(function(){
				$("#button").html('<div class="progress"><div class="progress-bar progress-bar-striped active" style="width: 100%"></div>');
$.post("faceverify.php",{face:$.scriptcam.getFrameAsBase64()},function(data){
		if(data=="登录成功"){$("#button").html('<span class="alert alert-success" role="alert">登录成功</span>');
		setTimeout(function(){window.location.href="input.php"},1000);}else{$("#button").html('<span class="alert alert-danger" role="alert">'+data+'</span>');
		setTimeout(function(){window.location.href="login.php"},1000);}
		});
});

});</script></head>

<body style="background-image:url(background.jpg); background-attachment:fixed; background-size:cover; margin:00px 0px 0px 0px"><div class="container">
<br>
<nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand"><a href="login.php">通用技术学业考评</a></span>
    </div><p class="navbar-text navbar-right">复旦大学附属中学 版权所有&nbsp;&nbsp; </p>
  </div>
</nav>
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8"><div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">
            面部识别登录
            </h4>
         </div><div class="modal-body" id="body_study" style="text-align:center">
<div id="webcam">
</div>
<div id="button">
<button type="button" class="btn btn-default" id="btn_face">面部识别登录</button></div></div></div></div></div></div></div></body>
</html>
<?php endif;?>