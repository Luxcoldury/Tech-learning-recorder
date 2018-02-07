<?php
error_reporting(0);
date_default_timezone_set('ASIA/Shanghai');
session_start();
function pass($password,$stored,$salt){
	if($stored==md5(md5($password).$salt)){
		return true;
	}else{
		return false;
	}
}function saltgenerator(){
	$saltarray=array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
	shuffle($saltarray);
	$salt="";
	for($i=0;$i<6;$i++){
		$salt=$salt.$saltarray[$i];
	}
	return $salt;
}
require_once("waf.php");
if($_GET['action']!='table'){
switch($_POST['action']){
	case 'login':
		$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query('set names utf8');
			$row=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE id =".$_POST['id']));
			if(empty($row)==true){
					echo '找不到账号';
			}else{
				if(pass($_POST['password'],$row['password'],$row['salt'])){
					echo '登录成功';
					$_SESSION["id"]=$row["id"];
					$_SESSION["name"]=$row["name"];
					$_SESSION["char"]=$row["char"];
					$_SESSION["course"]=$row["course"];
					$_SESSION["duration"]=(integer)$row["out"]-(integer)$row["in"];
				}else{
					echo '密码不正确';
				}
			}
		}
	break;
	case 'studentfetch':
		$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query('set names utf8');
			$array=mysql_query("SELECT * FROM content WHERE course_id = '".$_POST['course']."' and good = 1 and author_id =".$_SESSION['id']);
			$pool=array();
			while($info = mysql_fetch_array($array)){
				array_push($pool,$info);
			}
			ksort($pool);
			echo '姓名:'.$_SESSION["name"]."&nbsp;&nbsp;";
			echo '学号:'.$_SESSION["id"]."&nbsp;&nbsp;";
			switch ($_POST['course']){
				case 1:
				$course='电工1';
				break;case 2:
				$course='电工2';
				break;case 3:
				$course='金工1';
				break;case 4:
				$course='金工2';
				break;
				}
			echo '课程:'.$course."<br><br>";
			echo '<table class="table table-bordered">';
			foreach($pool as $row){
				echo '<tr><td>';
				echo date('Y年m月d日 H时i分s秒',$row['time']);
				echo '</td><td>';
				echo '<img style="width:100%" src="data:image/png;base64,'.$row['pic'].'">';
				echo '</td></tr><tr><td colspan="2">';
				echo '积累了课时';
				echo floor(((integer)$row['duration'])/3600);
		 echo '小时';
		 echo floor((((integer)$row['duration'])%3600)/60);
		 echo '分钟';
		 echo floor(((integer)$row['duration'])%60);
		 echo '秒';
		 echo '</td></tr>';
		 $duration+=$row['duration'];
			}
			echo '共积累课时';
			echo floor(((integer)$duration)/3600);
		 echo '小时';
		 echo floor((((integer)$duration)%3600)/60);
		 echo '分钟';
		 echo floor(((integer)$duration)%60);
		 echo '秒';
		}
	break;
	case 'teacherindex':
	echo '<div class="col-md-2"></div><div class="col-md-8">
<div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">
              请选择
            </h4>
         </div>
         <div class="modal-body">
         <table style="text-align:center; margin:auto auto; width:100%">
         <tr><td><button id="fetchcoursestart" type="button" class="btn btn-primary btn-lg">布置任务</button></td><td><button id="fetchapprove" type="button" class="btn btn-primary btn-lg">审阅课时</button></td><td><button id="fetchallprocess" type="button" class="btn btn-primary btn-lg">课时统计</button></td><td><button id="fetchoneprocess" type="button" class="btn btn-primary btn-lg">学生作品</button></td></tr>
         </table>
         </div>
      </div></div>
</div><script>$(document).ready(function(e) {	$("#fetchcoursestart").click(function(){$("#teacher_body").load("ajax.php",{action:"fetchcoursestart"});});
	$("#fetchapprove").click(function(){$("#teacher_body").load("ajax.php",{action:"fetchapprove"});});
	$("#fetchallprocess").click(function(){$("#teacher_body").load("ajax.php",{action:"fetchallprocess"});});
	$("#fetchoneprocess").click(function(){$("#teacher_body").load("ajax.php",{action:"fetchoneprocess"});});});</script>
    
