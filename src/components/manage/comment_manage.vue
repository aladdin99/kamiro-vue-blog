<template>
    <div class="article_manage">
        <el-tabs v-model="activeName">
            <el-tab-pane label="我的文章评论" name="first">
                <ul>
                    <li v-for="item in 10" :key="item">
                        <div class="comment">
                            <div class="comment_detail">
                                <span style="display: inline-block;width: 2.5rem;height: 2.5rem;border-radius: 50%;background-color: #42b983;transform: translateY(.8rem);margin-right:1.5rem;"></span>
                                <span>Aladdin99</span>
                                <span>9分钟前</span>
                                <span>回复了你的文章</span>
                                <span class="author_color">Aladdin的前端之路</span>
                            </div>

                            <div class="handle">
                                <span @click="replay_now(true)">快速回复</span>
                                <el-divider direction="vertical"></el-divider>
                                <span @click="open">删除</span>
                            </div>
                        </div>
                        <div class="comment_content">
                            <i class="el-icon-position"></i>
                            感谢《囧妈》这部电影，和电影到底怎么样是两码事
                        </div>
                        <div class="replay" v-show="repaly_flag">
                            <span style="display: inline-block;width: 3rem;height: 3rem;border-radius: 50%;background-color: #42b983;margin-left: 3.5rem;margin-right: 1rem;"></span>
                            <el-input v-model="replay" placeholder="发表你的评论" style="width: 70%;" size="small"></el-input>
                            <button :disabled="replay?false:true" :class="{'replay_button':replay?true:false}" @click="comment_replay">回复评论</button>
                        </div>
                        <!--                 <div style="margin-top:10rem;font-size: 1.8rem;letter-spacing: .5rem;color:#999;">当前没有任何评论</div>-->
                    </li>
                </ul>
            </el-tab-pane>
            <el-tab-pane label="待我审核的评论" name="second">
                <div class="quickHandle">
                    <span><el-checkbox v-model="checkAll">全选</el-checkbox></span>
                    <span class="openOne">一键公开</span>
                </div>
                <ul>
                    <li v-for="item in 10" :key="item">
                        <div class="comment">
                            <div class="comment_detail">
                                <el-checkbox v-model="checkAll" style="margin: 0 1rem;"></el-checkbox>
                                <span style="display: inline-block;width: 2.5rem;height: 2.5rem;border-radius: 50%;background-color: #42b983;transform: translateY(.8rem);margin-left: 0;"></span>
                                <span>Aladdin99</span>
                                <span>9分钟前</span>
                                <span>回复了你的文章</span>
                                <span class="author_color">Aladdin的前端之路</span>
                            </div>

                            <div class="handle">
                                <span @click="public_now(true)">公开</span>
                                <el-divider direction="vertical"></el-divider>
                                <span @click="open">删除</span>
                            </div>
                        </div>
                        <div class="comment_content">
                            <i class="el-icon-position"></i>
                            感谢《囧妈》这部电影，和电影到底怎么样是两码事
                        </div>
                        <!--                 <div style="margin-top:10rem;font-size: 1.8rem;letter-spacing: .5rem;color:#999;">当前没有任何评论</div>-->
                    </li>
                </ul>
            </el-tab-pane>
            <el-tab-pane label="我发表的评论" name="third">
                <ul>
                    <li v-for="item in 10" :key="item">
                        <div class="comment">
                            <div class="comment_detail">
                                <span style="display: inline-block;width: 2.5rem;height: 2.5rem;border-radius: 50%;background-color: #42b983;transform: translateY(.8rem);margin-right: 1.5rem;"></span>
                                <span>Aladdin99</span>
                                <span>9分钟前</span>
                                <span>回复了你的文章</span>
                                <span class="author_color">Aladdin的前端之路</span>
                            </div>

                            <div class="handle">
                                <span style="color: #CA0C16;" @click="open">删除</span>
                            </div>
                        </div>
                        <div class="comment_content">
                            <i class="el-icon-position"></i>
                            牛仔配碎花/民族花纹还出现在好几套其他穿搭里，都搭配得让人眼前一亮
                        </div>
                        <!--                 <div style="margin-top:10rem;font-size: 1.8rem;letter-spacing: .5rem;color:#999;">当前没有任何评论</div>-->
                    </li>
                </ul>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    export default {
        name: "article_manage",
        data() {
            return {
                activeName: 'first',
                replay: '',
                repaly_flag: false,
                checkAll: false
            }
        },
        methods: {
            replay_now(flag){
                this.repaly_flag = flag;
            },
            public_now(){
              alert('公开！');
            },
            comment_replay(){
                this.repaly_flag = false;
            },
            open() {
                this.$confirm('评论一旦删除，不可恢复，确定要删除吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            }
        }
    }
</script>

<style lang="less">
    .article_manage{background-color: #fff ;padding: 1.5rem 2rem;box-sizing: border-box;height: 100%;width: 100%;
        ul{list-style: none;
            li{border-bottom: 1px solid #ddd;
                .comment{display: flex;justify-content: space-between;align-items: center;line-height: 3rem;
                    .comment_detail{font-size: 1.4rem;
                        span{}
                        span:nth-child(2){color: #4f4f4f;margin-right: 1rem;}
                        span:nth-child(3){color: #999;margin-right: 1rem;}
                        span:nth-child(4){color: #999;margin-right: 1rem;}
                        span:nth-child(5){color: #999;cursor: pointer;margin-right: 1rem;}
                    }
                    .handle{cursor: pointer;display: none;
                        span:nth-child(1){color: #349EDF;}
                        span:nth-child(3){color: #CA0C16;}
                    }
                }
                .comment_content{text-align: left;padding: 1.5rem 3.8rem 1rem 3.8rem;color: #4f4f4f;}
                &:hover{
                    .handle{display: block;}
                }
                .replay{display: flex;justify-content: left;padding: 1rem 0;
                    button{padding: .35rem 1.5rem .3rem 1.5rem;text-align:center;border: 1px solid #D6D6D6;cursor: pointer;margin-left: 2rem;color:#D6D6D6;
                        background-color: #fff;border-radius: .5rem;-webkit-tap-highlight-color: rgba(0,0,0,0);outline: none;

                    }
                    .replay_button{border: 1px solid #CA0C16;color: #CA0C16;
                        &:hover{ background-color: #CA0C16;color: #fff;transition: background-color .3s,color .3s;}
                    }
                }
            }
        }
        .author_color{color: #349EDF!important;}
        .quickHandle{display: flex;justify-content: space-between;background-color: #f3f5f7;padding: 1rem;cursor: pointer;
            .openOne{color: #3399ea;}
        }
    }
</style>