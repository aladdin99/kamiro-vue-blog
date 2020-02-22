config.php -> 数据库连接配置

article -->
    article.php -> 博文编辑完成后保存接口(对应页面 'mavon.vue')
    
personal -->
    getData.php     -> 查询'个人资料'接口
    saveData.php    -> 保存'个人资料'接口    
    collection -->
        collection.php  -> '我的收藏'新建或更新收藏夹接口
    
PHPMail -->
    Exception.php/PHPMailer.php/POP3.php/SMTP.php 插件方法 用来发送邮件的方法

sign --> 
    checking.php    -> 账户注册接口 邮箱验证码验证并保存注册记录
    forgotPass.php  -> '忘记密码'接口 通过邮箱进行找回并重置密码
    login.php       -> 账号登陆验证接口(在服务端进行密码验证,起到安全性)
    register.php    -> 账号注册接口 判断是否已注册过,否则发送邮件注册
    sendEmail.php   -> 邮件发送接口