';
	break;
	case 'fetchcoursestart':
	echo '<div class="col-md-3"></div><div class="col-md-6">
<div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">
              请输入要开始 ';
	switch ($_SESSION['char']){
				case 1:
				$course='电工1';
				break;case 2:
				$course='电工2';
				break;case 3:
				$course='金工1';
				break;case 4:
				$course='金工2';
				break;
				}
	echo $course;
	echo ' 课程的班级
            </h4><button type="button" class="btn btn-default" style="float:right" id="btn_back">返回</button>
         </div>
         <div class="modal-body">
			<div class="input-group">
      <input type="text" class="form-control" id="class" placeholder="请输入班级">
      <span class="input-group-btn">
        <button class="btn btn-success" type="button" id="coursestart">开始课程</button>
      </span>
    </div>
    <div style="float:right" id="feedback"></div>
         </div>
      </div></div>
</div><script>
$(document).ready(function(e) {
	
	$("#btn_back").click(function(){
			$("#teacher_body").load("ajax.php",{action:"teacherindex"});
	});
	
	$("#coursestart").click(function() {
        $.post("ajax.php",{action:"coursestart",class:$("#class").val()},function(data){if(data!="设置成功"){
				$("#feedback").html("<span class='."'alert alert-danger'".' role='."'alert'".'>"+data+"</span>");
			}else{
				$("#feedback").html("<span class='."'alert alert-success'".' role='."'alert'".'>设置成功</span>");
			}
	});
    });});
</script>';
	break;
	case 'coursestart':
			$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query("UPDATE members SET course = '".$_SESSION['char']."' WHERE class = '".$_POST['class']."'");
			echo '设置成功';
		}
	break;
	case 'fetchapprove':
			$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query('set names utf8');
			$array=mysql_query("SELECT * FROM content WHERE course_id = '".$_SESSION['char']."' and `read` = '0'");
			$pool=array();
			while($info = mysql_fetch_array($array)){
				array_push($pool,$info);
			}
			ksort($pool);
			echo '<script>var ListArray=new Array()</script><div class="col-md-1"></div><div class="col-md-10">
