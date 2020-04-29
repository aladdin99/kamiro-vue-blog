<template>
    <div class="setupBlog">
        <div class="block">
            <h1>退出</h1>
            <el-slider v-model="valueCode" style="margin-top: 5rem;" @change="exitNow"></el-slider>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                valueCode:""
            }
        },
        methods:{
            exitNow(val){
                // let routeUrl = this.$router.resolve({
                //     path: "/"
                // });
                let storage = window.localStorage;
                if(val==100){
                    storage.removeItem("nickName");
                    storage.removeItem("email");
                    storage.removeItem("imageUrl");
                    // window.open(routeUrl.href, '_blank');
                    // window.open(routeUrl.href, );
                    this.$router.push({path: "/",redirect: '/'});//路由重定向
                }else if(val>50&&val<100){
                    alert("账号即将推出...");
                }else if(val>0&&val<50){
                    alert("账号正在执行退出操作...");
                }
            }
        }
    }
</script>

<style lang="less">
    .setupBlog{
        height: 100%;
        /*background-color: #343536;*/
    }
    .block{box-sizing: border-box;padding: 2rem;}
</style>