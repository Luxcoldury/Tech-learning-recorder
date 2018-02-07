<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>通用技术学业考评—登录</title>
<link rel="stylesheet" href="bootstrap.min.css">  
<script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="scriptcam/scriptcam.min.js"></script>
<script>$(document).ready(function(){
	
	$("#in").click(function(){window.location.href="cardid.php?action=in"});
	$("#learn").click(function(){window.location.href="learn.php"});
	$("#out").click(function(){window.location.href="cardid.php?action=out"});
	
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
<div class="col-md-3"></div>
<div class="col-md-6"><div class="row">
         <div class="col-md-6" style="text-align:center"><button id="in" type="button" class="btn btn-grey btn-lg">报到</button></div><div class="col-md-6" style="text-align:center"><button id="out" type="button" class="btn btn-grey btn-lg">离开</button></div>
         </div></div>
         


</div></div>
</body>
</html>