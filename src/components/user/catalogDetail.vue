<template>
    <div class="catalogDetail_detail">
        <div class="article_detail">
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
                            style="z-index: 1000;"
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
                <div class="operate_one">
                    <span @click="point" :class="{'pinted':pointData.flag==1}">点赞 <i v-show="pointData.total">{{pointData.total}}</i></span>
                    <span @click="collected">收藏</span>
<!--                    <span>转发</span>-->
                </div>
            </div>
        </div>

        <!--收藏-->
        <el-dialog :visible.sync="dialogCollection" width="25%" top="15%" class="dialogCollection">
            <div slot="title" class="title">添加收藏</div>
            <div slot="footer" class="footer-one" v-show="!radioFlag"  @click="changeFlag(true)">+ 新建收藏夹</div>
            <div slot="footer" class="footer-two" v-show="radioFlag">
                <span @click="changeFlag(false)">返回</span>
                <span @click="dialogCollection = false">取消</span>
                <span @click="buildCollection">确定</span>
            </div>
            <!--收藏夹(切换)-->
            <div v-show="!radioFlag" :class="{'noneFind':!collection_clip.length}">
                <ul v-show="collection_clip.length" class="ul-one">
                    <li v-for="(item,index) in collection_clip" :key="index" class="dialog-item">
                        <div class="dialog-left">
                            <div>{{item.title}}</div>
                            <div>{{item.amount}}条内容</div>
                        </div>
                        <div class="dialog-right">
                            <span @click="collect(item,index)" :class="{'collected':item.status}">收藏</span>
                        </div>
                    </li>
                </ul>
                <img :src="none" v-show="!collection_clip.length">
                <div v-show="!collection_clip.length" class="preBuild">请先建立收藏夹哦~</div>
            </div>

            <!--新建收藏夹(切换)-->
            <ul class="ul-two" v-show="radioFlag">
                <li>
                    <span>标题</span>
                    <div><el-input
                            placeholder="请输入收藏夹名称"
                            v-model="input_title"
                            clearable>
                    </el-input></div>
                </li>
                <li>
                    <span>描述(选填)</span>
                    <div><el-input
                            type="textarea"
                            :rows="4"
                            placeholder="请输入收藏夹简介"
                            v-model="textarea_content">
                    </el-input></div>
                </li>
                <li>
                    <span>私密</span>
                    <div class="power">
                        <div><el-radio v-model="radio" label="1">公开 所有人可见</el-radio></div>
                        <div> <el-radio v-model="radio" label="2">私密 只有你可以查看这个收藏夹</el-radio></div>
                    </div>
                </li>
            </ul>
        </el-dialog>

        <!--评论-->
        <div class="commentt">
            <div style="display: flex;">
                <div>
                    <router-link target="_blank" :to="{path:'/index/webpage',query:{userId:MyInfo.id}}" >
                        <img :src="MyInfo.avatarUrl">
                    </router-link>
                </div>
                <div class="textarea">
                    <textarea :placeholder="placeholder" maxlength="200" v-model="commit_conent" id="editor"
                              @blur.prevent="onChange"></textarea>
                </div>
            </div>
            <div class="bottomTip">
                <span class="tip">还能输入{{200-commit_conent.length}}个字符</span>
                <span @click="commit">发表评论</span>
            </div>
            <div class="commentt_box" v-for="(item,index) in comment_data" :key="index">
                <div>
                    <router-link target="_blank" :to="{path:'/index/webpage',query:{userId:item.userId}}" >
                        <img :src="item.avarUrl" style="position: relative;">
                        <span class="username">{{item.userName}}</span>
                    </router-link>
                    <span class="time">{{item.time}}</span>
                    <span style="position: absolute;right: 1rem;cursor: pointer;" @click="reply(item)">回复</span>
                </div>
                <div>{{item.comment}}</div>
                <div v-show="item.replyFlag=='1'">
                    <div class="reply" v-for="(info,index1) in reply_data" :key="index1" v-show="info.bindId==item.id">
                        <div class="replays">
                            <router-link target="_blank" :to="{path:'/index/webpage',query:{userId:info.userId}}" >
                                <img :src="info.avarUrl" style="position: relative;">
                                <span class="username">{{item.userName}}</span>
                            </router-link>
                            <span style="cursor: pointer;">回复</span>
                            <span style="margin: 0 1rem;">{{info.userName}}</span>
                            <span class="time">{{info.time}}</span>
                        </div>
                        <div class="innerComment">
                            {{info.comment}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import none from "assets/none.jpg";//1.引入图片地址
    export default {
        name: "userLeftBar",
        data(){
            return{
                none: none,
                nickName: "不脱发的程序员",
                circleUrl: "https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",
                articleId: "",//文章ID
                userId: '',//文章作者ID
                MyId: '',//当前账号的ID
                article_data: [],//文章内容
                rd_content: "",
                MyInfo: [],//当前登陆者信息
                commit_conent: '',//评论内容
                comment_data: [],//评论数据
                reply_data: [],//回复数据
                placeholder: "想对作者说点什么?",
                replyId: "",//评论回复id
                pointData: {flag: 2, total:0},//点赞
                dialogCollection: false,
                collection_clip: [],//收藏夹
                collection_detail: [],//当前用户对该篇文章的收藏情况
                input_title: "",//新建收藏夹_标题
                textarea_content: "",//新建收藏夹_简介
                radio: '1',//1.公开 2.私密
                radioFlag: false
            }
        },
        methods:{
            buildCollection(){//新建收藏夹
                let self = this;
                if(!this.input_title){
                    alert('收藏夹标题不能为空！');
                    return;
                }
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/personal/collection/collection',{
                    status: 1,//新建收藏夹
                    bind: self.MyId,//传入用户id
                    title: self.input_title,//收藏夹标题
                    describe: self.textarea_content,//收藏夹的描述
                    power: self.radio,//收藏夹权限 1.公开 2.私密
                    id: ""//收藏夹的id号（新建收藏夹时时没有,更新编辑收藏夹时才有）
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个
                }).then(function(res){
                    console.log(res);
                    self.radioFlag = false;
                    self.input_title = "";
                    self.textarea_content= "";
                    self.get_collection();
                }).catch(function(res){
                    console.log(res);
                });
            },
            collected(){//点击弹窗收藏
                this.dialogCollection = true;
                this.radioFlag = false;
            },
            changeFlag(flag){//切换收藏夹与新增收藏夹
                this.radioFlag = flag;
            },
            collect(item){//收藏
                let self = this;
                // console.log('----');
                // console.log(this.collection_clip);
                // console.log('----');
                //更新收藏状态字段视图
                let status = item.status;
                this.$delete(item,'status');//先删除
                this.$set(item, 'status', !status);//后设置
                let statusFlag = status?2:1;// 1.收藏 2.取消收藏

                //更新收藏数量字段视图
                let amount = item.amount;
                if(statusFlag==1){
                    amount++;
                }else if(statusFlag==2){
                    amount--;
                }
                this.$delete(item,'amount');//先删除
                this.$set(item, 'amount', amount);//后设置

                console.log(statusFlag,amount,self.userId,self.articleId);
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/user/saveCollection',{
                    statusFlag: statusFlag,// 1.收藏 2.取消收藏
                    pathId: item.id,//收录者收藏夹
                    bindId: item.bind,//收录者
                    amount: amount,//已收录数量
                    authorId: self.userId,//作者id
                    articleId: self.articleId,//文章id
                    title: self.article_data.title,//文章标题
                    author: self.article_data.author,//文章作者
                    pubdate: self.article_data.time,//文章发布时间
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个解决跨域
                });
            },
            getCollection(){//获取该用户在该篇文章的收藏情况
              let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/user/getCollection',{
                    params: {
                        bindId: self.MyId,//当前用户id
                        articleId: self.articleId,//文章id
                    }
                }).then(function(res){
                    self.collection_detail = res.data;
                });
            },
            get_collection(){//获取收藏夹信息（通过比对收藏夹表与收录表赋予收藏夹新字段status标识 用于判断该文章是否被收录了）
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/user/getCollectionClip',{
                    params: {
                        bind: self.MyId,//当前登陆者id
                    }
                }).then(function(res){
                    self.collection_clip = res.data;
                    console.log(self.collection_detail);
                    self.collection_clip.forEach(item=>{//遍历所有的收藏夹
                        let status = false;
                        item.status = status;
                        if(self.collection_detail){
                            for(let i=0;i<self.collection_detail.length;i++){//遍历该用户对当前文章的收录情况
                                console.log(self.collection_detail[i].pathId,item.id);
                                if(self.collection_detail[i].pathId==item.id){
                                    item.status = true;
                                    break;
                                }
                            }
                        }
                    });
                    console.log(self.collection_clip);
                });
            },
            point(){//点赞事件
                // console.log(this.pointData.total);
                if(this.pointData.flag!=2){
                    this.pointData.flag = (this.pointData.flag==1)?0:1;
                    if(this.pointData.flag==1){
                        this.pointData.total = this.pointData.total+1;
                    }else{
                        this.pointData.total = this.pointData.total-1;
                    }
                }
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/article/point_get',{
                    params: {
                        status: self.pointData.flag,//2.查询点赞 1.点赞 3.取消点赞
                        articleId: self.articleId,
                        userId: self.MyId,
                        authorId: self.userId,
                    }
                }).then(function(res){
                    let data = res.data;
                    if(self.pointData.flag==2){
                        self.pointData.total = data.total;
                        self.pointData.flag = data.flag;
                    }
                });
            },
            reply(person){//回复事件
                document.getElementById("editor").focus();   //获取textarea的光标(聚焦)
                this.placeholder = "回复：" + person.userName;
                this.replyId = person.id;
            },
            onChange(){//失去光标事件
                this.placeholder = "想对作者说点什么?";
                if(!this.commit_conent){
                    this.replyId = "";
                }
            },
            get_article(){//获取文章内容
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/article/article_get_item',{
                    params: {
                        uniqueId: self.articleId,
                        related: self.userId
                    }
                }).then(function(res){
                    self.article_data = res.data;
                    self.rd_content = self.article_data.content;
                    self.getCommit();
                    self.getReply();//刷新回复数据
                });
            },
            get_info_data(){//获取当前登录者资料
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/personal/getData',{
                    params: {
                        id: self.MyId
                    }
                }).then(function(res){
                    self.MyInfo = res.data;
                });
            },
            commit(){//提交评论
                let self = this;
                console.log(self.article_data.commentLimit);
                if(!self.commit_conent){
                    alert("请填写评论内容！");
                    return;
                }
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/webpage/push_comment',{
                    status: self.replyId?1:0, //判断评论或回复 1.回复 0.评论
                    userId: self.MyInfo.id,//评论者id
                    avarUrl: self.MyInfo.avatarUrl,//评论者头像
                    userName: self.MyInfo.nickName,//评论者昵称
                    comment: self.commit_conent,//评论
                    authorId: self.userId,//文章作者id
                    title: self.article_data.title,//文章标题
                    bindId: self.replyId?self.replyId:self.article_data.uniqueId,//评论时绑定的文章id
                    articleId: self.article_data.uniqueId,//回复时绑定的文章id
                    showFlag: (self.article_data.commentLimit==1)?1:0,//1.回复需要审核 0.回复不需要审核
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个解决跨域
                }).then(function () {
                    self.commit_conent = "";//情况输入框评论
                    self.getCommit();//刷新评论数据
                    self.getReply();//刷新回复数据
                });
            },
            getCommit(){//获取文章评论
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/get_comment',{
                    params: {
                        bindId: self.article_data.uniqueId?self.article_data.uniqueId:"",//评论绑定的文章ID
                    }
                }).then(function(res){
                    self.comment_data = res.data;
                    self.comment_data = self.comment_data.reverse();
                });
            },
            getReply(){//获取文章回复
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/get_reply',{
                    params: {
                        bindId: self.article_data.uniqueId,//评论绑定的文章ID
                    }
                }).then(function(res){
                    self.reply_data = res.data;
                });
            }
        },
        mounted(){
            let self = this;
            this.articleId = this.$route.query.articleId;
            this.userId = this.$route.query.userId;
            this.MyId = localStorage.getItem('email');//当前登陆id
            setTimeout(function () {
                self.get_info_data();
            },100);

            this.get_article();
            this.point();
            this.getCollection();
            this.get_collection();
        }
    }
