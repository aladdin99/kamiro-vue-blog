<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 用于返回数据
$return = array();
$data = array();
//接受前端数据
$noticer = $_GET['noticer'];//当前登录者
$sufferId = $_GET['sufferId'];//收藏夹id
$sufferClip = $_GET['sufferClip'];//当前空间用户
$followers = $_GET['followers'];//该收藏夹关注人数减一

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
$sql_del = "DELETE FROM follower_clip WHERE `noticer` LIKE '$noticer' And `sufferId` LIKE '$sufferId' AND `sufferClip` LIKE '$sufferClip'";
$sql_update = "UPDATE collection_clip SET `followers` = '$followers' WHERE `bind` LIKE '$sufferId' And `id` LIKE '$sufferClip'";

// 4、检查是否插入成功
if(($conn->query($sql_del) === TRUE)&&($conn->query($sql_update) === TRUE)) {
    echo 'deleted!';
}else {
    echo "Error: " . $sql_del . $sql_update . "<br>" . $conn->error;
}
// 5、关闭数据库
$conn->close();
?>