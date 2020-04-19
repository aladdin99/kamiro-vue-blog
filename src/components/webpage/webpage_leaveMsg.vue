<template>
    <div class="webapge_leaveMsg">
        <div class="msg_banner">留言板</div>
        <div class="msg_edit">
            <div class="textarea">
                <textarea :placeholder="placeholder" maxlength="200" v-model="msg_conent" id="editor"
                          @blur.prevent="onChange">
                </textarea>
            </div>
            <div class="bottomTip">
                <span class="tip">还能输入{{200-msg_conent.length}}个字符</span>
                <span @click="msgPush">发表</span>
            </div>
        </div>
        <div class="msg_read">
            <div class="msg_read_num">留言({{msgData.length?msgData.length:0}})条</div>
            <div class="msg_read_contain" v-for="(item,index) in msgData" :key="index">
                <div class="msg_read_title">
                    <img :src="item.msgImg" @click="goTo(item.msger)">
                </div>
                <div class="msg_read_content">
                    <div>
                        <span @click="goTo(item.msger)">{{item.msgName}}__{{item.msger}}</span>
                        <span>第{{index+1}}楼</span>
                    </div>
                    <div>{{item.msgContent}}</div>
                    <div>{{item.msgTime}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import none from "assets/none.jpg";//1.引入图片地址
    export default {
        name: "webapge_leaveMsg",
        props:["userId"],
        data(){
            return{
                none:none,
                placeholder: "编辑您的寄语...",
                msg_conent: "",
                reply_data: [],
                currentObj: {},//当前登录用户信息
                msgData: [],//留言数据
            }
        },
        methods: {
            goTo(userId){//不能直接在同一个页面中再次跳蛛，所以必须新开一个页面来解决这类问题
                let routeUrl = this.$router.resolve({
                    path: "/index/webpage",
                    query: {userId:userId}
                });
                window.open(routeUrl.href, '_blank');
            },
            init(){//初始化
                console.log('留言模板');
                this.currentObj.msger = localStorage.getItem('email');//当前登陆id
                this.currentObj.msgImg = localStorage.getItem('imageUrl');//当前登陆头像
                this.currentObj.msgName = localStorage.getItem('nickName');//当前登陆昵称
                console.log(this.currentObj);
                this.msgPull();
            },
            onChange(){//失去光标事件
                this.placeholder = "编辑您的寄语...";
                if(!this.commit_conent){
                    this.replyId = "";
                }
            },
            msgPush(){//发表留言
                if(!this.msg_conent) {
                    alert("请填写好内容后再发布...");
                    return;
                }
                let self = this;
                let msgData = {
                    msger: self.currentObj.msger,//留言者
                    msgImg: self.currentObj.msgImg,//留言者头像
                    msgName: self.currentObj.msgName,//留言者昵称
                    msgContent: self.msg_conent,//留言内容
                    userId: self.userId,//留言对象
                };
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/webpage/msgLeave',{
                    msgData: msgData
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个
                }).then(function(){
                    self.msg_conent = "";
                    self.msgPull();
                });
            },
            msgPull(){//获取留言
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/msgLeave_pull',{
                    params: {
                        userId: self.userId,//留言对象
                    }
                }).then(function(res){
                    self.msgData = res.data;
                });
            }
        }
    };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only 测试已回退后再次提交的版本-->
<style scoped lang="less">
    .webapge_leaveMsg{color: #999;
        .msg_banner{color: #177cb0;font-size: 2rem;font-weight: bold;}
    }
    .msg_edit{margin: 0rem 0rem 1rem 0rem;background-color: #fff;padding: 0 2rem;
        div:nth-child(1){flex:1;position: relative;
            img{display: inline-block;width: 3rem;height: 3rem;border-radius: 50%;position: absolute;right: .5rem;}
        }
        .textarea{flex: 19;height: 8rem;}
        textarea{width: 100%;height: 100%;color: #2e2e2e;
            resize: none;padding: 1rem;box-sizing: border-box;border-radius: .8rem;outline:none;
            &:hover{outline: none;}
            &::-webkit-input-placeholder{color: #d7d4d4;}
        }
        .bottomTip{margin: 1.5rem 0;display: inline-block;display: flex;align-items: center;justify-content: flex-end;border-radius: .5rem;
            .tip{font-size: 1.2rem;color: #999;margin-right: 2rem;}
            span:nth-child(2){display: inline-block;width: 8rem;height: 3rem;text-align: center;line-height: 3rem;border-radius:.25rem;background-color: #CA0C16;color: #fff;cursor: pointer;}
        }
    }
    .msg_read{
        .msg_read_num{font-size: 1.6rem;border-bottom: 1px solid #e4e7ed;padding-bottom: .5rem;}
        .msg_read_contain{
            display: flex;justify-content: space-between;width: 100%;border-bottom: 1px solid #89c1fb;padding-bottom: 2rem;
            .msg_read_title{width: 12rem;display: flex;justify-content: center;
                img{display: inline-block;width: 6rem;height: 6rem;margin-top: 1.5rem;border-radius: .5rem;cursor: pointer;}
            }
            .msg_read_content{width: 100%;margin-top: 1.5rem;
                &>div:nth-child(1){padding-bottom: 1rem;cursor: pointer;display: flex;justify-content: space-between;}
                &>div:nth-child(2){min-height: 8rem;}
                &>div:nth-child(3){}
            }
        }
    }
</style>
