<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// POST请求
// 接收前端数据
error_reporting(0); // 不会弹出警告，只适合当前页
$body = @file_get_contents('php://input');//接受整个请求主体
$body = json_decode($body)  ;//反序列化

$status = $body->status;//当前操作状态（1.关注 2.取消关注）
$noticer = $body->noticer;//关注者(当前登录者)
$noticerName = $body->noticerName;//关注者(当前登录者昵称)
$noticerImg = $body->noticerImg;//关注者(当前登录者头像)
$sufferId = $body->sufferId;//当前空间用户id
$sufferName = $body->sufferName;//当前空间用户昵称
$sufferImg = $body->sufferImg;//当前空间用户头像
//
//print_r($status);
//print_r($noticer);
//print_r($noticerName);
//print_r($noticerImg);
//print_r($sufferId);

// 包含数据库配置信息
include_once('../config.php');
// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、查询数据
if($status==1){//关注
    $sql_opera = "INSERT INTO star (`noticer`,`noticerName`,`noticerImg`,`sufferId`,`sufferName`,`sufferImg`) VALUES ('$noticer','$noticerName','$noticerImg','$sufferId','$sufferName','$sufferImg')";
}else if($status==2){//取消关注
    $sql_opera = "DELETE FROM star WHERE `noticer` LIKE '$noticer' AND `sufferId` LIKE '$sufferId'";
}

// 4、检查是否插入成功
if($conn->query($sql_opera) === TRUE) {
    echo "success!";
}else {
    echo "Error: " . $sql_opera . "<br>" . $conn->error;
}

// 5、关闭数据库
$conn->close();
?>