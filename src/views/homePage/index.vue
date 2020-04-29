<!--博文列表预览页面-->
<template>
    <div class="home">
        <!-- Top navigation bar-->
        <div :class="{'bannerMenu':bannerScroll}" class="special_bar">
            <navigationBar></navigationBar>
        </div>
        <el-container class="mainbody_ip">
            <el-main class="mainstay_index">
                <span ref="searchBar"></span>
                <div class="mainstay_List" v-for="(item,index) in article_data" :key="index">
                    <div style="padding-top: 2rem;"></div>
                    <router-link :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}">
                        <div class="mainstay_List_title">
                            <h2>{{item.title}}</h2>
                        </div>
                    </router-link>
                    <div  class="mainstay_List_content">
                        <div class="mainstay_List_img">
                            <router-link :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}">
                                <div class="overFlow">
                                    <img :src="preview+index +'.jpg'">
                                </div>
                            </router-link>
                        </div>
                        <router-link :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}">
                            <div class="mainstay_List_article">
                                {{item.content}}
                            </div>
                        </router-link>
                    </div>
                    <div class="mainstay_List_bottom">
                        <router-link :to="{path:'/index/webpage',query:{userId:item.related}}">
                            <span class="mainstay_List_author">{{item.author}}</span>
                        </router-link>
                        <span class="mainstay_List_time">{{item.time}}</span>
<!--                        <span class="mainstay_List_comment">3评论</span>-->
<!--                        <span class="mainstay_List_point">2个赞</span>-->
                    </div>
                </div>
            </el-main>
        </el-container>
    </div>
</template>

<script>
// @ is an alias to /src  /Integration style properties
import navigationBar from "components/navigationBar.vue";
// import leftSidebar from "components/index/leftSidebar.vue";
// import rightSidebar from "components/index/rightSidebar.vue";
export default {
    name: "login",
    components: {
        navigationBar,
        // leftSidebar,
    },
    data(){
        return{
            preview: "http://localhost/graduation_project/blog2/src/assets/preview/pic_",
            bannerScroll:false,
            leftScroll:false,
            rightScroll:false,
            circleUrl:"https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",
            article_data: [],//首页展示的所有文章
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
        },
        get_article(){//获取主页所有文章数据
            let self = this;
            this.$axios.get('http://localhost/graduation_project/blog2/src/php/index/get_index_article').then(function(res){
                let article = res.data.reverse();
                article.forEach(item=>{
                    item.content = self.getSimpleText(item.content);//文章预览页面.只展示纯文本!
                });
                self.article_data = article;
            });
        },
        getSimpleText(html){//富文本中提取纯文本(删掉所有的样式和图片,只保留纯文本和标点符号)
            var re1 = new RegExp("<.+?>","g");//匹配html标签的正则表达式，"g"是搜索匹配多个符合的内容
            var msg = html.replace(re1,'');//执行替换成空字符
            var result = msg.replace(/[\r\n]/g,"");//取消文本中的换行
            return result;
        },
    },
    mounted() {
        //监听banner栏坐标
        window.addEventListener('scroll',this.getScrollPosition,false);
        this.get_article();
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
        min-height: 100vh;
        /*background-color: #f5f6f7;*/
        background: url("../../assets/theme.jpg");
        background-size: 100% 100%;
        background-attachment: fixed;
        color: #777;
        fontFamily: 'Microsoft Yahei','Helvetica Neue',Helvetica,Arial,'sans-serif';
        z-index: 1000;
    }
    .special_bar{background-color: rgba(85,84,85, 0.5);color: rgba(85,84,85, 0.5);z-index: 999;}
    .bannerMenu {position: fixed;top: 0;width: 100%;z-index: 101;}
    .leftMenu {position: fixed;top: 6rem;z-index: 100;}
    /*.rightMenu {position: fixed;z-index: 100;width: 35rem;bottom: 0;}//上滑超出直接将右侧组件置bottom为零(无需计算超出多少高度)*/
    //轮播图
    .el-carousel__item h3 {color: #475669;font-size: 1.4rem;opacity: 0.75;line-height: 1.5rem;margin: 0;}
    .el-carousel__item:nth-child(2n) {background-color: #99a9bf;}
    .el-carousel__item:nth-child(2n+1) {background-color: #d3dce6;}

    //定义主题颜色
    .theme-color{color: #D92E2E;}
    .bgColor{background-color: #D92E2E;}//红

    .mainbody_ip{padding: 0 12vw;margin-top: 1.5rem;z-index: 1000;
        .partRight{position: relative;
            .advert{display:inline-block;width:100%;height: 8rem;text-align: center;line-height: 8rem;color: rgba(0,0,0,.4);font-size: 16px;}
            .recommend{margin-top: 2rem;display: flex;height: 19rem;border: 1px solid pink;background-color: #ca0c16;margin-bottom: 2rem;}
        }
        .mainstay_index{padding: 0 0rem;text-align: left;height: 100%;background-color: rgba(204,208,211,.8);
            .advert{display:inline-block;width:100%;height: 8rem;background: #fafafa;text-align: center;line-height: 8rem;color: rgba(0,0,0,.4);font-size: 16px;}
            .recommend{margin-top: 2rem;display: flex;height: 19rem;border: 1px solid pink;margin-bottom: 2rem;
                .block{display:inline-block;width:98%;flex: 2;padding-right: 1rem;}
                .recbox{display: flex;flex: 1;flex-direction:column;height: 19rem;}
            }
            .mainstay_List{padding: 1.5rem 2rem;background-color: rgba(255,255,255,.6);margin-bottom: 1rem;transition: background-color .25s;
                &:hover{transition: background-color .25s;
                    img{transform: scale(1.3)!important;z-index: 9999;}
                }

            }
        }
        .el-main{overflow: hidden;}
        .mainstay_List{
            .mainstay_List_title{color: #00a67c;text-decoration: none;cursor: pointer}
            .mainstay_List_content{display: flex;height: 18rem;padding-top: 3rem;}
            .mainstay_List_img{display: flex;width: 26rem;
                .overFlow{width: 26rem;height: 26rem;overflow: hidden;}
                img{width: 26rem;transition: all 0.6s;}
                img:hover{transform: scale(1.1);}
            }
            .mainstay_List_article{
                max-height:15rem;display: -webkit-box;box-sizing: border-box;
                -webkit-box-orient: vertical;-webkit-line-clamp: 7;overflow: hidden;padding: 0 0 0 1.5rem;color: #777;padding-top: .5rem;
                fontFamily: 'Microsoft Yahei','Helvetica Neue',Helvetica,Arial,'sans-serif';cursor: pointer;}
            .mainstay_List_bottom{display: flex;justify-content: flex-end;
                .mainstay_List_author{padding-left: 2.5rem;color: #00a67c;cursor: pointer;}
                .mainstay_List_time{padding-left: 2.5rem;}
                .mainstay_List_comment{padding-left: 2.5rem;color: #00a67c;}
                .mainstay_List_point{padding-left: 2.5rem;color: #f78585;}

            }

        }
    }
</style>