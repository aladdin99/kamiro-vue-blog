<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 包含数据库配置信息
include_once('../config.php');

// POST请求
// 接收前端数据
error_reporting(0); // 不会弹出警告，只适合当前页

$body = @file_get_contents('php://input');//接受整个请求主体
$body = json_decode($body)->msgData;//反序列化

// 获取参数
$msger = $body->msger; //留言者
$msgImg = $body->msgImg;//留言者头像
$msgName = $body->msgName;//留言者昵称
$msgContent = $body->msgContent;//留言内容
$userId = $body->userId;//留言对象

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、保存新增数据
$sql_insert = "INSERT INTO leaveMsg (`msger`, `msgImg`,`msgName`,`msgContent`,`userId`) VALUES ('$msger','$msgImg','$msgName','$msgContent','$userId')";

// 4、检查是否插入成功
if($conn->query($sql_insert) === TRUE) {
    echo "新纪录插入成功！";
}else {
    echo "Error: " . $sql_insert . "<br>". $conn->error;
}

// 5、关闭数据库
$conn->close();
?>