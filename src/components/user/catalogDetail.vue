<template>
    <div class="catalogDetail">
        <div class="article">
            <div class="bannera">
                <div class="title">Python专题文件操作</div>
                <div class="detailInfo">
                    <span class="autoName">知识追寻者</span>
                    <span class="time">最后发布于2020-01-23 21:36:04</span>
                    <span>阅读数 10</span>
                </div>
            </div>
            <div class="contentArticle">
                说明:此处是由数据库中取markDown编写的文章格式 来直接展示的，不做内部样式的调整!
                <div class="operate">
                    <span>点赞</span>
                    <span>收藏</span>
                    <span>转发</span>
                </div>
            </div>
        </div>

        <div class="commentt">
            <div style="display: flex;">
                <div><img :src="circleUrl"></div>
                <div class="textarea">
                    <textarea placeholder="想对作者说点什么?" maxlength="1000"></textarea>
                </div>
            </div>
            <div class="bottomTip">
                <span class="tip">还能输入1000个字符</span>
                <span>发表评论</span>
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
            }
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
            span{display:inline-block;width: 6rem;height: 3rem;background-color: #D2DDF6;text-align: center;line-height: 3rem;border-radius: .25rem;cursor: pointer;margin-right: 1.5rem;
                &:hover{background-color: #f9ecec;}
            }
        }
    }
    .commentt{margin: 1rem 0;background-color: #fff;padding: 2rem;
        div:nth-child(1){flex:1;position: relative;
            img{display: inline-block;width: 3rem;height: 3rem;border-radius: 50%;position: absolute;right: .5rem;}
        }
        .textarea{flex: 19;height: 8rem;}
        textarea{width: 100%;height: 100%;resize: none;padding: 1rem;box-sizing: border-box;border-radius: .25rem;
            &:hover{outline: none;}
        }
        .bottomTip{margin: .5rem 0;display: inline-block;display: flex;align-items: center;justify-content: flex-end;
            .tip{font-size: 1.2rem;color: #999;margin-right: 2rem;}
            span:nth-child(2){display: inline-block;width: 8rem;height: 3rem;text-align: center;line-height: 3rem;border-radius:.25rem;background-color: #CA0C16;color: #fff;cursor: pointer;}
        }
    }
</style>