<template>
    <div class="webpage">
        <div :class="{'UbannerMenu':bannerScroll}">
            <navigationBar></navigationBar>
        </div>
        <el-container class="mainbody">
            <!--Middle content preview section-->
            <el-main class="mainstay">
                <div style="display: inline-block;width: 100%;height: 100%;">
                    <div class="info_banner">
                        <div class="part1">
                            <img :src="base_data.avatarUrl" style="width: 10rem;height: 10rem;border-radius: 50%;">
                        </div>
                        <div class="part2">
                            <div>
                                <div>{{base_data.nickName}}</div>
                                <div>
                                    <span>关注</span>
                                    <span>私信</span>
                                </div>
                            </div>
                            <div style="width: 70%;margin: 1rem 0;">{{base_data.introduction}}</div>
                        </div>
                    </div>
                    <div class="blogInfo">
                        <el-tabs v-model="activeName" @tab-click="handleClick">
                            <el-tab-pane :label="'博客 '+article_data.length" name="first">
                                <div class="blog_article" v-for="(item,index) in article_data" :key="index">
                                    <div class="article_title">
                                        <router-link target="_blank" :to="{path:'/index/user/details',query:{userId:userId,articleId:item.uniqueId}}" class="article_title">
                                            {{item.title}}
                                        </router-link>
                                    </div>
                                    <div class="article_content">{{item.content}}</div>
                                    <div class="article_record">
                                        <span>49次阅读</span>
                                        <span>{{item.time}}</span>
                                    </div>
                                </div>
                                <div style="display: flex;justify-content: center;align-items: center;margin-top: 2rem;" v-show="article_data.length-1">
                                    <span style="padding: .8rem 2rem;color: #ca0c16;border: 1px solid #ca0c16;border-radius: .5rem;">查看更多</span>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="收藏 32" name="second">
                                <div class="blog_collection_back">
                                    <div @click="webpage_back">
                                        <i class="el-icon-arrow-left"></i>返回TA创建的收藏夹列表
                                    </div>
                                    <ul>
                                        <li>{{collection_data.title}}</li>
                                        <li v-show="collection_data.describe">{{collection_data.describe}}</li>
                                        <li>
                                            <span>共有15条内容</span>
                                            <el-divider direction="vertical"></el-divider>
                                            <span>3人关注</span>
                                            <el-divider direction="vertical"></el-divider>
                                            <span>2011-02-07</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="blog_collection_item">
                                    <div>2011年亚太区IT业十大趋势：除了云计算还是云计算 - CSDN 云计算频道</div>
                                    <div>
                                        <span>匿名作者</span>
                                        <el-divider direction="vertical"></el-divider>
                                        <span>2011-02-07</span>
                                    </div>
                                </div>
                                <div class="blog_collection_item">
                                    <div>2011年亚太区IT业十大趋势：除了云计算还是云计算 - CSDN 云计算频道</div>
                                    <div>
                                        <span>匿名作者</span>
                                        <el-divider direction="vertical"></el-divider>
                                        <span>2011-02-07</span>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="专栏 13" name="third">
                                <el-tabs type="border-card">
                                    <el-tab-pane :label="'Ta创建的专栏（'+sort_colum_data.length+'）'">
                                        <div class="blog_collection" v-for="(item,index) in sort_colum_data" :key="index" @click="router_link(item.id)">
                                            <span>{{item.name}}</span>
                                            <span>
                                                <div>
                                                    <span>文章数 32</span>
                                                </div>
                                                <div>关注</div>
                                            </span>
                                        </div>
                                    </el-tab-pane>
                                    <el-tab-pane :label="'TA关注的专栏（'+sort_colum_data.length+'）'">
                                        <div class="blog_collection" v-for="(item,index) in sort_colum_data" :key="index">
                                            <span>{{item.name}}</span>
                                            <span>
                                                <div>
                                                    <span>文章数 32</span>
                                                </div>
                                                <div>关注</div>
                                            </span>
                                        </div>
                                    </el-tab-pane>
                                </el-tabs>
                            </el-tab-pane>
                            <el-tab-pane label="留言 13" name="fourth">留言</el-tab-pane>
                        </el-tabs>
                    </div>
                </div>
            </el-main>
            <!--Right user information bar-->
            <el-aside width="30rem" style="position: relative;">
                <div class="right_record">
                    <div class="medal">
                        <div>
                            <span>MDSN身份</span>
                        </div>
                        <div>
                            <div class="medal_item" v-for="(item,index) in gained" :key="index" v-show="index<3">
                                <span><img :src="item.img" style="display: inline-block;width: 100%;height: 100%;"></span>
                                <span>{{item.name}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="focus" style="background-color: #fff;">
                            <span>
                                <div>1K+</div>
                                <div>他的粉丝</div>
                            </span>
                        <span>
                                <div>3</div>
                                <div>他的关注</div>
                            </span>
                    </div>
                    <div class="medal">
                        <div>
                            <span>勋章</span>
                            <span>我的勋章</span>
                        </div>
                        <div>
                            <div class="medal_item" v-for="(item,index) in gained" :key="index">
                                <span><img :src="item.img" style="display: inline-block;width: 100%;height: 100%;"></span>
                                <span>{{item.name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </el-aside>
        </el-container>
    </div>
</template>

<script>
    import navigationBar from "components/navigationBar.vue";
    export default {
        name: "webpage",
        components: {
            navigationBar,
        },
        data(){
            return{
                bannerScroll:false,
                gained: [{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/qiandao-1.png',
                    name: '签到新秀',
                    content: '累计签到获取，不积跬步，无以至千里，继续坚持！'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/chizhiyiheng.png',
                    name: '持之以恒',
                    content: '授予每个自然月内发布4篇或4篇以上原创或翻译IT博文的用户。不积跬步无以至千里，不积小流无以成江海，程序人生的精彩需要坚持不懈地积累！'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/qixiebiaobing-1.png',
                    name: '勤写标兵Lv1',
                    content: '授予每个自然周发布1篇到3篇原创IT博文的用户。本勋章将于次周周三上午根据用户上周的博文发布情况由系统自动颁发。'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/qixiebiaobing-2.png',
                    name: '勤写标兵Lv2',
                    content: '授予每个自然周发布4篇到6篇原创IT博文的用户。本勋章将于次周周三上午根据用户上周的博文发布情况由系统自动颁发。'
                }],
                activeName: 'first',
                article_data: "",//获取部分文章
                base_data: "",//主页基本信息
                collection_data: "",//收藏夹
                sort_colum_data: "",//专栏
                activeCollectName: 'first',//默认选中的收藏夹为第一个
                collection_id: '',//某个收藏夹iD
            }
        },
        methods: {
            handleClick(tab, event) {
                console.log(tab, event);
            },
            get_articles(){//获取博文信息
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/get_article',{
                    params: {
                        id: self.userId//账户id
                    }
                }).then(function(res){
                    let article = res.data;
                    article.forEach(item=>{
                        item.content = self.getSimpleText(item.content);//文章预览页面.只展示纯文本!
                    });
                    self.article_data = article;
                    console.log(self.article_data);
                });
            },
            getSimpleText(html){//富文本中提取纯文本(删掉所有的样式和图片,只保留纯文本和标点符号)
                var re1 = new RegExp("<.+?>","g");//匹配html标签的正则表达式，"g"是搜索匹配多个符合的内容
                var msg = html.replace(re1,'');//执行替换成空字符
                var result = msg.replace(/[\r\n]/g,"");//取消文本中的换行
                return result;
            },
            get_base_info(){//获取用户基本信息
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/get_base_info',{
                    params: {
                        id: self.userId//账户id
                    }
                }).then(function(res){
                    self.base_data = res.data;
                });
            },
            get_collection(){//获取指定的某个收藏夹
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/get_collection',{
                    params: {
                        status: 1,
                        id: self.userId,//账户id
                        collection_id: self.collection_id//某个收藏夹id
                    }
                }).then(function(res){
                    self.collection_data = res.data[0];
                });
            },
            get_sort_colum(){//获取分类专栏
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/get_sort_colum',{
                    params: {
                        id: self.userId//账户id
                    }
                }).then(function(res){
                    self.sort_colum_data = res.data;
                });
            },
            webpage_back(){
                this.$router.push({ path:'/index/webpage',
                        query: { userId: this.userId,activeName:this.activeName,activeCollectName:this.activeCollectName}
                    });
            },
            router_link(id){//分类栏路由跳转
                // this.$router.push({ path:'/index/user/sorts', query: { userId: this.userId }});
                this.$router.push({ path:'/index/user/sorts', query: { userId: this.userId, sortId: id}});
            }
        },
        mounted() {
            this.userId = this.$route.query.userId;
            this.activeName = this.$route.query.activeName;
            this.activeCollectName = this.$route.query.activeCollectName;
            this.collection_id = this.$route.query.collection_id;
            this.get_articles();
            this.get_base_info();
            this.get_collection();
            this.get_sort_colum();
        }
    }
