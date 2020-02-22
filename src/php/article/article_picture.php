<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');  // 解决跨域问题

$data = file_get_contents("php://input");
$data = json_decode($data)  ;//反序列化
$img = $data->file;
$name = $data->name;

//将64位二进制数分隔出来
$avc = explode(",",$img);
$base64_toString = $avc[1];

//解码64位二进制数 这样才能转成图片格式
$img = base64_decode($base64_toString);

//将已经解码的64位的二进制数写到指定文件夹下
$file = fopen("../../assets/article/".$name,"w");//打开文件准备写入
fwrite($file,$img);//写入

$imgPath = "http://localhost/graduation_project/blog2/src/assets/article/".$name;
echo $imgPath;//输出图片路径

fclose($file);//关闭
?>