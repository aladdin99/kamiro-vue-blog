<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 包含数据库配置信息
include_once('../config.php');

// POST请求
// 接收前端数据
error_reporting(0); // 不会弹出警告，只适合当前页

$body = @file_get_contents('php://input');//接受整个请求主体
$body = json_decode($body)->clipSaveData;//反序列化

// 获取参数
$sufferClip = $body->sufferClip; //该收藏夹的唯一键
$sufferName = $body->sufferName;//该收藏夹的昵称
$sufferAmount = $body->sufferAmount;//该收藏夹记录的文章
$sufferId = $body->sufferId;//该收藏夹绑定的用户
$sufferNum = $body->sufferNum;//该收藏夹的关注量
$noticer = $body->noticer;//当前登录用户
print_r($body->clipSaveData);

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、保存新增数据
//3.1 更新收藏关注表
$sql_insert = "INSERT INTO follower_clip (`sufferClip`, `sufferName`,`sufferAmount`,`sufferId`,`sufferNum`,`noticer`) 
VALUES ('$sufferClip','$sufferName','$sufferAmount','$sufferId','$sufferNum','$noticer')";
//3.2 更新收藏表中的关注数量字段
$sql_update = "UPDATE collection_clip SET `followers` = '$sufferNum' WHERE `bind` LIKE '$sufferId' And `id` LIKE '$sufferClip'";

// 4、检查是否插入成功
if(($conn->query($sql_update) === TRUE)&&($conn->query($sql_insert) === TRUE)) {
    echo "新纪录插入成功！";
}else {
    echo "Error: " . $sql_insert . "<br>" . $sql_update  . "<br>". $conn->error;
}

// 5、关闭数据库
$conn->close();
?>