<div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">课时审阅</h4><button type="button" class="btn btn-default" style="float:right" id="btn_back">返回</button><script>$(document).ready(function(){
				$("#btn_back").click(function(){
					$("#teacher_body").load("ajax.php",{action:"teacherindex"});
					})
				});</script>
         </div>
         <div class="modal-body"><table class="table table-bordered">';
		 $i=0;
			foreach($pool as $row){
				$i++;
				echo '<tr><td colspan="2">';
				$name=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE id =".$row['author_id']));
				echo $name['name'];
				echo '&nbsp;&nbsp;';
				echo $row['author_id'];
				echo '&nbsp;&nbsp;本次课时：';
				echo floor(((integer)$row['duration'])/3600);
				echo '小时';
				echo floor((((integer)$row['duration'])%3600)/60);
				echo '分钟';
				echo floor(((integer)$row['duration'])%60);
				echo '秒</td><td colspan="2">上次此学生的进展';
				echo '<div id="feedback_'.$i.'" style="float:right"><div class="btn-group"><button type="button" class="btn btn-danger" id="denybtn_'.$i.'">不通过</button>';
				echo '<button type="button" class="btn btn-success" id="approvebtn_'.$i.'">通过</button></div></div>';
				echo '<script>$(document).ready(function(){
					
					$("#approvebtn_'.$i.'").click(function(){
						$.post("ajax.php",{action:"approve",id:"'.$row['id'].'"},function(data){if(data!="确认通过成功"){
			$("#feedback_'.$i.'").html('."'".'<span class="alert alert-danger" role="alert">'."'".'+data+'."'".'</span>'."'".');
		}else{
			$("#feedback_'.$i.'").html('."'".'<span class="alert alert-success" role="alert">确认通过成功</span>'."'".');
		}});
						});
						
					$("#denybtn_'.$i.'").click(function(){
						$.post("ajax.php",{action:"deny",id:"'.$row['id'].'"},function(data){if(data!="确认不通过成功"){
			$("#feedback_'.$i.'").html('."'".'<span class="alert alert-danger" role="alert">'."'".'+data+'."'".'</span>'."'".');
		}else{
			$("#feedback_'.$i.'").html('."'".'<span class="alert alert-success" role="alert">确认不通过成功</span>'."'".');
		}});
						});
						
					
					});</script>';
				echo'</td></tr><tr><td>';
				echo date('Y年m月d日 H时i分s秒',$row['time']);
				echo '</td><td>';
				echo '<img style="width:100%" src="data:image/png;base64,'.$row['pic'].'">';
				echo '</td>';
				$array1=mysql_query("SELECT * FROM content WHERE `course_id` = '".$_SESSION['char']."' and `good` = '1' and `author_id` = '".$row['author_id']."'");
			$pool1=array();
			while($info1 = mysql_fetch_array($array1)){
				array_push($pool1,$info1);
			}
			krsort($pool1);
			echo'<td>';
			if(empty($pool1[0]['content'])){echo '尚无进展';}else{echo $pool1[0]['content'];}
							echo '</td><td>';
				if(empty($pool1[0]['pic'])){echo '尚无进展';}else{echo '<img style="width:100%" src="data:image/png;base64,'.$pool1[0]['pic'].'">';}
				echo '</td>';
				echo '</tr>';
			}
			echo '</table></div></div></div></div>';
		}
	break;
	case 'approve':
			$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query('set names utf8');
			mysql_query("UPDATE content SET `read` = '1' WHERE `id` ='".$_POST['id']."'");
			mysql_query("UPDATE content SET `good` = '1' WHERE `id` ='".$_POST['id']."'");
			echo '确认通过成功';
		}

	break;
	case 'deny':
			$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query('set names utf8');
			mysql_query("UPDATE content SET `read` = '1' WHERE `id` ='".$_POST['id']."'");
			mysql_query("UPDATE content SET `good` = '0' WHERE `id` ='".$_POST['id']."'");
			echo '确认不通过成功';
		}

	break;
	case 'fetchallprocess':
	echo '<div class="col-md-1"></div><div class="col-md-8">
<div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">课时统计</h4><button type="button" class="btn btn-default" style="float:right" id="btn_back">返回</button><script>$(document).ready(function(){
				
				$("#btn_back").click(function(){
					$("#teacher_body").load("ajax.php",{action:"teacherindex"});
				});
				
				$("#btn_query").click(function(){
					$("#allprocessbody").load("ajax.php",{action:"allprocess",grade:$("#grade").val(),class:$("#class").val()});
				});
				
				$("#btn_table").click(function(){
					window.location.href="ajax.php?action=table&grade="+$("#grade").val()+"&class="+$("#class").val()
				});
				
				});</script>
         </div>
         <div class="modal-body" id="allprocessbody" id="processchart">
		 请在右侧选择届别和班级，如查询全年级成绩，班级请留空
		 </div></div></div></div><div class="col-md-3">
		 <div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
        <h4 class="modal-title" style="display:inline">选择班级</h4>
</div><div class="modal-body">
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">届别</span>
  <input type="text" class="form-control" placeholder="届别" aria-describedby="basic-addon1" id="grade">
</div><br><div class="input-group">
  <span class="input-group-addon" id="basic-addon1">班级</span>
  <input type="text" class="form-control" placeholder="班级" aria-describedby="basic-addon1" id="class">
</div><br><div class="btn-group" role="group">
  
    <button type="button" class="btn btn-primary" id="btn_query">查询</button><button type="button" class="btn btn-success" id="btn_table">下表格</button>
 
