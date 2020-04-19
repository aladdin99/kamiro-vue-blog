<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 用于返回数据
$return = array();
$data = array();
//接受前端数据
$id = $_GET['id'];//邮箱账号

// 包含数据库配置信息
include_once('../config.php');

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、删除评论
$sql = "DELETE FROM comment WHERE `id` LIKE '$id'";

// 4、检查是否插入成功
if($conn->query($sql) === TRUE) {
    echo "评论删除成功！";
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 5、关闭数据库
$conn->close();

?>