<template>
    <div class="article_manage">
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="我的文章评论" name="first">
                <ul>
                    <li v-for="(item,index) in comment_data" :key="index">
                        <div class="comment">
                            <div class="comment_detail">
                                <router-link :to="{path:'/index/webpage',query:{userId:item.userId}}">
                                    <img :src="item.avarUrl" style="display: inline-block;width: 2.5rem;height: 2.5rem;border-radius: 50%;transform: translateY(.8rem);margin-right: 1.5rem;">
                                    <span>{{item.userName}}</span>
                                </router-link>
                                <span>{{item.time}}</span>
                                <span>回复了你的文章</span>
                                <router-link target="_blank" :to="{path:'/index/user/details', query:{userId:item.authorId,articleId:item.bindId}}" class="author_color">
                                    {{item.title}}
                                </router-link>
                            </div>

                            <div class="handle">
<!--                                <span @click="replay_now(true)">快速回复</span>-->
<!--                                <el-divider direction="vertical"></el-divider>-->
                                <span @click="common_del(item.id,1)">删除</span>
                            </div>
                        </div>
                        <div class="comment_content">
                            <i class="el-icon-position"></i>
                            {{item.comment}}
                        </div>
                        <div class="replay" v-show="repaly_flag">
                            <span style="display: inline-block;width: 3rem;height: 3rem;border-radius: 50%;background-color: #2C3E50;margin-left: 3.5rem;margin-right: 1rem;"></span>
                            <el-input v-model="replay" placeholder="发表你的评论" style="width: 70%;" size="small"></el-input>
                            <button :disabled="replay?false:true" :class="{'replay_button':replay?true:false}" @click="comment_replay">回复评论</button>
                        </div>
                        <!--                 <div style="margin-top:10rem;font-size: 1.8rem;letter-spacing: .5rem;color:#999;">当前没有任何评论</div>-->
                    </li>
                </ul>
            </el-tab-pane>
            <el-tab-pane label="待我审核的评论" name="second">
                <div class="quickHandle">
                    <span><el-checkbox v-model="checkAll" @change="checkedAll">全选</el-checkbox></span>
                    <span class="openOne" @click="public_now(1)">一键公开</span>
                </div>
                <ul>
                    <li v-for="(item,index) in comment_verify" :key="index">
                        <div class="comment">
                            <div class="comment_detail">
                                <el-checkbox v-model="item.single" style="margin: 0 1rem;" @change="checkedSingle(index,item.single)"></el-checkbox>
                                <router-link :to="{path:'/index/webpage',query:{userId:item.userId}}">
                                    <img :src="item.avarUrl" style="display: inline-block;width: 2.5rem;height: 2.5rem;border-radius: 50%;transform: translateY(.8rem);margin-right: 1.5rem;">
                                    <span>{{item.userName}}</span>
                                </router-link>
                                <span>{{item.time}}</span>
                                <span>回复了你的文章</span>
                                <router-link target="_blank" :to="{path:'/index/user/details', query:{userId:item.authorId,articleId:item.bindId}}" class="author_color">
                                    {{item.title}}
                                </router-link>
                            </div>

                            <div class="handle">
                                <span @click="public_now(item)">公开</span>
                                <el-divider direction="vertical"></el-divider>
                                <span @click="common_del(item.id,3)">删除</span>
                            </div>
                        </div>
                        <div class="comment_content">
                            <i class="el-icon-position"></i>
                            {{item.comment}}
                        </div>
                        <!--                 <div style="margin-top:10rem;font-size: 1.8rem;letter-spacing: .5rem;color:#999;">当前没有任何评论</div>-->
                    </li>
                </ul>
            </el-tab-pane>
            <el-tab-pane label="我发表的评论" name="third">
                <ul>
                    <li v-for="(item,index) in comment_data" :key="index">
                        <div class="comment">
                            <div class="comment_detail">
                                <router-link :to="{path:'/index/webpage',query:{userId:item.userId}}">
                                    <img :src="item.avarUrl" style="display: inline-block;width: 2.5rem;height: 2.5rem;border-radius: 50%;transform: translateY(.8rem);margin-right: 1.5rem;">
                                    <span>{{item.userName}}</span>
                                </router-link>
                                <span>{{item.time}}</span>
                                <span>回复了你的文章</span>
                                <router-link target="_blank" :to="{path:'/index/user/details', query:{userId:item.authorId,articleId:item.bindId}}" class="author_color">
                                    {{item.title}}
                                </router-link>
                            </div>

                            <div class="handle">
                                <span style="color: #CA0C16;" @click="common_del(item.id,2)">删除</span>
                            </div>
                        </div>
                        <div class="comment_content">
                            <i class="el-icon-position"></i>
                            {{item.comment}}
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
                checkAll: false,
                author: "",//当前登陆者
                comment_data: [],//所有文章的评论
                comment_data_mine: [],//我发表的文章评论
                comment_verify: [],//待审核评论
            }
        },
        methods: {
            checkedAll(){//全选
                this.comment_verify.forEach(item=>{
                   item.single = this.checkAll;
                });
            },
            checkedSingle(index,single){//index 当前选中位置，single是否选中(复选框单选)
                this.comment_verify[index].single = single;
                let  data = this.comment_verify;
                let count = 0;
                for (let i=0;i<data.length;i++){
                    if(data[i].single==true){
                        count++;
                    }
                }
                this.checkAll = (count==data.length)?true:false;
            },
            handleClick(tab){//页签跳转
                let self = this;
                switch (parseInt(tab.index)) {
                    case 0:
                        self.get_comment(1);
                        break;
                    case 1:
                        self.get_comment(3);
                        self.comment_verify.forEach(item=>{//用于复选框的选中状态
                           item.single = false;
                        });
                        break;
                    case 2:
                        this.get_comment(2);
                        break;
                    default:
                        console.log("nothing!");
                }
            },
            get_comment(status=1){//获取自己所有文章的评论
                let self = this;
                self.comment_data = [];
                self.comment_verify = [];
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/comment_manage',{
                    params: {
                        status: status,//1.获取自己所有文章的评论，2.获取我发布的评论 3.获取待我审核的评论
                        id: self.author
                    }
                }).then(function(res){
                    switch (status) {
                        case 1:
                            self.comment_data = res.data;
                            break;
                        case 2:
                            self.comment_data = res.data;
                            break;
                        case 3:
                            self.comment_verify = res.data;
                            break;
                    }
                });
            },
            replay_now(flag){//快速回复标识
                this.repaly_flag = flag;
            },
            public_now(item){//公开操作
                let self = this,
                    data = [];
                if (item==1){
                    this.comment_verify.forEach(item=>{
                        let obj = {};
                        if(item.single){
                            obj.id = item.id;
                            obj.userId = item.userId;
                            obj.bindId = item.bindId;
                            obj.authorId = item.authorId;
                            data.push(obj);
                        }
                    });
                }else{
                    data.push({id:item.id,userId:item.userId,bindId:item.bindId,authorId:item.authorId});
                }
                // if(!data.length) return;
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/manage/comment_public',{
                    openList: data //传入更新集合(传入数组对象要使用post请求，get请求则无法被正确解析)
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个
                }).then(function(){
                    self.checkAll = false;
                    self.get_comment(3);
                });
            },
            comment_replay(){
                this.repaly_flag = false;
            },
            common_del(id,flag) {
                let self = this;
                this.$confirm('评论一旦删除，不可恢复，确定要删除吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                    this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/comment_delete',{
                        params: {
                            id: id
                        }
                    }).then(function(){
                        self.get_comment(flag);
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            }
        },
        mounted() {
            this.author = localStorage.getItem('email');//当前登陆id
            this.get_comment();
        }
    }