</div>
</div></div></div>
		 </div>';
	break;
	case 'allprocess':
		
		$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
		mysql_select_db("tongyongjishu",$db);
		mysql_query('set names utf8');
		if(empty($_POST['class'])){
		$array=mysql_query("SELECT * FROM members WHERE `grade` = '".$_POST['grade']."'");
		}else{$array=mysql_query("SELECT * FROM members WHERE `grade` = '".$_POST['grade']."' and `class` = '".$_POST['class']."'");}
		$pool=array();
		while($info = mysql_fetch_array($array)){
			array_push($pool,$info);
		}$pool1=array();
		foreach($pool as $row){
			$duration=mysql_fetch_array(mysql_query("SELECT sum(duration) AS duration FROM content WHERE `author_id` = '".$row['id']."' and `good` = '1' and `course_id` = '".$_SESSION['char']."'"));
			array_push($pool1,$duration['duration']);
		}
		$a=0;
		$b=0;
		$c=0;
		$d=0;
		$e=0;
		$f=0;
		$g=0;
		$h=0;
		foreach($pool1 as $sum){if(floor($sum/3600)<=2){$a++;}elseif(floor($sum/3600)<=5){$b++;}elseif(floor($sum/3600)<=8){$c++;}elseif(floor($sum/3600)<=11){$d++;}elseif(floor($sum/3600)<=14){$e++;}elseif(floor($sum/3600)<=17){$f++;}elseif(floor($sum/3600)<=19){$g++;}else{$h++;}}
			echo '<canvas id="myChart" width="400" height="400"></canvas>
			
			<script>$(document).ready(function(){
				var data = {
					labels: ["0-2","3-5","6-8","9-11","12-14","15-17","18-19","20以上"],
					datasets: [
						{
							label: "人数",
							backgroundColor: "rgba(255,99,132,0.2)",
							borderColor: "rgba(255,99,132,1)",
							borderWidth: 1,
							hoverBackgroundColor: "rgba(255,99,132,0.4)",
							hoverBorderColor: "rgba(255,99,132,1)",
							data: ['.$a.",".$b.",".$c.",".$d.",".$e.",".$f.",".$g.",".$h.'],
						}
					]
				};
				
				var ctx = $("#myChart").get(0).getContext("2d");
			
				var myBarChart = new Chart(ctx, {
    type: "bar",
    data: data,
});
			
			});</script>';
		echo '<table id="processtable" class="table table-hover"><thead><tr><th>学号</th><th>姓名</th><th>课时</th></tr></thead><tbody>';
		foreach($pool as $row){
			echo '<tr><td>';
			echo $row['id'];
			echo '</td><td>';
			echo $row['name'];
			echo '</td><td>';
			$duration=mysql_fetch_array(mysql_query("SELECT sum(duration) AS duration FROM content WHERE `author_id` = '".$row['id']."' and `good` = '1' and `course_id` = '".$_SESSION['char']."'"));
			echo floor($duration['duration']/3600);
			echo '</td></tr>';}
		echo '</tbody></table><script>$(document).ready(function(){$("#processtable").tablesorter();});</script>';
		}
		
	break;
	case 'oneprocess':
			$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query('set names utf8');
			
			if($_POST['method']=='id'){
				$array=mysql_query("SELECT * FROM content WHERE course_id = '".$_SESSION['char']."' and good = 1 and author_id =".$_POST['id']);
				$name=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE id ='".$_POST['id']."'"));
				echo '姓名:'.$name['name']."&nbsp;&nbsp;";
				echo '学号:'.$_POST["id"]."&nbsp;&nbsp;";
			}else{
				$id=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE name ='".$_POST['name']."'"));
				$array=mysql_query("SELECT * FROM content WHERE course_id = '".$_SESSION['char']."' and good = 1 and author_id =".$id['id']);
				echo '姓名:'.$_POST["name"]."&nbsp;&nbsp;";
				echo '学号:'.$id['id']."&nbsp;&nbsp;";
			}
			$pool=array();
			while($info = mysql_fetch_array($array)){
				array_push($pool,$info);
			}
			ksort($pool);
			switch ($_SESSION['char']){
				case 1:
				$course='电工1';
				break;case 2:
				$course='电工2';
				break;case 3:
				$course='金工1';
				break;case 4:
				$course='金工2';
				break;
				}
			echo '课程:'.$course."<br><br>";
			echo '<table class="table table-bordered">';
			foreach($pool as $row){
				echo '<tr><td>';
				echo date('Y年m月d日 H时i分s秒',$row['time']);
				echo '</td><td>';
				echo '<img style="width:100%" src="data:image/png;base64,'.$row['pic'].'">';
				echo '</td></tr><tr><td colspan="2">';
				echo '积累了课时';
				echo floor(((integer)$row['duration'])/3600);
		 echo '小时';
		 echo floor((((integer)$row['duration'])%3600)/60);
		 echo '分钟';
		 echo floor(((integer)$row['duration'])%60);
		 echo '秒';
		 echo '</td></tr>';
		 $duration+=$row['duration'];
			}
			echo '共积累课时';
			echo floor(((integer)$duration)/3600);
		 echo '小时';
		 echo floor((((integer)$duration)%3600)/60);
		 echo '分钟';
		 echo floor(((integer)$duration)%60);
		 echo '秒';
		}
		break;
	case 'fetchoneprocess':
	echo '<div class="col-md-1"></div><div class="col-md-8">
