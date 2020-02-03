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
    $status = $body->status;

    if($status==0){
        $avatarUrl = $body->avatarUrl;
        $id = $body->id;
    }else{
        $personal_data = $body->personal_info;

        // 获取参数
        $id = $personal_data->id;//id
        $nickName = $personal_data->nickName;//昵称
        $realName = $personal_data->realName;//实名
        $sexName = $personal_data->sexName;//性别
        $birthday = $personal_data->birthday;//生日

        //$state = $personal_data->state;//国家
        //$state = $personal_data->province;//省份
        //$city = $personal_data->city;//城市
        $region = json_encode($personal_data->region,JSON_UNESCAPED_UNICODE);//编码（存数据库）

        $industry = $personal_data->industry;//行业
        $position = $personal_data->position;//职位
        $introduction = $personal_data->introduction;//简介
    }

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
    }

    // 3、插入数据//以id(邮箱号)作为主键 进行有选择的插入
    if(!$status){
       //$sql = "INSERT INTO personal_info SELECT (`avatarUrl`) VALUES ('$avatarUrl') WHERE `id`='$id'";
       $sql = "UPDATE personal_info SET `avatarUrl` = '$avatarUrl' WHERE `id` = '$id'";
    }else{
       $sql = "INSERT INTO personal_info (`nickName`,`realName`,`sexName`,`birthday`,`region`,`industry`,`position`,`introduction`) VALUES
       ('$nickName','$realName','$sexName','$birthday','$region','$industry','$position','$introduction')";
       $sql = "UPDATE personal_info SET `nickName` = '$nickName',`realName` = '$realName',`sexName` = '$sexName',`birthday` = '$birthday'
        ,`region` = '$region',`industry` = '$industry',`position` = '$position',`introduction` = '$introduction'
        WHERE `id` = '$id'";
    };

    //print_r(json_decode($region,true)); 解码（取数据库）

    // 4、检查是否插入成功
    if($conn->query($sql) === TRUE) {
        echo "记录更新成功！";
    }else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 5、关闭数据库
    $conn->close();
?>