</script>

<style lang="less">
    .catalogDetail_detail{
        height: 100%;
        width: 100%;
        min-height: 100vh;
        /*background-color: #FDE0EC;*/
        /*padding: 4rem 2rem 0 2rem;*/

        .dialogCollection{padding: 0;margin: 0;
            .title{border-bottom: 1px solid #2e2f30;padding: 0 0 .5rem 0;}
            .footer-one{border-top: 1px solid #2e2f30;padding: .5rem 0 0 0;color: #9C2828;cursor: pointer;}
            .footer-two{border-top: 1px solid #2e2f30;padding: .5rem 0 0 0;color: #9C2828;cursor: pointer;
                span{padding-left: 2rem;color: #4d4d4d;}
                span:nth-child(3){color: #9C2828;}
            }
            .ul-one{padding: 0;margin: 0;max-height:24rem;overflow-y:auto;
                .dialog-item{display: flex;width: 100;padding:.8rem 0;list-style: none;align-items: center;
                    .dialog-left{display:flex;flex: 1;flex-direction: column;
                        div:nth-child(1){flex: 1;color: #4d4d4d;cursor: default!important;}
                        div:nth-child(2){flex: 1;color: #999;font-style: normal;font-weight: 400;}
                    }
                    .dialog-right{flex: 1;justify-content: flex-end;display: flex;padding-right: 1rem;
                        span{cursor: pointer;padding: .5rem 1.2rem;border: 1px solid #9C2828;color: #9C2828;border-radius: .5rem;}
                    }
                }
                .collected{color: #4d4d4d!important;border-color: #4d4d4d!important;}
            }
            .ul-two{padding: 0;margin: 0;
                li{display: flex;justify-content: space-between;padding-bottom: 1.5rem;
                    &>span{display: flex;flex: 1;}
                    &>div{display: flex;flex: 4;}
                    .power{display: flex;flex-direction: column;
                        div:nth-child(1){padding-bottom: 1rem;}
                    }
                    textarea{resize: none;}
                }
            }
            .noneFind{display: flex;align-items: center;justify-content: center;flex-direction: column;
                img{width: 100%;flex: 8;}
                .preBuild{flex: 2;margin-top: 1rem;font-weight: bold;}
            }
        }

        .article_detail{padding: 4rem 2rem 0 2rem;background-color: #fff;
            .bannera{border-bottom: 1px solid #D7E2FC;
                .title{font-size: 2.8rem;word-wrap: break-word;color: #000;font-weight: bold;}
                .detailInfo{margin: 1.5rem 0;color: #858585;
                    .autoName{margin-right: 2rem;color: #78A5F1;}
                    .time{margin-right: 1rem;}
                }
            }
            .contentArticle{padding: 3rem 0;
                .operate_one{margin: 3rem 0 0 0;
                    span{display:inline-block;width: 6rem;height: 3rem;background-color: #D2DDF6;text-align: center;line-height: 3rem;border-radius: 2rem;cursor: pointer;margin-right: 1.5rem;
                        &:hover{background-color: #f9ecec;}
                    }
                }
            }
        }

        .commentt{margin: 1rem 0;background-color: #fff;padding: 2rem;
            div:nth-child(1){flex:1;position: relative;
                img{display: inline-block;width: 3rem;height: 3rem;border-radius: 50%;position: absolute;right: .5rem;}
            }
            .textarea{flex: 19;height: 8rem;}
            textarea{width: 100%;height: 100%;resize: none;padding: 1rem;box-sizing: border-box;border-radius: .8rem;outline:none;
                &:hover{outline: none;}
                &::-webkit-input-placeholder{color: #d7d4d4;}
            }
            .bottomTip{margin: .5rem 0;display: inline-block;display: flex;align-items: center;justify-content: flex-end;border-radius: .5rem;
                .tip{font-size: 1.2rem;color: #999;margin-right: 2rem;}
                span:nth-child(2){display: inline-block;width: 8rem;height: 3rem;text-align: center;line-height: 3rem;border-radius:.25rem;background-color: #CA0C16;color: #fff;cursor: pointer;}
            }
        }

        .commentt_box{padding: 1rem 0;border-bottom: 1px dashed #999;
            img{display: inline-block; width: 3rem;height: 3rem;border-radius: 50%;z-index: 100;cursor: pointer;}
            &>div:nth-child(1){display: flex;align-items: center;
                a{display: flex;align-items: center;}
                .username{margin: 0 1rem;color: #2e2e2e;cursor: pointer;}
                .time{font-size: 1.2rem;color: #999;}
            }
            &>div:nth-child(2){padding: .5rem 0rem 1rem 4rem;}
            &>div:nth-child(3){display: inline-block;width: 96%;border-left: .4rem solid #c5c5c5;margin: 0 0 0 4rem;padding: .5rem 0;
                .reply{margin-bottom: 1.5rem;
                    .replays{display: flex;align-items:center;padding-left: .5rem;
                        &:nth-child(1){margin-left: .5rem;}
                        a{display: flex;align-items: center;}
                        .username{margin: 0 1rem;color: #2e2e2e;cursor: pointer;}
                        .time{font-size: 1.2rem;color: #999;margin: 0 1rem;}
                    }
                    .innerComment{padding-left: 5rem;padding-top: .5rem;}
                }
            }
        }
        .pinted{background-color: #9C2828!important;color: #fff!important;}
    }

</style>