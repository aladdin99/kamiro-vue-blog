<?php
    //邮件验证接口//是否是本人的邮件
    //邮件ID,注册密码
    $email = $_GET["email"];
    $password = $_GET["password"];
    $nickName = $_GET["nickName"];
    echo $email.$password,$nickName;

    // 用于返回数据
    $return = array();
    $data = array();

    // 包含数据库配置信息
    include_once('./config.php');

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
    }

    // 3-1、插入数据
    $sql_insert = "INSERT INTO user_regist (email, `email_key`,`nickName`) VALUES ('$email', '$password','$nickName')";

    // 4、检查是否插入成功
    if($conn->query($sql_insert) === TRUE) {
      echo "新纪录插入成功！";
    }else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }

    // 5、关闭数据库
    $conn->close();
?>