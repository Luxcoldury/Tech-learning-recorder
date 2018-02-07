<?php
require_once("waf.php");
error_reporting(0);
date_default_timezone_set('ASIA/Shanghai');
session_start();


$face1=$_POST['face'];
$face2=base64_encode(file_get_contents('link.to.student.photo'.$_SESSION['id'].'.jpg'));
$ch = curl_init();
    $url = 'http://apis.baidu.com/idl_baidu/faceverifyservice/face_compare';
    $header = array(
        'Content-Type:application/x-www-form-urlencoded',
        'apikey: apikey',
    );
    $data = '{
  "params": [
    {
      "cmdid": "1000",
      "appid": "apikey",
      "clientip": "127.0.0.1",
      "type": "st_groupverify",
      "groupid": "0123456",
      "versionnum": "1.0.0.1",
      "usernames": {
        "name2": "name2",
        "name1": "name1"
      },
      "images": {
        "name2": "'.$face1.'",
        "name1": "'.$face2.'"
      },
      "cates": {
        "name2": "3",
        "name1": "1"
      }
    }
  ],
  "jsonrpc": "2.0",
  "method": "Compare",
  "id": 12345
}';
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    // 添加参数
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);
	$resobject=json_decode($res,true);
	if($resobject['result']['_ret']['reslist']['name2|name1']>40){
		$db=mysql_connect("localhost","root","tyjs");
		if(!$db){
			echo '数据库无法连接';
		}else{
			mysql_select_db("tongyongjishu",$db);
			mysql_query("UPDATE `members` SET `".$_SESSION['action']."`='".time()."' WHERE (`id`='".$_SESSION['id']."')");
			echo '登录成功';
		}
	}else{
		echo '登陆不成功';
	}

?>