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
<script src="jquery.PrintArea.js"></script>
<script>$(document).ready(function(){
		
		$("#btn_1").click(function(){
		document.getElementById("btn_2").checked=false
		document.getElementById("btn_3").checked=false
		document.getElementById("btn_4").checked=false
		$("#body_study").load("ajax.php",{action:'studentfetch',course:'1'});
		});	
			
		$("#btn_2").click(function(){
		document.getElementById("btn_1").checked=false
		document.getElementById("btn_3").checked=false
		document.getElementById("btn_4").checked=false
		$("#body_study").load("ajax.php",{action:'studentfetch',course:'2'});
		});	
			
		$("#btn_3").click(function(){
		document.getElementById("btn_2").checked=false
		document.getElementById("btn_1").checked=false
		document.getElementById("btn_4").checked=false
		$("#body_study").load("ajax.php",{action:'studentfetch',course:'3'});
		});
		
		$("#btn_4").click(function(){
		document.getElementById("btn_1").checked=false
		document.getElementById("btn_2").checked=false
		document.getElementById("btn_3").checked=false
		$("#body_study").load("ajax.php",{action:'studentfetch',course:'4'});
		});
		
		$("#btn_print").click(function(){
			$("#body_study").printArea();
		});
		
		
		
		});
</script>
</head>

<body style="background-image:url(background.jpg); background-attachment:fixed; background-size:cover; margin:0px 0px 0px 0px"><div class="container">
<br>

<div class="row">

<div class="col-md-10"><div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">
            我的学习历程
            </h4><button type="button" class="btn btn-default" style="float:right" id="btn_print">打印</button>
         </div><div class="modal-body" id="body_study">
         请点按右侧选择要查看的课程
         </div></div></div></div>
         
<div class="col-md-2"><div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">
            选择课程
            </h4>
         </div><div class="modal-body">
         <input type="radio" id="btn_1">电子1<br>
         <input type="radio" id="btn_2">电子2<br>
         <input type="radio" id="btn_3">金工1<br>
         <input type="radio" id="btn_4">金工2<br>
         </div></div></div></div>

</div></div></body>
<?php 
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
  	<script src="bootstrap.min.js"></script></head>
<script src="Chart.min.js"></script>
<script src="jquery.tablesorter.combined.js"></script>
<script src="jquery.PrintArea.js"></script>
<script>
$(document).ready(function(e) {
	
	$("#teacher_body").load("ajax.php",{action:"teacherindex"});
	
});
</script>
<body style="background-image:url(background.jpg); background-attachment:fixed; background-size:cover; margin:0px 0px 0px 0px"><div class="container">
<br>

<div class="row" id="teacher_body">





</div></div></body></html>
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
      <span class="navbar-brand">通用技术学业考评</span>
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