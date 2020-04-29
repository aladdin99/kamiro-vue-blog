<template>
    <div class="related">
        <div class="success">
            <div class="banner" @click="goToManage"><i class="el-icon-arrow-left"></i><span style="cursor: pointer;">管理博文</span></div>
            <div class="pubcontent">
                <span class="title">{{title}}</span>
                <div class="content">
                    <mavon-editor
                            style="box-shadow: none;overflow: hidden;color: #999;display: inline;"
                            class="md"
                            :value="content"
                            :subfield = "false"
                            :defaultOpen = "'preview'"
                            :toolbarsFlag = "false"
                            :editable="false"
                            :scrollStyle="true"
                            :ishljs = "true"
                            previewBackground="#f5f6f7"
                    ></mavon-editor>
                </div>
            </div>
            <div class="poster">
                仗剑天涯，从你的摘要开始
            </div>
            <div class="next">
                <span>
                    <router-link :to="{path:'/index/user/details',query:{userId:userId,articleId:articleId}}" style="color: #3399ea;">
                        <i class="el-icon-circle-check"></i>发布成功并查看文章<i class="el-icon-arrow-right"></i>
                    </router-link>
                </span>
                <span><router-link to="/md/mavon" style="text-decoration: none;color: #3399ea;">再写一篇</router-link></span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                title: '',
                content: '',
                articleId: "",
                userId: ""
            }
        },
        methods:{
            goToManage(){//回到管理博文页面
                this.$router.push('/manage/managing');
            },
        },
        mounted() {
            this.title = this.$route.query.title?this.$route.query.title:'underfined';
            this.content = this.$route.query.content?this.$route.query.content:'underfined';
            this.articleId = this.$route.query.articleId?this.$route.query.articleId:'underfined';
            this.userId = this.$route.query.userId?this.$route.query.userId:'underfined';
            // console.log(this.title,this.content,this.articleId,this.userId);
        }
    }
</script>

<style lang="less">
    .related{display: flex;width: 100vw;height: 100vh;background-color: #78A5F1;justify-content: center;align-items: center;
        .success{display: inline-block; width: 60rem;background-color: #fff;padding: 2rem;text-align: left;
            .banner{text-align: left;color: #3399ea;font-size: 1.4rem;text-decoration: inherit;}
            .pubcontent{background-color: #f5f6f7;display: inline-block;width: 100%;height: 12rem;margin-top: 2rem;position: relative;box-sizing: border-box;padding: 3rem 0rem 0rem 0rem;text-align: left;
                .title{font-size: 18px;color: #474747;padding: 0 2.5rem;}
                .content{margin-top: 1rem;font-size: 1.4rem;color: #999999;max-height: 13rem;overflow: hidden;}
            }
            .poster{position: relative;text-align: right;background-color:#f5f6f7;padding: 2rem;transform: translateY(-.5rem)}
            .next{display: flex;justify-content: space-between;margin-top: 2rem;color: #3399ea;font-size: 1.4rem;padding: 3rem 0;
                span{cursor: pointer;}
            }
        }
    }
</style>