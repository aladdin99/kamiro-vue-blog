<template>
    <div class="follow">
        <div class="bannerTop">
            <span>我的关注</span>
            <span>共{{followData.length}}人</span>
        </div>
        <ul class="bannerMain" v-show="followData.length">
            <li v-for="(item,index) in followData" :key="index">
                <router-link :to="{path:'/index/webpage',query:{userId:item.sufferId}}" target="_blank" class="bannerMain_left">
                    <img :src="item.sufferImg">
                    <span>{{item.sufferName}}</span>
                </router-link>
                <span class="bannerMain_right" @click="cancelFollow(item)">取消关注</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "follow",
    data(){
        return{
            followData: [],//关注者数据
            currentId: "",//当前用户
        }
    },
    methods:{
        getFollow(){//获取关注列表
            let self = this;
            this.followData = [];
            this.$axios.get('http://localhost/graduation_project/blog2/src/php/personal/getFollow',{
                params: {
                    ststus: 1,//1.获取自己关注的 2.获取自己的粉丝
                    currentId: self.currentId//账户id
                }
            }).then(function(res) {
                self.followData = res.data;
                // console.log(self.followData);
            });
        },
        cancelFollow(item){//取消关注
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
                        sufferId: item.sufferId,//被关注者id
                        sufferName: item.sufferName,//被关注者昵称
                        sufferImg: item.sufferImg,//被关注者头像
                        noticer: item.noticer,//关注者id
                        noticerName: "",//关注者昵称
                        noticerImg: "",//关注头像者
                    }
                }).then(function(){
                    self.getFollow();
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
    .follow{display: inline-block;width: 65vw;padding-right: 5rem;padding-left:2em;min-height: 68rem;
        .bannerTop{font-size: 2rem;color: #3d3d3d;line-height: 9rem;border-bottom: 1px solid #e0e0e0;font-weight: bold;display: flex;justify-content: space-between;
            span:nth-child(2){font-size: 1.4rem;color: #4d4d4d;font-weight: normal;margin-right: 1.5rem;}
        }
    }
    .bannerMain{list-style: none;line-height:7rem;
        li{display: flex;width: 100%;height: 100%;justify-content: space-between;align-items: center;border-bottom: 1px solid #e0e0e0;}
        .bannerMain_left{display: flex;align-items: center;
            img{display:inline-block;width: 5rem;height: 5rem;border-radius: 50%;margin-right: 1.5rem;cursor: pointer;}
            span:nth-child(2){}
        }
        .bannerMain_right{border: 1px solid #999;color:#999;font-size: 1.4rem;display: inline-block;text-align: center;line-height: normal;padding: .6rem 0;width:8rem;border-radius: .5rem;cursor: pointer;margin-right: 1rem;}
    }
</style>