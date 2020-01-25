<!--博文列表预览页面-->
<template>
    <div class="home">
        <!-- Top navigation bar-->
        <div :class="{'bannerMenu':bannerScroll}">
            <navigationBar ></navigationBar>
        </div>
        <el-container class="mainbody">
            <!--Left navigation bar-->
            <el-aside width="10rem">
                <div :class="{'leftMenu':leftScroll}">
                    <leftSidebar></leftSidebar>
                </div>
            </el-aside>
            <!--Content preview section-->
            <el-main class="mainstay">
                <div class="advert">MDSN已关闭该广告</div>
                <div class="recommend">
                    <div class="block">
                        <el-carousel trigger="click" height="190px">
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
                <div class="content" v-for="item in 150" :key="item">
<!--                    每一篇文章简介-->
                    <div>
                        <router-link to="/index/user/details" style="text-decoration: none;"><div class="title">MIT博士99 行代码就能实现《冰雪奇缘》的特效引擎入门-用Taichi画太极-用Taichi画太-用Taichi画太</div></router-link>
                        <div class="introduction">可能最近不少读者也像我一样被某公号的那篇《清华毕业生开发新特效编程语言，99行代码实现《冰雪奇缘》，网友：大神碉堡！创世的快乐》吓了一大跳</div>
                        <div class="root">
                            <div><el-avatar size="small" :src="circleUrl"></el-avatar><router-link to="/index/user"><span class="nickName">不脱发的程序员</span></router-link></div>
                            <div class="partake">
                                <span><icon-svg icon-class="icon-dianzan"/></span>
                                <el-divider direction="vertical"></el-divider>
                                <span><icon-svg icon-class="icon-liulan"/></span>
                                <el-divider direction="vertical"></el-divider>
                                <span><icon-svg icon-class="icon-pinglun"/></span>
                            </div>
                        </div>
                    </div>
                </div>
            </el-main>
            <el-aside width="28rem" class="partRight">
                <div >
                    <rightSidebar :class="{'rightMenu':rightScroll}"></rightSidebar>
                    <span ref="searchBar"></span>
                </div>
            </el-aside>
        </el-container>
    </div>
</template>

<script>
// @ is an alias to /src  /Integration style properties
import navigationBar from "components/navigationBar.vue";
import leftSidebar from "components/index/leftSidebar.vue";
import rightSidebar from "components/index/rightSidebar.vue";

export default {
    name: "login",
    components: {
        navigationBar,leftSidebar,rightSidebar
    },
    data(){
        return{
            bannerScroll:false,
            leftScroll:false,
            rightScroll:false,
            circleUrl:"https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",
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
            this.leftScroll = (top>65)?true:false;
            this.rightScroll = (searchBar<currentHeigh)?true:false;
            return {top,left}
        }
    },
    mounted() {
        //监听banner栏坐标
        window.addEventListener('scroll',this.getScrollPosition,false)
    },
    destroyed() {
        //监听banner栏坐标(摧毁)
        window/removeEventListener('scroll',this.getScrollPosition,false)
    }
}
</script>

<style lang="less">
    .home{
        height: 100%;
        background-color: #f5f6f7;
    }
    .bannerMenu {position: fixed;top: 0;width: 100%;z-index: 101;}
    .leftMenu {position: fixed;top: 6rem;z-index: 100;}
    .rightMenu {position: fixed;z-index: 100;width: 28rem;bottom: 0;}//上滑超出直接将右侧组件置bottom为零(无需计算超出多少高度)
    //轮播图
    .el-carousel__item h3 {color: #475669;font-size: 1.4rem;opacity: 0.75;line-height: 1.5rem;margin: 0;}
    .el-carousel__item:nth-child(2n) {background-color: #99a9bf;}
    .el-carousel__item:nth-child(2n+1) {background-color: #d3dce6;}

    //定义主题颜色
    .theme-color{color: #D92E2E;}
    .bgColor{background-color: #D92E2E;}//红

    .mainbody{padding: 0 12vw;margin-top: 1.5rem;
        .partLeft{}
        .partRight{position: relative;
            .advert{display:inline-block;width:100%;height: 8rem;background: #fafafa;text-align: center;line-height: 8rem;color: rgba(0,0,0,.4);font-size: 16px;}
            .recommend{margin-top: 2rem;display: flex;height: 19rem;border: 1px solid pink;background-color: #ca0c16;margin-bottom: 2rem;}
        }
        .mainstay{padding: 0 2rem;text-align: left;height: 100%;
            .advert{display:inline-block;width:100%;height: 8rem;background: #fafafa;text-align: center;line-height: 8rem;color: rgba(0,0,0,.4);font-size: 16px;}
            .recommend{margin-top: 2rem;display: flex;height: 19rem;border: 1px solid pink;margin-bottom: 2rem;
                .block{display:inline-block;width:98%;flex: 2;padding-right: 1rem;}
                .recbox{display: flex;flex: 1;flex-direction:column;height: 19rem;}
            }
            .content{padding: 1.5rem;background-color: #fff;border-bottom:.1rem solid #f5f6f7;transition: background-color .25s;
                &:hover{background-color: #F3F3F3;transition: background-color .25s;}
                .title{line-height: 2.4rem;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;color: #3d3d3d;height: 2.4rem;font-size: 1.8rem;color: #3d3d3d;font-weight: bold;
                    &:hover{color: #D92E2E;cursor: pointer;}
                }
                .introduction{margin-bottom: .2rem;color: #8a8a8a;font-size: 1.4rem;line-height: 2.4rem;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;}
                .root{display: flex;justify-content: space-between;line-height: 2.4rem;cursor: pointer;
                    .nickName{display: inline-block;margin-left: .5rem;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;color:#3D3D3D; &:hover{color: #428bca;}}
                    .partake{display: flex;align-items:center;.svg-icon{width: 1.6rem;height: 1.6rem;}}
                }
            }
        }
    }
</style>