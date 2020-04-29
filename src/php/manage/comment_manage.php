<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 用于返回数据
$return = array();
$data = array();
//接受前端数据
$status = $_GET['status'];//邮箱账号
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

// 3、查询数据
if($status==1){//1.获取自己所有文章的评论
    $sql_search = "SELECT * FROM `comment`  WHERE `authorId` = '$id'";
}else if($status==2){//2.获取我发布的评论
    $sql_search = "SELECT * FROM `comment`  WHERE `userId` = '$id'";
}else if($status==3){//3.待我审核的评论
    $sql_search = "SELECT * FROM `comment`  WHERE `authorId` = '$id' AND `showFlag` = 1";
}


//转换库中数据
$result = $conn->query($sql_search);

$back = array();

if($result->num_rows > 0){
    // 输出数据 fetch_assoc，遍历表中的每一行数据
    while($row = $result->fetch_assoc()) {
        $tmp = array(); // 临时数组整合信息
        $tmp['comment'] = $row['comment'];
        $tmp['id'] = $row['id'];
        $tmp['userId'] = $row['userId'];
        $tmp['bindId'] = $row['bindId'];
        $tmp['authorId'] = $row['authorId'];
        $tmp['time'] = $row['time'];
        $tmp['title'] = $row['title'];
        $tmp['userName'] = $row['userName'];
        $tmp['avarUrl'] = $row['avarUrl'];
        $tmp['title'] = $row['title'];
        $data[] = $tmp; // 自增
    }
    $return[] = $data;//赋值输出的每一组数据
} else {
    $return[] = 0;
}
//$get = json_encode($data[0]['region'],JSON_UNESCAPED_UNICODE);
print_r(json_encode($return[0])); //JSON_UNESCAPED_UNICODE防止中文乱码
//print_r(json_decode($region,true)); 解码（取数据库）

?>