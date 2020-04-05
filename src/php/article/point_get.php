<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题
/////仅初次调用接口返回点赞量，后续由前端自动加或减
// 用于返回数据
$return = array();
$data = array();
//接受前端数据
$status = $_GET['status'];//操作状态 2.查询点赞 1.点赞 0.取消点赞
$articleId = $_GET['articleId'];//文章ID
$userId = $_GET['userId'];//登陆者ID

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
$sql_search = "SELECT * FROM `points`  WHERE `articleId` = '$articleId' ";

//转换库中数据
$result = $conn->query($sql_search);

$back = array();
$flag = 0;
$exit = false;
$count = 0;

if($result->num_rows > 0){
    // 输出数据 fetch_assoc，遍历表中的每一行数据
    while($row = $result->fetch_assoc()) {
        $tmp = array(); // 临时数组整合信息
        $tmp['userId'] = $row['userId'];
        $tmp['time'] = $row['time'];
        $tmp['status'] = $row['status'];
        if($row['userId'] == $userId){
            $flag = (int)$row['status'];
            $exit = true;
        }
        if($row['status']=="1"){
            $count++;
        }
        $data[] = $tmp; // 自增
    }
    $return[] = $data;
}

$back['total'] = $count; //点赞量
$back['flag'] = $flag; //是否已点赞



//$sql_reply_flag = "UPDATE comment SET `replyFlag` = '1' WHERE `id` = '$bindId'";

if($status!=2){
$back=[];
    if($exit){//如果已存在用户点赞 那么更新
        $sql_opera = "UPDATE points SET `status` = '$status' WHERE `articleId` = '$articleId' AND '$userId' = '$userId'";
    }else{//如果不存在该用户点赞 那么新增
        $sql_opera = "INSERT INTO points (userId, `articleId`, `status`) VALUES ('$userId','$articleId','$status')";
    }
    // 操作成功(更新或新增)
    if($conn->query($sql_opera) === TRUE) {

    }else {
        echo "Error: " . $sql_opera . "<br>" . $conn->error;
    }
}

//$get = json_encode($data[0]['region'],JSON_UNESCAPED_UNICODE);
print_r(json_encode($back)); //JSON_UNESCAPED_UNICODE防止中文乱码
//print_r(json_decode($region,true)); 解码（取数据库）

// 5、关闭数据库
$conn->close();
?>