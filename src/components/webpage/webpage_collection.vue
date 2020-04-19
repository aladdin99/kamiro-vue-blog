<template>
    <div class="webapge_collection">
        <el-tabs type="border-card" v-model="activeCollectName" @tab-click="handleClick">
            <el-tab-pane :label="'Ta创建的收藏夹（'+clipCreateData.length+'）'" name="first">
                <div class="none_sort" v-show="!clipCreateData.length">
                    <img :src="none">
                    <div>空空如也</div>
                </div>
                <div class="createClip" v-for="(item,index) in clipCreateData" :key="index">
                    <span @click="tip">
<!--                        <router-link-->
<!--                            :to="{path:'/index/webpage_collect',-->
<!--                            query:{userId:userId,activeName:'second',activeCollectName:'first',collection_id:item.id}}"-->
<!--                            style="text-decoration: none;color:#4d4d4d;">{{item.title}}-->
<!--                        </router-link>-->
                        {{item.title}}
                    </span>
                    <span>
                        <div>
                            <span>{{item.amount}}条内容</span>
                            <el-divider direction="vertical"></el-divider>
                            <span>{{item.followers}}人关注</span>
                        </div>
                        <div v-show="!item.following" class="follwed" @click="followClip(item)">关注</div>
                        <div v-show="item.following" class="following" @click="cancelClip(item)">取消关注</div>
                    </span>
                </div>
            </el-tab-pane>
            <el-tab-pane :label="'Ta关注的收藏夹（'+clipFollowData.length+'）'" name="second">
                <div class="none_sort" v-show="!clipFollowData.length">
                    <img :src="none">
                    <div>空空如也</div>
                </div>
                <div class="createClip" v-for="(item,index) in clipFollowData" :key="index">
                    <span @click="tip">
<!--                        <router-link-->
<!--                                :to="{path:'/index/webpage_collect',-->
<!--                            query:{userId:userId,activeName:'second',activeCollectName:'second',collection_id:item.id}}"-->
<!--                                style="text-decoration: none;color:#4d4d4d;">{{item.sufferName}}-->
<!--                        </router-link>-->
                        {{item.sufferName}}
                    </span>
                    <span>
                        <div>
                            <span>{{item.sufferAmount}}条内容</span>
                            <el-divider direction="vertical"></el-divider>
                            <span v-show="item.sufferNum">{{item.sufferNum}}人关注</span>
                        </div>
                    </span>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import none from "assets/none.jpg";//1.引入图片地址
    export default {
        name: "webpage_collection",
        props:["userId"],
        data(){
            return{
                activeCollectName: "first",
                none:none,
                clipCreateData: [],//Ta创建的收藏夹
                clipFollowData: [],//Ta关注的收藏夹
                clipNoticedData: [],//当前登录账号的关注数据
            }
        },
        methods:{
            tip(){
                alert('计划开发排号中...');
            },
            init(){//初始化
                let _this = this;
                this.followedClip();
                setTimeout(function () {
                    _this.clipCreate();
                },100);
            },
            clipCreate(){//获取创建的收藏夹
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/clipCreate',{
                    params: {
                        id: self.userId//当前空间用户id(由父组件传来)
                    }
                }).then(function(res){
                    self.clipCreateData = res.data;
                    self.checkFollow(self.clipCreateData,self.clipNoticedData);//检验是否已关注
                });
            },
            checkFollow(clipCreateData,clipNoticedData){//检验是否已关注
                for(let i=0;i<clipCreateData.length;i++){
                    for (let j=0;j<clipNoticedData.length;j++){
                        clipCreateData[i].following = false;
                        if(clipCreateData[i].id == clipNoticedData[j].sufferClip){
                            clipCreateData[i].following = true;
                            break;
                        }
                    }
                }
            },
            handleClick(tab) {
                switch (parseInt(tab.index)) {
                    case 0:
                        this.init();
                        break;
                    case 1:
                        this.clipFollow();
                        break;
                    default:
                        break;
                }
            },
            clipFollow(){//Ta关注的收藏夹
                console.log("这是创建地文件夹");
                let self  = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/clipGet',{
                    params: {
                        noticer: self.userId,//当前空间的用户
                    }
                }).then(function(res){
                    self.clipFollowData = res.data;
                });
            },
            followClip(item){//新增关注名单
                let self = this;
                let clipData = {
                    sufferClip: item.id,//该收藏夹的唯一键
                    sufferName: item.title,//该收藏夹的昵称
                    sufferAmount: item.amount,//该收藏夹记录的文章
                    sufferId: item.bind,//该收藏夹绑定的用户
                    sufferNum: parseInt(item.followers)+1,//该收藏夹的关注量
                    noticer: localStorage.getItem('email')//当前登录用户
                }
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/webpage/clipSave',{
                    clipSaveData: clipData
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个
                }).then(function(){
                    self.init();
                });
            },
            cancelClip(item){//取消关注
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/clipdel',{
                    params: {
                        noticer: localStorage.getItem('email'),//当前登录用户
                        sufferId: item.bind,//当前空间的用户
                        sufferClip: item.id,//收藏夹id
                        followers: parseInt(item.followers)-1,//该收藏夹关注人数减一
                    }
                }).then(function(){
                    self.init();
                });
            },
            //获取当前登录者已关注的名单
            followedClip(){
                let self  = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/webpage/clipGet',{
                    params: {
                        noticer: localStorage.getItem('email'),//当前登录用户
                    }
                }).then(function(res){
                    self.clipNoticedData = res.data;
                });
            }
        }
    };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only 测试已回退后再次提交的版本-->
<style scoped lang="less">
    .createClip{padding: 1rem 2rem;border-bottom: 1px solid #e4e7ed;&:last-child{border-bottom: 0px;}
        &>span:nth-child(1){font-size: 1.8rem;color: #4d4d4d;line-height: 2.7rem;cursor: pointer;}
        &>span:nth-child(2){display: flex;justify-content: space-between;font-size: 1.4rem;color: #999;align-items: center;
            &>div:nth-child(2),&>div:nth-child(3) {color: #9C2828;padding: .5rem 1.5rem;border: 1px solid  #ced2d9;border-radius: .5rem;cursor: pointer;}
            .follwed:hover{color: #fff;background-color: #9C2828;transition: all 0.3s;}
            .following{color: #ced2d9!important;background-color: #fff;transition: all 0.3s;border: 1px solid #ced2d9;}
        }
    }
</style>