</script>

<style lang="less">
    .webpage{
        height: 100%;
        min-height: 68rem;
        background-color: #fff;
    }
    .UbannerMenu {position: fixed;top: 0;width: 100%;z-index: 101;}
    .mainbody{padding: 0 12vw;margin-top: 1.5rem;
        .mainstay{text-align: left;height: 100%;color: #42b983;display: flex;}
    }

    .info_banner{display: flex;background-color: #2e2f30!important;width: 100%;height: 100%;padding: 1rem 0;
        .part1{
            display: flex;
        }
        .part2{flex: 6;background-color: #fff;color: #000;margin-left: 1rem;display: flex;flex-direction: column;padding: 1rem;
            &>div{flex: 1;justify-content: space-between;display: flex;
                &>div:nth-child(1){font-size: 2.6rem;color: #4d4d4d;}
                &>div:nth-child(2) {
                    span{display: inline-block; padding: .5rem 1.5rem;border: 1px solid #e8eaed;color: #ca0c16;border-radius: .5rem;}
                    span:nth-child(1){margin: 0 1rem 0 0;}
                    span:nth-child(1){margin: 0 2rem 0 0;}
                }
            }
            &>div:nth-child(2){flex: 1;color: #999;font-size: 1.4rem;}
        }
        .blogInfo{background-color: #fff;margin-top: 1rem;}
    }

    .blog_article{padding: 1rem 0;
        .article_title{font-size: 2rem;color: #5a5a5a;font-weight: 700;line-height: 3rem;}
        .article_content{font-size: 1.4rem;color: #858585;line-height: 2.4rem;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;overflow: hidden;}
        .article_record{display: flex;justify-content: space-between;font-size: 1.2rem;color: #999;margin-top: .8rem;}
    }

    .blog_collection{padding: 1rem 0;border-bottom: 1px solid red;
        &>span:nth-child(1){font-size: 2rem;color: #4d4d4d;line-height: 2.7rem;cursor: pointer;}
        &>span:nth-child(2){display: flex;justify-content: space-between;font-size: 1.4rem;color: #999;align-items: center;
            &>div:nth-child(2) {color: #9C2828;padding: .5rem 1.5rem;border: 1px solid  #ced2d9;border-radius: .5rem;cursor: pointer;}
        }
    }

    .blog_collection_item{border-bottom: 1px solid #f5f6f7;padding: 1.5rem 0 2rem 0;
        &>div:nth-child(1){color: #4d4d4d;font-size: 1.6rem;cursor: pointer;}
        &>div:nth-child(2){margin-top: 1rem;color: #999;font-size: 1.4rem;
            .el-divider{margin: 0 3rem;}
        }
    }

    .blog_collection_back{
        &>div:nth-child(1){font-size: 1.6rem;color: #333;cursor: pointer;border-bottom: 1px solid #f5f6f7;padding-bottom: 1rem;}
        ul{li{list-style: none;padding: .5rem;
            &:nth-child(1){color: #4d4d4d;font-size: 1.6rem;}
            &:nth-child(2){font-size: 1.4rem; color: #858585;}
            &:nth-child(3){font-size: 1.4rem; color: #999;border-bottom: 1px dashed #f5f6f7;}
        }}
    }

    .right_record{flex: 3;display: inline-block;width: 30rem;box-sizing: border-box;
        .focus{display: flex;justify-content: center;align-items: center;text-align: center;background-color: #177cb0;
            margin: 0 1rem;box-sizing: border-box;padding: 2rem 0;margin: 0rem 0rem 1rem 1rem;width: 28rem;
            span{flex:1;}
            span:nth-child(2){border-left: 1px solid red;}
        }
        .medal{background-color: #fff;display: flex;justify-content: center;align-items: center;flex-direction: column;
            text-align: center;margin: 1rem 1rem 0 1rem;box-sizing: border-box;padding: 1rem .5rem;margin: 0rem 0rem 1rem 1rem;width: 28rem;
            &>div:nth-child(1){display: flex;justify-content: space-between;width: 100%;padding: 0 .5rem;box-sizing: border-box;}
            &>div:nth-child(2){display: flex;width: 100%;flex-wrap:wrap;}
            .medal_item{width: 32%;height: 10rem;display: flex;flex-direction: column;justify-content: center;align-items: center;box-sizing: border-box;flex-wrap:wrap;
                span:nth-child(1){width: 5rem;height: 5rem;display: inline-block;}
                span:nth-child(2){margin-top: 1rem;}
            }
        }
    }
</style>