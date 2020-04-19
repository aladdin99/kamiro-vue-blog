<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

//接受前端数据
$status = $_GET['status'];//1.关注标识 2.粉丝标识
$sufferId = $_GET['sufferId'];//被关注者id
$sufferName = $_GET['sufferName'];//被关注者昵称
$sufferImg = $_GET['sufferImg'];//被关注者头像
$noticer = $_GET['noticer'];//关注者id
$noticerName = $_GET['noticerName'];//关注者昵称
$noticerImg = $_GET['noticerImg'];//关注者头像


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

// 3、保存数据
if($status==1){
    $sql_star = "INSERT INTO star (`sufferId`,`sufferName`,`sufferImg`,`noticer`,`noticerName`,`noticerImg`) VALUES ('$sufferId','$sufferName','$sufferImg','$noticer','$noticerName','$noticerImg')";
}else if ($status==2){
    $sql_star = "SELECT * FROM `star`  WHERE `sufferId` = '$sufferId'";

    //转换库中数据
    $result = $conn->query($sql_star);
    if($result->num_rows > 0){
        // 输出数据 fetch_assoc，遍历表中的每一行数据
        while($row = $result->fetch_assoc()) {
            $tmp = array(); // 临时数组整合信息
            $tmp['sufferId'] = $row['sufferId'];
            $data[] = $tmp; // 自增
        }
        $return[] = $data; // 自增
    } else {
        $return[] = 0;
    }
    $return = json_encode($return[0]);
}else if($status==3){
    $sql_star = "DELETE FROM `star` WHERE `sufferId` LIKE '$sufferId'";
}

// 4、检查是否插入成功
if($conn->query($sql_star)) {
    if($return){
        print_r($return); //JSON_UNESCAPED_UNICODE防止中文乱码
    }
}else {
    echo "Error: " . $sql_star . "<br>" . $conn->error;
}

// 5、关闭数据库
$conn->close();
?>