<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 用于返回数据
$return = array();
$data = array();
//接受前端数据
$id = $_GET['id'];//文章绑定的账户ID
$uniqueId = $_GET['uniqueId'];//文章的唯一id识别符
$comment_limit = $_GET['comment_limit'];//文章绑定的账户

// 包含数据库配置信息
include_once('../config.php');

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、更新文章的评论权限数据（公开或审核后公开）
$sql_update = "UPDATE article SET `comment_limit` = '$comment_limit' WHERE `uniqueId` LIKE '$uniqueId' And `related` LIKE '$id'";

// 4、检查是否更新成功
if($conn->query($sql_update) === TRUE) {
    echo "记录更新成功！";
}else {
    echo "Error: " . $sql_update . "<br>" . $conn->error;
}

// 4、关闭数据库
$conn->close();
?>