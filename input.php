<?php 
require_once("waf.php");
error_reporting(0);
function saltgenerator(){
	$saltarray=array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
	shuffle($saltarray);
	$salt="";
	for($i=0;$i<6;$i++){
		$salt=$salt.$saltarray[$i];
	}
	return $salt;
}
session_start();
$db=mysql_connect("localhost","root","tyjs");
		if(!$db){}else{
			mysql_select_db("tongyongjishu",$db);
			$row=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE id =".$_SESSION['id']));
			if(empty($row)==true){
			}else{
				$_SESSION["duration"]=(integer)$row["out"]-(integer)$row["in"];
			}
		}

date_default_timezone_set('ASIA/Shanghai');
if(isset($_SESSION['char'])):
if($_SESSION['char']==0):
?>
<!DOCTYPE html>
<html>

<head>
<title>通用技术学业考评</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
		
		setTimeout(function(){$.scriptcam.changeCamera(1);},1000);
		

		$("#save").click(function(){$("#button").html('<img src="data:image/png;base64,'+$.scriptcam.getFrameAsBase64()+'"><input type="hidden" name="pic" value="'+$.scriptcam.getFrameAsBase64()+'"/>')});
	
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
<div class="col-md-1"></div>
<div class="col-md-10"><div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">
            录入学习历程
            </h4>
         </div><div class="modal-body" id="body_study">你现在正在进行的是 <?php
		 switch ($_SESSION['course']){
			 case 1:
			 echo '电子1';
			 break;
			 case 2:
			 echo '电子2';
			 break;
			 case 3:
			 echo '金工1';
			 break;
			 case 4:
			 echo '金工2';
			 break;
		 }
		 ?> 课程，这次积累的课时是<?php 
		 echo floor(((integer)$_SESSION['duration'])/3600);
		 echo '小时';
		 echo floor((((integer)$_SESSION['duration'])%3600)/60);
		 echo '分钟';
		 echo floor(((integer)$_SESSION['duration'])%60);
		 echo '秒';?><br><br>这一次的进展:<br>
         <div id="webcam" style="display:inline">
</div><form action="upload.php" method="post">
<div id="button"></div><button class="btn btn-primary" id="save" type="button">拍照</button><br><br>
  <button type="submit" class="btn btn-primary">提交</button></form>
         </div></div></div></div>
</div></div></body>
<?php 
else:?>
请以学生身份登录
<?php
endif;
else:?>

<!DOCTYPE html>
<html>

<head>
<title>通用技术学业考评</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  	<link rel="stylesheet" href="bootstrap.min.css">  
<script src="jquery.min.js"></script>
  	<script src="bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
		$('#loginModal').modal('show');
		
		$("#btn_login").click(function(){
			$.post("ajax.php",{action:"login",id:$("#login_id").val(),password:$("#login_password").val()},function(data,status){if(data!="登录成功"){
			$("#login_alert").html('<span class="alert alert-danger" role="alert">'+data+'</span>');
		}else{
			$("#login_alert").html('<span class="alert alert-success" role="alert">登录成功</span>');
			setTimeout(function(){history.go(0);},1000)
		}});
		});
	});
    </script>
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
<div class="row"><div class="col-md-12" style="text-align:center"></div></div></div>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false" data-keyboard="false">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
              请登录
            </h4>
         </div>
        <div class="modal-body">
		  <div class="form-group">
      <label for="id">学号</label>
      <input type="text" class="form-control" id="login_id" 
         placeholder="您的学号">
   </div><div class="form-group">
      <label for="password">密码</label>
      <input type="password" class="form-control" id="login_password" 
         placeholder="您的密码">
   </div>
         </div>
         <div class="modal-footer">
       	   <span id="login_alert"></span>
            <button type="button" class="btn btn-primary" id="btn_login">
               登录
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal-dialog --></div><!-- /.modal -->

</body>

</html>
<?php endif;?>