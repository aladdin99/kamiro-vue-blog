<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// POST请求
// 接收前端数据
error_reporting(0); // 不会弹出警告，只适合当前页

$pathId = $_GET['pathId'];//收录者收藏夹
$bindId = $_GET['bindId'];//收录者
$articleId = $_GET['articleId'];//文章id
$amount = $_GET['amount'];//该收藏夹内的数量减一

// 用于返回数据
$return = array();
$data = array();

// 包含数据库配置信息
include_once('../../config.php');

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

//更新收藏(1.增加条数据 2.删除条数据)
$sql_detail = "DELETE FROM collection_detail WHERE `articleId` LIKE '$articleId' And `bindId` LIKE '$bindId' AND `pathId` lIKE '$pathId'";

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