</script>

<style lang="less">
    .article_manage{background-color: #fff ;padding: 1.5rem 2rem;box-sizing: border-box;height: 100%;min-height:68rem;width: 100%;
        ul{list-style: none;
            li{border-bottom: 1px solid #ddd;overflow: hidden;display: inline-block;height: 8rem;width: 100%;
                .comment{display: flex;justify-content: space-between;align-items: center;line-height: 3rem;
                    .comment_detail{font-size: 1.4rem;
                        span{}
                        img{cursor: pointer;}
                        span:nth-child(2){color: #4f4f4f;margin-right: 1rem;cursor: pointer;}
                        span:nth-child(3){color: #999;margin-right: 1rem;}
                        span:nth-child(4){color: #999;margin-right: 1rem;}
                        span:nth-child(5){color: #999;cursor: pointer;margin-right: 1rem;}
                    }
                    .handle{cursor: pointer;display: none;
                        span:nth-child(1){color: #349EDF;color: #ca0c16;transition: all 1.5s;}
                        span:nth-child(3){color: #CA0C16;color: #ca0c16;transition: all 1.5s;}
                    }
                }
                .comment_content{text-align: left;padding: 1.5rem 3.8rem 1rem 3.8rem;color: #4f4f4f;}
                &:hover{
                    .handle{display: block;transition: all 1.5s;}
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