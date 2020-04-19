<template>
    <div class="star">
        <div class="bannerTop">
            <span>我的粉丝</span>
            <span>共{{starData.length}}人</span>
        </div>
        <ul class="bannerMain" v-show="starData.length">
            <li v-for="(item,index) in starData" :key="index">
                    <router-link :to="{path:'/index/webpage',query:{userId:item.noticer}}" class="bannerMain_left">
                        <img :src="item.noticerImg">
                        <span>{{item.noticerName}}</span>
                    </router-link>
                <span class="bannerMain_right" @click="cancelStar(item)" v-show="item.crossFlag">取消关注</span>
                <span class="bannerMain_right following" @click="following(item)" v-show="!item.crossFlag">关注</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "star",
        data(){
            return{
                starData: [],//粉丝数据
                currentId: "",//当前用户
                followData: [],//自己关注的数据
            }
        },
        methods:{
            init(){//粉丝页初始化
                this.getStar();
                this.getFollow();
                let self = this;
                setTimeout(function () {
                    self.compareFlag(self.starData,self.followData);
                },100);
            },
            getStar(){//获取粉丝列表
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/personal/getFollow',{
                    params: {
                        ststus: 2,//1.获取自己关注的 2.获取自己的粉丝
                        currentId: self.currentId//账户id
                    }
                }).then(function(res) {
                    self.starData = res.data;
                });
            },
            getFollow(){//获取自己关注列表
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/personal/getFollow',{
                    params: {
                        ststus: 1,//1.获取自己关注的 2.获取自己的粉丝
                        currentId: self.currentId//账户id
                    }
                }).then(function(res) {
                    self.followData = res.data;
                });
            },
            compareFlag(starData,followData){//是否互为关注
                let self = this;
                let data = [];
                if((starData.length>0)&&(followData.length>0)){//查找自己的关注表与粉丝表中是否有相同的，如果有，那么就是互粉！
                    for(let i=0;i<starData.length;i++){
                        for (let j=0;j<followData.length;j++){
                            if(starData[i].noticer==followData[j].sufferId){
                                self.starData[i].crossFlag = true;
                            }else{
                                self.starData[i].crossFlag = false;
                            }
                            data = self.starData;
                        }
                    }
                }
                setTimeout(function () {
                    data.forEach(item=>{
                        self.$set(self.starData,'crossFlag',item.crossFlag);
                    })
                },100);
            },
            following(item){//添加到关注
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/user/saveStar',{
                    params: {
                        status: 1,//添加到关注
                        sufferId: item.noticer,//被关注者id
                        sufferName: item.noticerName,//被关注者昵称
                        sufferImg: item.noticerImg,//被关注者头像
                        noticer: item.sufferId,//关注者id
                        noticerName: item.sufferName,//关注者昵称
                        noticerImg: item.sufferImg,//关注头像者
                    }
                }).then(function(){
                    self.init();
                });
            },
            cancelStar(item){//取消关注
                let self = this;
                this.$confirm('确定要取消对该用户的关注?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$message({
                        type: 'success',
                        message: '取消关注成功!',
                    });
                    this.$axios.get('http://localhost/graduation_project/blog2/src/php/user/saveStar',{
                        params: {
                            status: 3,//1.关注标识 3.取消关注标识
                            sufferId: item.noticer,//被关注者id
                            sufferName: item.noticerName,//被关注者昵称
                            sufferImg: item.noticerImg,//被关注者头像
                            noticer: item.sufferId,//关注者id
                        }
                    }).then(function(){
                        self.getStar();
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消操作'
                    });
                });
            }
        },
        mounted() {
            this.currentId = localStorage.getItem('email');//当前登陆id
        }
    }
</script>

<style lang="less">
    .star{display: inline-block;width: 65vw;padding-right: 5rem;padding-left:2em;min-height: 68rem;
        .bannerTop{font-size: 2rem;color: #3d3d3d;line-height: 9rem;border-bottom: 1px solid #e0e0e0;font-weight: bold;display: flex;justify-content: space-between;
            span:nth-child(2){font-size: 1.4rem;color: #4d4d4d;font-weight: normal;margin-right: 1.5rem;}
        }
    }
    .bannerMain{list-style: none;line-height:7rem;
        li{display: flex;width: 100%;height: 100%;justify-content: space-between;align-items: center;border-bottom: 1px solid #e0e0e0;}
        .bannerMain_left{display: flex;align-items: center;color: #4d4d4d;
            img{display:inline-block;width: 5rem;height: 5rem;border-radius: 50%;margin-right: 1.5rem;cursor: pointer;}
            span:nth-child(2){}
        }
        .bannerMain_right{border: 1px solid #999;color:#999;font-size: 1.4rem;display: inline-block;
            text-align: center;line-height: normal;padding: .6rem 0;width:8rem;border-radius: .5rem;cursor: pointer;margin-right: 1rem;}
        .following{border: 1px solid #ca0c16;color: #ca0c16;}
    }
</style>