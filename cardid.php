<?php
require_once("waf.php");
error_reporting(0);
date_default_timezone_set('ASIA/Shanghai');
session_start();
$_SESSION['action']=$_GET['action'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>请刷卡</title>
<link rel="stylesheet" href="bootstrap.min.css">  
<script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="scriptcam/scriptcam.min.js"></script>
<script>$(document).ready(function(){
	
	$("#id")[0].focus();
	
	$("#id").keypress(function(e){
		if(e.which==13){window.location.href="face.php?id="+$("#id").val();}
	});
	
	});</script>
</head>

<body style="background-image:url(background.jpg); background-attachment:fixed; background-size:cover; margin:0px 0px 0px 0px"><div class="container">
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
            刷卡登录
            </h4>
         </div><div class="modal-body" id="body_study" style="text-align:center">
<div id="button">
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">ID:</span>
  <input id="id" type="password" class="form-control" placeholder="请刷卡" aria-describedby="basic-addon1">
</div>
</div></div></div></div></div></div></div></body>
</html>