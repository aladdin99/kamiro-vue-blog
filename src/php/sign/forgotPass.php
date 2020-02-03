<?php
    header("Content-type: text/html; charset=utf-8");
    header('Access-Control-Allow-Origin:*');  // 解决跨域问题

    require_once("./sendEmail.php");

    // 接收前端数据
    error_reporting(0); // 不会弹出警告，只适合当前页
    $email = $_GET['email'];//邮箱账号
    $newpass = $_GET['newpass'];//新密码
    $verfiCode = $_GET['verfiCode'];//验证码
    $status = $_GET['status'];//前端传来0.验证码机制 1.重置密码

   // echo $status,$email,$password,$verfiCode;

    //验证码机制
    if($status==0){
        //A-Z a-z 0-9 !#$%^&*
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        //生成随机字符
        function createCode($str,$len){
          $pwd = '';
          $strlen = strlen($str);
          for($i=0;$i<$len;$i++){
            $pwd .= $str{mt_rand(0,$strlen-1)};
          }
          return $pwd;
        }
        $verificationCode = createCode($str,6);

        //用邮件注册账号/也是收邮件的账号
        $to = $email;
        $title = "这是标题哦!";
        $content = '<h1>重置密码_验证码:</h1>
                    <div>【MSDN】 您正在使用邮箱找回密码，验证码'.$verificationCode.',有效期10分钟。</div>'. date('Y-m-d H:i:s');

        // 发送邮件.验证码
        sendMail($to,$title,$content);
    };

    // 将验证码添加到数据库/重置密码
    // 包含数据库配置信息
    include_once('../config.php');

    // mysqli 面向对象 编程
    // 1、创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2、检查连接
    if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
    }

    $back = array();//用作回传给前端的数据

    // 3、插入数据
    if($status==0){
        $sql_set = "UPDATE user_regist SET `verifi_code` = '$verificationCode' WHERE `email` = '$email'";
    }else{
        $sql_search = "SELECT * FROM `user_regist`  WHERE `email` = '$email'";
        $result = $conn->query($sql_search);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($verfiCode == $row['verifi_code']){//验证码校验通过->更新密码
                    $sql_set = "UPDATE user_regist SET `email_key` = '$newpass' WHERE `email` = '$email'";
                    $back['reset'] = 1;
                    //echo '校验通过!';
                }else{//验证码校验不通过->提示用户
                    $back['reset'] = 0;
                    //echo '校验错误!';
                }
            }
        }
    }

    // 4、检查是否更新成功
    if($conn->query($sql_set) === TRUE) {
        echo "记录更新成功！";
    }else {
        echo "Error: " . $sql_set . "<br>" . $conn->error;
    }

    //回传信息给前端
    echo json_encode($back,JSON_UNESCAPED_UNICODE); //JSON_UNESCAPED_UNICODE防止中文乱码

    // 5、关闭数据库
    $conn->close();
?>
