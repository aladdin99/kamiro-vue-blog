<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

//得到传输的图片数据
$file = $_FILES['file'];
//得到额外的数据(此处接收账户id)
//$id = $_POST['id'];

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
$upload_path = "../../assets/sort/"; //上传文件的存放路径
//开始移动文件到相应的文件夹
if(move_uploaded_file($file['tmp_name'],$upload_path.$file['name'])){
    $avatarAddress = "http://localhost/graduation_project/blog2/src/assets/sort/".$name;
    print_r($avatarAddress);
}else{
    echo "Failed!";
}
//$data = array();


//echo $avatarAddress;

?>