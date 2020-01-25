<!--一篇博文内容-->
<template>
    <div class="user">
        <!-- Top navigation bar-->
        <div :class="{'UbannerMenu':bannerScroll}">
            <navigationBar></navigationBar>
        </div>
        <el-container class="mainbody">
            <!--Left user information bar-->
            <el-aside width="30rem" style="position: relative;">
                <div>
                    <userLeftBar :class="{'UleftMenu':leftScroll}"></userLeftBar>
                    <span ref="searchBar"></span>
                </div>
            </el-aside>
            <!--Middle content preview section-->
            <el-main class="mainstay">
                <catalogDetail></catalogDetail>
            </el-main>
        </el-container>
    </div>
</template>

<script>
    import navigationBar from "components/navigationBar.vue";
    import userLeftBar from "components/user/userLeftBar.vue";
    import catalogDetail from "components/user/catalogDetail.vue";
    export default {
        name: "user",
        components: {
            navigationBar,userLeftBar,catalogDetail
        },
        data(){
            return{
                bannerScroll:false,
                leftScroll:false,
            }
        },
        methods:{
            getScrollPosition(){//监听banner栏坐标
                let top = document.documentElement.scrollTop || document.body.scrollTop;
                let left = document.documentElement.scrollLeft || document.body.scrollLeft;
                if(top){//获取右边栏底部标签'searchBar'距顶部的距离
                    var searchBar = this.$refs.searchBar.getBoundingClientRect().top;
                }
                let currentHeigh = window.innerHeight;//当前内容高度  1235///680
                this.bannerScroll = (top>45)?true:false;
                this.leftScroll = (searchBar<currentHeigh)?true:false;
                return {top,left}
            }
        },
        mounted() {
            //监听banner栏坐标
            window.addEventListener('scroll',this.getScrollPosition,false)
        },
        destroyed() {
            //监听banner栏坐标(摧毁)
            window.removeEventListener('scroll',this.getScrollPosition,false)
        }
    }
</script>

<style lang="less">
    .user{
        height: 100%;
        background-color: #343536;
    }
    .UbannerMenu {position: fixed;top: 0;width: 100%;z-index: 101;}
    .UleftMenu {position: fixed;z-index: 100;width:30rem;bottom: 0;}//上滑超出直接将左侧组件置bottom为零(无需计算超出多少高度)

    .mainbody{padding: 0 12vw;margin-top: 1.5rem;
        .mainstay{padding: 0 2rem;text-align: left;height: 100%;}
    }
</style>