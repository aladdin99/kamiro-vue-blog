<!--个人中心-->
<template>
    <div class="personal">
        <!-- Top navigation bar-->
        <div :class="{'UbannerMenu':bannerScroll}">
            <navigationBar></navigationBar>
        </div>
        <el-container class="mainbody">
            <!--Left user information bar-->
            <el-aside width="20rem">
                <ul class="leftBar">
                    <li style="background-color: #b20b13;color: #fff;">个人资料</li>
                    <li>我的收藏</li>
                    <li>我的勋章</li>
                    <li>我关注的人</li>
                    <li>我的粉丝</li>
                    <li>我的标签</li>
                    <li>我的博客</li>
                    <li>我的问答</li>
                    <li>签到赢福利</li>
                    <li>抽奖</li>
                </ul>
            </el-aside>
            <!--Middle content preview section-->
            <el-main class="mainstay" style="box-shadow: 1px 2px 3px #e0e0e0;background-color: #fff;">
                <div class="bannerTop">个人资料</div>
                <div class="setUp">
                    <div class="avatar">
                        <span></span>
                        <div>修改头像</div>
                    </div>
                    <div class="means">
                        <div class="part1">
                            <span>ID: qq_39994421</span>
                            <span>个人主页 <i class="el-icon-arrow-right"></i></span>
                        </div>
                        <div class="part2">
                            <span>关注 3</span>
                            <span>粉丝 2</span>
                        </div>
                        <ul class="part3">
                            <li>
                                <div>昵称: <span>Aladdin99</span></div>
                                <span>修改资料</span>
                            </li>
                            <li>实名: <span>underfine</span></li>
                            <li>性别: <span>男</span></li>
                            <li>生日: <span>2020-1-24</span></li>
                            <li>地区: <span>中国 福建省 泉州市</span></li>
                            <li>行业: <span>互联网</span></li>
                            <li>职位: <span>前端摸鱼玩家</span></li>
                            <li>简介: <span>哈哈哈哈哈哈</span></li>
                        </ul>
                    </div>
                </div>
            </el-main>
        </el-container>
    </div>
</template>

<script>
    import navigationBar from "components/navigationBar.vue";
    export default {
        name: "user",
        components: {
            navigationBar,
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
    .personal{
        height: 100%;
        background-color: #f5f6f7;
    }

    .personal{
        .mainbody{padding: 0 12vw;margin-top: 1.5rem;
            .leftBar{list-style: none;text-align: left;cursor: pointer;font-size: 1.4rem;border: 1px solid #E6E6E6;display: inline-block;width: 100%;box-sizing: border-box;background-color: #fff;
                li{padding: 1rem 1.5rem;box-sizing: border-box; &:hover{background-color: #FDE0EC;color: #b20b13;}}
            }
            .mainstay{padding: 0 3rem;text-align: left;height: auto;
                .bannerTop{font-size: 2rem;color: #3d3d3d;line-height: 9rem;border-bottom: 1px solid #e0e0e0;font-weight: bold;}
            }
            .setUp{display: flex;padding: 2rem 0;text-align: left;
                .avatar{flex: 1;cursor: pointer;
                    span{display: inline-block;width: 10rem;height: 10rem;border-radius: 50%;background-color: #FDE0EC;margin-left: 50%;transform: translateX(-50%)}
                    div{text-align: center;padding: 1rem 0;color: #3399ea;}
                }
                .means{flex: 7;padding-left: 1rem;
                    .part1{display: flex;justify-content: space-between;align-items: center;
                        span:nth-child(1){font-size: 1.4rem;color: #999;}
                        span:nth-child(2){color: #3399ea;cursor: pointer;}
                    }
                    .part2{padding: 1rem 0;font-size: 1.4rem;color: #4D4D4D;border-bottom: 1px solid #e0e0e0;
                        span{padding-right: 2rem;}
                    }
                    .part3{list-style: none;padding: 1rem 0;
                        li{display: flex;padding: .8rem 0;font-size: 1.4rem;color: #4D4D4D;
                            span{padding-left: 1rem;}
                            &:nth-child(1){display: flex;justify-content: space-between;
                                span:nth-child(2){color: #3399ea;cursor: pointer;}
                            }
                        }
                    }
                }
            }
        }
    }
</style>