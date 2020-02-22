<?php
    header("Content-type: text/html; charset=utf-8");
    header('Access-Control-Allow-Origin:*');  // 解决跨域问题
    // 包含数据库配置信息
    include_once('../../config.php');

    // POST请求
    // 接收前端数据
    error_reporting(0); // 不会弹出警告，只适合当前页
    $body = @file_get_contents('php://input');//接受整个请求主体
    $body = json_decode($body)  ;//反序列化

    //获取字段数据
    $status = $body->status;//1-新建收藏夹 2-查询收藏夹

    $bind = $body->bind;//bind
    $title = $body->title;//title
    $describe = $body->describe;//describe
    $power = $body->power;//power
    $id = $body->id;//power

    //通过调用PHP中uniquid方法随机生成一个唯一的id,避免出现冲突的收藏夹
    $idNew = uniqid();
    //echo uniqid();//生成唯一ID的函数

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    // 用于返回数据
    $return = array();
    $data = array();

    function connResult($sql){
        if($conn->query($sql) === TRUE) {
            echo "记录更新成功！";
        }else {
           echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // 3、插入数据(id是收藏夹的唯一值 主键；bind是邮箱号作为外键 识别该收藏夹对应的用户)
    if($status==1){
        $sql_search = "SELECT * FROM `collection_clip`  WHERE `id` = '$id'";//检索收藏夹
        $result_search = $conn->query($sql_search);
        if($result_search->num_rows > 0){//如果收藏夹已经存在，那么就去更新收藏夹
            $sql = "UPDATE collection_clip SET `title` = '$title',`describe` = '$describe',`power` = '$power' WHERE `id` = '$id'";
        }else{//如果收藏夹不存在，那么就新建收藏夹
            $sql = "INSERT INTO collection_clip (`id`,`bind`,`title`,`describe`,`power`) VALUES ('$idNew','$bind','$title','$describe','$power')";
        }
    }else if($status==2){
        $sql = "SELECT * FROM `collection_clip`  WHERE `bind` LIKE '$bind'";
        //转换库中数据
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            // 输出数据 fetch_assoc，遍历表中的每一行数据
            while($row = $result->fetch_assoc()) {
                $tmp = array(); // 临时数组整合信息
                $tmp['id'] = $row['id'];
                $tmp['title'] = $row['title'];
                $tmp['describe'] = $row['describe'];
                $tmp['power'] = $row['power'];
                $data[] = $tmp; // 自增
            }
            $return[] = $data;//赋值输出的每一组数据
        } else {
          $return['result'] = 0;
            echo "0 结果";
        }
    }else if($status==3){
        $sql_del = "DELETE FROM `collection_clip` WHERE `id` LIKE '$id'";
        echo $conn->query($sql_del);
    }
    print_r(json_encode($return[0],JSON_UNESCAPED_UNICODE));//返回给前端的数据



    // 4、检查是否插入成功
    if($conn->query($sql) === TRUE) {
        echo "记录更新成功！";
    }else {
       // echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 5、关闭数据库
    $conn->close();
?>