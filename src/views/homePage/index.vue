<template>
    <div class="home">
        <div :class="{'banner-over':overTop}">
            <navigationBar ></navigationBar>
        </div>
        <el-container class="mainbody">
            <el-aside width="100px">
                <leftSidebar></leftSidebar>
            </el-aside>
            <el-main class="mainstay">
                <div class="advert">MDSN已关闭该广告</div>
                <div class="recommend">
                    <div class="block">
                        <el-carousel trigger="click" height="180px">
                            <el-carousel-item v-for="item in 4" :key="item">
                                <h3 class="small">{{ item }}</h3>
                            </el-carousel-item>
                        </el-carousel>
                    </div>
                    <div class="recbox" >
                        <div style="flex: 1;background-color: #fff1f1;margin-bottom: 2.5px;"></div>
                        <div style="flex: 1;background-color: antiquewhite;margin-top: 2.5px;"></div>
                    </div>
                </div>
            </el-main>
            <el-aside width="280px" style="background-color: #2c3e50;">Aside</el-aside>
        </el-container>
    </div>
</template>

<script>
// @ is an alias to /src
import navigationBar from "components/navigationBar.vue";
import leftSidebar from "components/leftSidebar.vue";

export default {
    name: "login",
    components: {
        navigationBar,leftSidebar
    },
    data(){
        return{
            overTop:false,
        }
    },
    methods:{
        getScrollPosition(){//监听坐标
            let top = document.documentElement.scrollTop || document.body.scrollTop;
            let left = document.documentElement.scrollLeft || document.body.scrollLeft;
            this.overTop = (top>45)?true:false;
            return {top,left}
        }
    },
    mounted() {//监听坐标
        window.addEventListener('scroll',this.getScrollPosition,false)
    },
    destroyed() {//监听坐标(摧毁)
        window/removeEventListener('scroll',this.getScrollPosition,false)
    }
}
</script>

<style lang="less">
    .home{
        height: 100vh;
        background-color: #f5f6f7;
    }
    .banner-over {position: fixed;top: 0;width: 100%;z-index: 100;}

    //轮播图
    .el-carousel__item h3 {color: #475669;font-size: 14px;opacity: 0.75;line-height: 150px;margin: 0;}
    .el-carousel__item:nth-child(2n) {background-color: #99a9bf;}
    .el-carousel__item:nth-child(2n+1) {background-color: #d3dce6;}

    .mainbody{padding: 0 12%;;margin-top: 2rem;
        .mainstay{padding: 0 2rem;text-align: left;height: 100%;
            .advert{display:inline-block;width:100%;height: 8rem;background: #fafafa;text-align: center;line-height: 8rem;color: rgba(0,0,0,.4);font-size: 16px;}
            .recommend{margin-top: 2rem;display: flex;height: 19rem;border: 1px solid pink;
                .block{display:inline-block;width:98%;flex: 2;padding-right: 1rem;}
                .recbox{display: flex;flex: 1;flex-direction:column;height: 18rem;}
            }
        }
    }
</style>