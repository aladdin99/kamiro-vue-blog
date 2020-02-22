login.vue -> 登陆页

md-->
    mavon.vue       -> 博文编辑页面(采用markdown编辑器)
    released.vue    -> 博文发布成功页面
    
personal-->
    index.vue -> 点击头像进入的个人中心页面
        dataInfo.vue    -> '个人资料'(组件)
        collection.vue  -> '我的收藏'(组件)
        star.vue        -> '我的关注'(组件)
        follow.vue      -> '我的粉丝'(组件)
        
homePage-->
    index.vue -> 博客首页
        navigationBar.vue   -> 首页顶部栏(组件)
        leftSidebar.vue     -> 首页左部列表(组件)
        rightSidebar.vue    -> 首页右部列表(组件)
    user ->
        user.vue -> 其它网友的博客站点
            navigationBar.vue -> 同样引入首页顶部栏(组件)
            userLeftBar.vue     -> 站点左部列表(组件)
            catalogPreview.vue  -> 站点主体所有博文的预览部分(组件)
            catalogDetail.vue   -> 点开预览进入单篇的博文部分(组件)   
    
    