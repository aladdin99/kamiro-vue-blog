<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

//得到传输的图片数据
$file = $_FILES['file'];

//得到额外的数据(此处接收账户id)
$id = $_POST['id'];

//得到文件名称
$name = $file['name'];
$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
$allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型


//------------------接收文件数据，存在本地文件夹中------------------
//判断文件类型是否被允许上传
if(!in_array($type, $allow_type)){
    //如果不被允许，则直接停止程序运行
    return ;
}
//判断是否是通过HTTP POST上传的
if(!is_uploaded_file($file['tmp_name'])){
    //如果不是通过HTTP POST上传的
    return ;
}
$upload_path = "../../assets/avatar/"; //上传文件的存放路径
//开始移动文件到相应的文件夹
if(move_uploaded_file($file['tmp_name'],$upload_path.$file['name'])){
    echo "Successfully!";
}else{
    echo "Failed!";
}

//-------------存图片地址到数据库--------------
//拼接图片地址（存于数据库中,前端可以使用:src去寻得地址）
$avatarAddress = "http://localhost/graduation_project/blog2/src/assets/avatar/".$name;
echo $avatarAddress;

// 包含数据库配置信息
include_once('../config.php');
// mysqli 面向对象 编程
// 1、创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 2、检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3、插入数据//以id(邮箱号)作为主键 进行有选择的插入图片地址
$sql = "UPDATE personal_info SET `avatarUrl` = '$avatarAddress' WHERE `id` = '$id'";

// 4、检查是否插入成功
if($conn->query($sql) === TRUE) {
    echo "头像更新成功！";
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 5、关闭数据库
$conn->close();
?>