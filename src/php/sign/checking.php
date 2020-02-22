<?php
    //邮件验证接口//是否是本人的邮件
    //邮件ID,注册密码
    $email = $_GET["email"];
    $email_key = $_GET["password"];
    $nickName = $_GET["nickName"];
    echo $email.$email_key,$nickName;

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

    // 3-1、插入数据
    $sql_insert_regist = "INSERT INTO user_regist (email, `email_key`,`nickName`) VALUES ('$email', '$email_key','$nickName')";
    $sql_insert_info = "INSERT INTO personal_info (id, `nickName`) VALUES ('$email', '$nickName')";

    // 4、检查是否插入成功
    if(($conn->query($sql_insert_regist) === TRUE) && ($conn->query($sql_insert_info) === TRUE)) {
      echo "新纪录插入成功！";
    }else {
    echo "Error: " . $sql_insert_regist . "<br>" . $conn->error;
    }

    // 5、关闭数据库
    $conn->close();
?>