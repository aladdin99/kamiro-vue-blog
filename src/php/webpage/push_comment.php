<?php
    header("Content-type: text/html; charset=utf-8");
    header('Access-Control-Allow-Origin:*');  // 解决跨域问题

    // 包含数据库配置信息
    include_once('../config.php');

    // POST请求
    // 接收前端数据
    error_reporting(0); // 不会弹出警告，只适合当前页

    $body = @file_get_contents('php://input');//接受整个请求主体
    $body = json_decode($body)  ;//反序列化

     // 获取参数
    $status = $body->status; //判断评论或回复 1.回复 0.评论
    $bindId = $body->bindId;
    $userId = $body->userId;//评论者id
    $avarUrl = $body->avarUrl;//评论者头像
    $comment = $body->comment;//评论
    $userName = $body->userName;//评论者昵称
    $articleId = $body->articleId;//文章id
    $title = $body->title;//文章标题
    $authorId = $body->authorId;//文章作者id
    $showFlag = $body->showFlag;//1.回复需要审核 0.回复不需要审核

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
    }

    // 3、查询数据
    if($status == 1){//回复
        $sql_insert = "INSERT INTO reply (userId, `userName`,`avarUrl`,`comment`,`bindId`,`articleId`) VALUES ('$userId','$userName','$avarUrl','$comment','$bindId','$articleId')";
        $sql_reply_flag = "UPDATE comment SET `replyFlag` = '1' WHERE `id` = '$bindId'";
        echo $bindId;
        if($conn->query($sql_reply_flag) === TRUE) {
            echo "纪录更新成功！";
        }else {
            echo "Error: " . $sql_reply_flag . "<br>" . $conn->error;
        }
    }else if($status == 0){//评论
        $sql_insert = "INSERT INTO comment (userId, `userName`,`avarUrl`,`comment`,`bindId`,`title`,`authorId`,`showFlag`) VALUES ('$userId','$userName','$avarUrl','$comment','$bindId','$title','$authorId','$showFlag')";
    }

    // 4、检查是否插入成功
    if($conn->query($sql_insert) === TRUE) {
        echo "新纪录插入成功！";
    }else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }

    // 5、关闭数据库
    $conn->close();
?>