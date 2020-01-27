<?php
    header("Content-type: text/html; charset=utf-8");
    header('Access-Control-Allow-Origin:*');  // 解决跨域问题

    // 接收前端数据
    error_reporting(0); // 不会弹出警告，只适合当前页
    $email = $_GET['email'];
    $pass = $_GET['password'];

    // 包含数据库配置信息
    include_once('./config.php');

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
    }

    // 3、查询数据
    $sql_search = "SELECT * FROM `user_regist`  WHERE `email` = '$email'";
    $result = $conn->query($sql_search);

    $back = array();

    if($result->num_rows > 0){
        // 输出数据 fetch_assoc，遍历表中的每一行数据
        while($row = $result->fetch_assoc()) {
        //echo $password.$row['email_key'];
            if($pass == $row['email_key']){
                $back['isLogin'] = '1';//账号密码正确
            }else{
                $back['isLogin'] = '0';//密码错误
            }
        }
    } else {
      $back['isLogin'] = '-1';//账号不存在
    }
    echo json_encode($back,JSON_UNESCAPED_UNICODE); //JSON_UNESCAPED_UNICODE防止中文乱码
?>
