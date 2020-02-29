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
    $related = $body->related;
    $nickName = $body->nickName;
    $title = $body->title;
    $content = $body->content;
    $tag = $body->tag;
//    $category = $body->category;
    $category = json_encode($body->category,JSON_UNESCAPED_UNICODE);
    $type = $body->type;
    $links = $body->links;
    $shape = $body->shape;
    $draftsFlag = $body->draftsFlag;//文章是否是草稿 0.草稿 1.非草稿
    $uniqueIdFlag = $body->uniqueIdFlag;//文章的唯一ID
    //print_r($id);

    //通过调用PHP中uniquid方法随机生成一个唯一的id,避免出现冲突的文章
    $uniqueId = uniqid();
    //echo uniqid();//生成唯一ID的函数

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    $avartar = '';
    $seach_avartar = "SELECT avatarUrl FROM `personal_info`  WHERE `id` = '$related'";
    $avartar_result = $conn->query($seach_avartar);
    if($avartar_result->num_rows > 0){
        // 输出数据 fetch_assoc，遍历表中的每一行数据
        while($row = $avartar_result->fetch_assoc()) {
            $avartar = $row['avatarUrl'];
        }
    } else {
        echo '0结果!';
    }

    // 3、插入数据//以id(邮箱号)作为主键 进行有选择的插入
    if(!$uniqueIdFlag){//如果没有文章唯一键，那么就是新文章，插入新记录
        $sql = "INSERT INTO article (`uniqueId`,`related`,`author`,`title`,`content`,`tag`,`category`,`type`,`links`,`shape`,`draftsFlag`,`avatarUrl`) VALUES
               ('$uniqueId','$related','$nickName','$title','$content','$tag','$category','$type','$links','$shape','$draftsFlag','$avartar')";
    }else{//如果有了文章唯一键，那么就是草稿，需要更新文章
        echo $draftsFlag;
        if($draftsFlag==1){//如果是'发布文章',那么更新以下的所有数据
            $sql = "UPDATE article SET `title` = '$title',`content` = '$content',`tag` = '$tag',`category` = '$category',
        `type` = '$type',`type` = '$type',`links` = '$links',`shape` = '$shape',`draftsFlag` = '$draftsFlag' WHERE `uniqueId` LIKE '$uniqueIdFlag' And `related` LIKE '$related'";
        }else{//如果还是'保存草稿'，那么只更新文章的标题个文章内容
            $sql = "UPDATE article SET `title` = '$title',`content` = '$content' WHERE `uniqueId` LIKE '$uniqueIdFlag' And `related` LIKE '$related'";
        }

    }


    // 4、检查是否插入成功
    if($conn->query($sql) === TRUE) {
        if($draftsFlag && !$uniqueIdFlag){
            echo $uniqueId;
        }
    }else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 5、关闭数据库
    $conn->close();
?>


