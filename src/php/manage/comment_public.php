<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 用于返回数据
$return = array();
$data = array();
//接受前端数据
//$id = $_GET['id'];//评论id
//$userId = $_GET['userId'];//评论者id
//$bindId = $_GET['bindId'];//文章id
//$authorId = $_GET['authorId'];//著作者id

//$openList = $_GET['openList'];//评论设置为公开
//$openList = json_encode($openList);

// POST请求
// 接收前端数据
error_reporting(0); // 不会弹出警告，只适合当前页

$body = @file_get_contents('php://input');//接受整个请求主体
$body = json_decode($body)  ;//反序列化

// 包含数据库配置信息
include_once('../config.php');

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、更新评论(设置为公开状态)0.公开 1.审核
//$sql = "UPDATE comment SET `showFlag` = 0 WHERE `id` LIKE '$id' AND `userId` LIKE '$userId' AND `bindId` LIKE '$bindId' AND `authorId` LIKE '$authorId'";
foreach ($body as $value){
    foreach ($value as $index){
        $sql = "UPDATE comment SET `showFlag` = 0 WHERE `id` LIKE '$index->id' AND `userId` LIKE '$index->userId' AND `bindId` LIKE '$index->bindId' AND `authorId` LIKE '$index->authorId'";
        // 4、检查是否更新成功
        if($conn->query($sql) === TRUE) {
            echo "评论更新成功！";
        }else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// 5、关闭数据库
$conn->close();

?>