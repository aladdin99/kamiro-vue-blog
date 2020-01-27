<?php
    header("Content-type: text/html; charset=utf-8");
    header('Access-Control-Allow-Origin:*');  // 解决跨域问题

    require_once("./sendEmail.php");

    // 接收前端数据
    error_reporting(0); // 不会弹出警告，只适合当前页
    $email = $_GET['email'];
    $password = $_GET['password'];
    $nickName = $_GET['nickName'];

    //用邮件注册账号/也是收邮件的账号
    $to = $email;
    $title = "这是标题哦!";
    $content = '<h1>账号注册:</h1>
                <a href=http://localhost/graduation_project/blog2/src/php/checking.php?email='.$email.'&password='.$password.'&nickName='.$nickName.'>点此激活</a>' . date('Y-m-d H:i:s');
                //通过上述链接跳转到验证接口'checking'

    // 包含数据库配置信息
    include_once('./config.php');

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
    }

    $back = array();

    // 3、查询数据
    $sql_search = "SELECT * FROM `user_regist`  WHERE `email` = '$email'";
    $result = $conn->query($sql_search);
    if($result->num_rows > 0){
        $back['status'] = '1';//标识:已存在
    } else {
        $back['status'] = '0';//标识:未存在
        // 3-1、插入数据
        sendMail($to,$title,$content);
    }
    echo json_encode($back,JSON_UNESCAPED_UNICODE); //JSON_UNESCAPED_UNICODE防止中文乱码
?>
