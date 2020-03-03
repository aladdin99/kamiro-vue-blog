<template>
    <div class="catalogDetail">
        <div class="article">
            <div class="bannera">
                <div class="title">{{article_data.title}}</div>
                <div class="detailInfo">
                    <span class="autoName">{{article_data.author}}</span>
                    <span class="time">最后发布于{{article_data.time}}</span>
                    <span>阅读数 10</span>
                </div>
            </div>
            <div class="contentArticle">
                <div>
                    <mavon-editor
                            style="z-index: 1;"
                            class="md"
                            :value="rd_content"
                            :subfield = "false"
                            :defaultOpen = "'preview'"
                            :toolbarsFlag = "false"
                            :editable="false"
                            :scrollStyle="true"
                            :ishljs = "true"
                    ></mavon-editor>
                </div>
                <div class="operate">
                    <span>点赞</span>
                    <span>收藏</span>
<!--                    <span>转发</span>-->
                </div>
            </div>
        </div>

        <div class="commentt">
            <div style="display: flex;">
                <div><img :src="MyInfo.avatarUrl"></div>
                <div class="textarea">
                    <textarea placeholder="想对作者说点什么?" maxlength="100"></textarea>
                </div>
            </div>
            <div class="bottomTip">
                <span class="tip">还能输入100个字符</span>
                <span>发表评论</span>
            </div>
            <div class="commentt_box">
                <div>
                    <img :src="circleUrl" style="position: relative;">
                    <span>中二少年爱幻想</span>
                    <span>11小时前</span>
                    <span style="position: absolute;right: 1rem;cursor: pointer;">回复</span>
                </div>
                <div>请问怎么使用呢，我不知道怎么把你的这个用到我的vue项目·里。</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "userLeftBar",
        data(){
            return{
                nickName: "不脱发的程序员",
                circleUrl: "https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",
                articleId: "",//文章ID
                userId: '',//文章作者ID
                MyId: '',//当前账号的ID
                article_data: [],//文章内容
                rd_content: "",
                MyInfo: [],//当前登陆者信息
            }
        },
        methods:{
            get_collection_clip(){
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/article/article_get_item',{
                    params: {
                        uniqueId: self.articleId,
                        related: self.userId
                    }
                }).then(function(res){
                    self.article_data = res.data;
                    self.rd_content = self.article_data.content;
                    console.log(self.article_data);
                });
            },
            get_info_data(){
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/personal/getData',{
                    params: {
                        id: self.MyId
                    }
                }).then(function(res){
                    console.log(res.data);
                    self.MyInfo = res.data;
                });
            }
        },
        mounted(){
            this.articleId = this.$route.query.articleId;
            this.userId = this.$route.query.userId;
            this.MyId = localStorage.getItem('email');//当前登陆id
            this.get_collection_clip();
            this.get_info_data();
        }
    }
</script>

<style lang="less">
    .catalogDetail{
        height: 100%;
        /*background-color: #FDE0EC;*/
        /*padding: 4rem 2rem 0 2rem;*/
    }

    .article{padding: 4rem 2rem 0 2rem;background-color: #fff;
        .bannera{border-bottom: 1px solid #D7E2FC;
            .title{font-size: 2.8rem;word-wrap: break-word;color: #000;font-weight: bold;}
            .detailInfo{margin: 1.5rem 0;color: #858585;
                .autoName{margin-right: 2rem;color: #78A5F1;}
                .time{margin-right: 1rem;}
            }
        }
    }
    .contentArticle{padding: 3rem 0;
        .operate{margin: 3rem 0 0 0;
            span{display:inline-block;width: 6rem;height: 3rem;background-color: #D2DDF6;text-align: center;line-height: 3rem;border-radius: 2rem;cursor: pointer;margin-right: 1.5rem;
                &:hover{background-color: #f9ecec;}
            }
        }
    }
    .commentt{margin: 1rem 0;background-color: #fff;padding: 2rem;
        div:nth-child(1){flex:1;position: relative;
            img{display: inline-block;width: 3rem;height: 3rem;border-radius: 50%;position: absolute;right: .5rem;}
        }
        .textarea{flex: 19;height: 8rem;}
        textarea{width: 100%;height: 100%;resize: none;padding: 1rem;box-sizing: border-box;border-radius: .8rem;color: #d2d4d7;
            &:hover{outline: none;}
            &::-webkit-input-placeholder{color: #d7d4d4;}
        }
        .bottomTip{margin: .5rem 0;display: inline-block;display: flex;align-items: center;justify-content: flex-end;border-radius: .5rem;
            .tip{font-size: 1.2rem;color: #999;margin-right: 2rem;}
            span:nth-child(2){display: inline-block;width: 8rem;height: 3rem;text-align: center;line-height: 3rem;border-radius:.25rem;background-color: #CA0C16;color: #fff;cursor: pointer;}
        }
    }

    .commentt_box{padding: 1rem 0;
        &>div:nth-child(1){display: flex;align-items: center;
            img{display: inline-block; width: 3rem;height: 3rem;border-radius: 50%;z-index: 100;}
            span:nth-child(2){margin: 0 1rem;color: #2e2e2e;}
            span:nth-child(3){font-size: 1.2rem;color: #999;}
        }
        &>div:nth-child(2){padding: .5rem 0rem 1rem 4rem;border-bottom: 1px dashed #999;}
    }
</style>