<div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" style="display:inline">查询单个学生进度</h4><div class="btn-group" role="group" style="float:right"><button type="button" class="btn btn-default" id="btn_print">打印</button><button type="button" class="btn btn-default" id="btn_back">返回</button></div><script>$(document).ready(function(){
				
				$("#btn_back").click(function(){
					$("#teacher_body").load("ajax.php",{action:"teacherindex"});
				});
				
				$("#btn_query").click(function(){
					$("#allprocessbody").load("ajax.php",{action:"oneprocess",method:"id",id:$("#id").val()});
				});
				$("#btn_namequery").click(function(){
					$("#allprocessbody").load("ajax.php",{action:"oneprocess",method:"name",name:$("#name").val()});
				});
				$("#btn_print").click(function(){
					$("#allprocessbody").printArea(); 
				});
				
				});</script>
         </div>
         <div class="modal-body" id="allprocessbody">
		 请在右侧输入学生学号
		 </div></div></div></div><div class="col-md-3">
		 <div class="modal-dialog" style="margin:auto auto;width:100%">
      <div class="modal-content">
         <div class="modal-header">
        <h4 class="modal-title" style="display:inline">选择学生</h4>
</div><div class="modal-body">
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">姓名</span>
  <input type="text" class="form-control" placeholder="姓名" aria-describedby="basic-addon1" id="name">
</div><br><div class="btn-group btn-group-justified" role="group">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-primary" id="btn_namequery">姓名查询</button>
  </div>
</div><br><div class="input-group">
  <span class="input-group-addon" id="basic-addon1">学号</span>
  <input type="text" class="form-control" placeholder="学号" aria-describedby="basic-addon1" id="id">
</div><br><div class="btn-group btn-group-justified" role="group">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-primary" id="btn_query">学号查询</button>
  </div>
</div>
</div></div></div>
		 </div>';
	break;
}
}else{
	function export_csv($filename,$str)   
{   
    header("Content-type:text/csv");   
    header("Content-Disposition:attachment;filename=".$filename);   
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
    header('Expires:0');   
    header('Pragma:public');   
    echo $str;   
}  
$db=mysql_connect("localhost","root","tyjs");
		if(!$db){echo '数据库无法连接，请联系管理员';}else{
		mysql_select_db("tongyongjishu",$db);
		mysql_query('set names utf8');
		if(empty($_GET['class'])){
		$array=mysql_query("SELECT * FROM members WHERE `grade` = '".$_GET['grade']."'");
		}else{$array=mysql_query("SELECT * FROM members WHERE `grade` = '".$_GET['grade']."' and `class` = '".$_GET['class']."'");}
		$pool=array();
		while($info = mysql_fetch_array($array)){
			array_push($pool,$info);
		}
		$data=iconv('utf-8','gb2312',"学号,姓名,课时\n");
		foreach($pool as $row){
			$data=$data.iconv('utf-8','gb2312',$row['id']);
			$data=$data.",";
			$data=$data.iconv('utf-8','gb2312',$row['name']);
			$data=$data.",";
			$duration=mysql_fetch_array(mysql_query("SELECT sum(duration) AS duration FROM content WHERE `author_id` = '".$row['id']."' and `good` = '1' and `course_id` = '".$_SESSION['char']."'"));
			$data=$data.floor($duration['duration']/3600);
			$data=$data."\n";}
		}
		if(empty($_GET['class'])){
			export_csv($_GET['grade'].'届'.date('Ymd').'.csv',$data);
		}else{
			export_csv($_GET['grade'].'届'.$_GET['class'].'班'.date('Ymd').'.csv',$data);
		}

}
?>