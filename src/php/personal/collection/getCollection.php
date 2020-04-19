<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

// 用于返回数据
$return = array();
$data = array();
//接受前端数据
$pathId = $_GET['pathId'];//收藏夹id
$bindId = $_GET['bindId'];//当前用户账号id

// 包含数据库配置信息
include_once('../../config.php');

// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、查询数据
$sql_search = "SELECT * FROM `collection_detail`  WHERE `pathId` = '$pathId' AND `bindId` = '$bindId'";

//转换库中数据
$result = $conn->query($sql_search);

$back = array();

if($result->num_rows > 0){
    // 输出数据 fetch_assoc，遍历表中的每一行数据
    while($row = $result->fetch_assoc()) {
        $tmp = array(); // 临时数组整合信息
        $tmp['title'] = $row['title'];
        $tmp['pubdate'] = $row['pubdate'];
        $tmp['author'] = $row['author'];
        $tmp['authorId'] = $row['authorId'];
        $tmp['bindId'] = $row['bindId'];
        $tmp['pathId'] = $row['pathId'];
        $tmp['articleId'] = $row['articleId'];
        $data[] = $tmp; // 自增
    }
    $back[] = $data;
} else {
    $back[0] = 0;
}
//$get = json_encode($data[0]['region'],JSON_UNESCAPED_UNICODE);
print_r(json_encode($back[0])); //JSON_UNESCAPED_UNICODE防止中文乱码
//print_r(json_decode($region,true)); 解码（取数据库）

?>