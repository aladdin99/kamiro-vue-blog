<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// POST请求
// 接收前端数据
error_reporting(0); // 不会弹出警告，只适合当前页

$body = @file_get_contents('php://input');//接受整个请求主体
$body = json_decode($body)  ;//反序列化

//print_r($body);
$status = $body->status;

$id = $body->id;
$show = $body->show;
$bind = $body->bind;

$name = $body->name;
$describe = $body->describe;
$picture = $body->picture;

if($status == 0){//新建分类专栏时才用到哦
    $id = uniqid();//随机生成一个id作为分类该栏的专属id
}

// 包含数据库配置信息
include_once('../config.php');
// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、插入数据//以id(邮箱号)作为主键 进行有选择的插入分类专栏信息
if($status==0){//新建分类栏
    $sql = "INSERT INTO sort_colum (`id`, `bind`,`name`,`describe`,`picture`) VALUES ('$id','$bind','$name','$describe','$picture')";
}else if($status==2){//更新是否前台展示该分类栏
    $sql = "UPDATE sort_colum SET `show` = '$show' WHERE `id` LIKE '$id' And `bind` LIKE '$bind'";
}else if($status==1){//更新分类栏
    $sql = "UPDATE sort_colum SET `name` = '$name',`describe` = '$describe',`picture` = '$picture' WHERE `id` LIKE '$id' And `bind` LIKE '$bind'";
}else if($status==3){//回收操作
    $sql = "UPDATE sort_colum SET `recover` = '1' WHERE `id` LIKE '$id' And `bind` LIKE '$bind'";

}else if($status==4){//恢复回收栏中的分类栏
    $sql = "UPDATE sort_colum SET `recover` = '0' WHERE `id` LIKE '$id' And `bind` LIKE '$bind'";
}else if($status==5){//彻底删除回收栏中的分类栏
    $sql = "DELETE FROM sort_colum WHERE `id` LIKE '$id' And `bind` LIKE '$bind'";
}

// 4、检查是否插入成功
if($conn->query($sql) === TRUE) {
    echo "分类栏更新成功！";
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 5、关闭数据库
$conn->close();
?>