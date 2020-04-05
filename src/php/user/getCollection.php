<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

//接受前端数据
$bindId = $_GET['bindId'];//邮箱账号
$articleId = $_GET['articleId'];//邮箱账号

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

// 3、查询数据
$sql_search = "SELECT * FROM `collection_detail`  WHERE `bindId` = '$bindId' AND `articleId` = '$articleId'";

//转换库中数据
$result = $conn->query($sql_search);

if($result->num_rows > 0){
    // 输出数据 fetch_assoc，遍历表中的每一行数据
    while($row = $result->fetch_assoc()) {
        $tmp = array(); // 临时数组整合信息
        $tmp['pathId'] = $row['pathId'];
        $tmp['articleId'] = $row['articleId'];
        $tmp['bindId'] = $row['bindId'];
        $data[] = $tmp; // 自增
    }
    $return[] = $data; // 自增
} else {
    $return[] = 0;
}
//$get = json_encode($data[0]['region'],JSON_UNESCAPED_UNICODE);
print_r(json_encode($return[0])); //JSON_UNESCAPED_UNICODE防止中文乱码

// 5、关闭数据库
$conn->close();
?>