<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// POST请求
// 接收前端数据
error_reporting(0); // 不会弹出警告，只适合当前页

$body = @file_get_contents('php://input');//接受整个请求主体
$body = json_decode($body)  ;//反序列化

// 获取参数
$statusFlag = $body->statusFlag;// 1.收藏(增加该条数据) 2.取消收藏(删除该条数据)
$pathId = $body->pathId;//收录者收藏夹
$bindId = $body->bindId;//收录者
$authorId = $body->authorId;//作者id
$articleId = $body->articleId;//文章id
$amount = $body->amount;//已收录数量

// 用于返回数据
$return = array();
$data = array();

// 包含数据库配置信息
include_once('../config.php');

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

//更新收藏(1.增加条数据 2.删除条数据)
if($statusFlag==1){
    $sql_detail = "INSERT INTO collection_detail (`pathId`,`bindId`,`authorId`,`articleId`) VALUES ('$pathId','$bindId','$authorId','$articleId')";
}else if($statusFlag==2){
    $sql_detail = "DELETE FROM collection_detail WHERE `articleId` LIKE '$articleId' And `bindId` LIKE '$bindId' AND `pathId` lIKE '$pathId'";
}

//收藏夹中amount总数更新
$sql_clip = "UPDATE collection_clip SET `amount` = '$amount' WHERE `id` LIKE '$pathId' And `bind` LIKE '$bindId'";

// 4、检查是否插入成功
if($conn->query($sql_detail) === TRUE && $conn->query($sql_clip) === TRUE) {
    echo 'success!';
}else {
    echo "Error: " . $sql_detail . $sql_clip. "<br>" . $conn->error;
}


// 5、关闭数据库
$conn->close();
?>