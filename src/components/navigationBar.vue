<template>
    <div class="nav">
        <div class="banner-left">
            <span style="margin-right: 1.5rem;">ALADDIN</span>
            <ul>
                <li v-for="(item,index) in bannerData" :key="index" @click="nextInfo(index)"><span :class="{'checked':(item.flag)}" :title="item.name">{{item.name}}</span></li>
            </ul>
            <el-select
                    size="small" v-model="value" filterable remote reserve-keyword  @keyup.enter="searchInfo"
                    placeholder="Python进阶之路" :remote-method="remoteMethod" :loading="loading"
            >
                <el-option
                        v-for="item in options" :key="item.value"
                        :label="item.label" :value="item.value">
                </el-option>
            </el-select>
        </div>
        <div class="banner-right">
            <span class="blogging">
                <i class="el-icon-edit" style="padding-right: 5px;"></i>
                <span><router-link to="/md/mavon" style="text-decoration: none;color: #2c3e50;">写博客</router-link></span>
            </span>
            <el-badge :value="12" class="item">
                <i class="el-icon-message-solid message"></i>
            </el-badge>
            <span class="logister" v-show="isLogin">登陆/注册</span>
            <span class="logister" v-show="!isLogin" style="z-index: 9999;">
                <router-link to="/personal/index"><img :src="circleUrl"></router-link>
                <ul class="lohisterInner">
                    <li><icon-svg icon-class="icon-guanzhu" class="iconClass" style="padding-left: 1rem;"/><span><router-link :to="{path:'/personal/index',query:{activeCode:'3'}}" style="text-decoration: none;color: #fff;">我的关注</router-link></span></li>
                    <li><icon-svg icon-class="icon-icon-test" class="iconClass"/><span><router-link :to="{path:'/personal/index',query:{activeCode:'1'}}" style="text-decoration: none;color: #fff;">我的收藏</router-link></span></li>
                    <li><icon-svg icon-class="icon-gerenzhongxin" class="iconClass"/><span><router-link to="/personal/index">个人中心</router-link></span></li>
                    <li><icon-svg icon-class="icon-Account-Settings" class="iconClass"/><span><router-link to="/settings/account_settings">账号设置</router-link></span></li>
                    <li><i class="el-icon-document-copy iconClass"></i><span ><router-link :to="{path:'/index/user',query:{id:author}}">我的博客</router-link></span></li>
                    <li><icon-svg icon-class="icon-guanli" class="iconClass"/><span><router-link to="/manage/managing" style="text-decoration: none;color: #fff;">管理博客</router-link></span></li>
                    <li><icon-svg icon-class="icon-bangzhu" class="iconClass"/><span>帮助</span></li>
                    <li><icon-svg icon-class="icon-icon_tuichu-" class="iconClass"/><span><router-link to="/" style="text-decoration: none;color: #fff;">退出</router-link></span></li>
                </ul>
            </span>
<!--            <el-popover-->
<!--                    placement="top-end"-->
<!--                    width="100"-->
<!--                    :visible-arrow="false"-->
<!--                    trigger="hover"-->
<!--            >-->
<!--                <div style="background-color: #D92E2E;">-->
<!--                    <ul style="list-style: none;">-->
<!--                        <li><icon-svg icon-class="icon-guanzhu"/>我的关注</li>-->
<!--                        <li><icon-svg icon-class="icon-icon-test"/>我的收藏</li>-->
<!--                        <li><icon-svg icon-class="icon-gerenzhongxin"/>个人中心</li>-->
<!--                        <li><icon-svg icon-class="icon-Account-Settings"/>账号设置</li>-->
<!--                        <li><icon-svg icon-class="icon-wode"/>我的博客</li>-->
<!--                        <li><icon-svg icon-class="icon-guanli"/>管理博客</li>-->
<!--                        <li><icon-svg icon-class="icon-bangzhu"/>帮助</li>-->
<!--                        <li><icon-svg icon-class="icon-icon_tuichu-"/>退出</li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <span class="logister" slot="reference" v-show="!isLogin"><router-link to="/personal/index"><img :src="circleUrl"></router-link></span>-->
<!--            </el-popover>-->
        </div>
    </div>
</template>

<script>
    export default {
        name: "navigationBar",
        data() {
            return {
                author: '',//当前用户id
                bannerData: [{name:"首页",flag:true},{name:"个人主页",flag:false},{name:"软件工具",flag:false},{name:"生活",flag:false}],
                options: [],
                value: [],
                list: [],
                loading: false,
                states: ["Alabama", "Alaska", "Arizona",
                    "Arkansas", "California", "Colorado",
                    "Connecticut", "Delaware", "Florida",
                    "Georgia", "Hawaii", "Idaho", "Illinois",
                    "Indiana", "Iowa", "Kansas", "Kentucky",
                    "Louisiana", "Maine", "Maryland",
                    "Massachusetts", "Michigan", "Minnesota",
                    "Mississippi", "Missouri", "Montana",
                    "Nebraska", "Nevada", "New Hampshire",
                    "New Jersey", "New Mexico", "New York",
                    "North Carolina", "North Dakota", "Ohio",
                    "Oklahoma", "Oregon", "Pennsylvania",
                    "Rhode Island", "South Carolina",
                    "South Dakota", "Tennessee", "Texas",
                    "Utah", "Vermont", "Virginia",
                    "Washington", "West Virginia", "Wisconsin",
                    "Wyoming"],
                circleUrl:"",
                isLogin: false
            }
        },
        methods: {
            searchInfo(){
              alert(11);
            },
            remoteMethod(query) {//快捷搜索
                if (query !== '') {
                    this.loading = true;
                    setTimeout(() => {
                        this.loading = false;
                        this.options = this.list.filter(item => {
                            return item.label.toLowerCase()
                                .indexOf(query.toLowerCase()) > -1;
                        });
                    }, 200);
                } else {
                    this.options = [];
                }
            },
            nextInfo(index){
                this.bannerData.forEach(item=>{
                    item.flag = false;
                });
                switch (index) {
                    case 0:
                        this.$router.push('/index');//跳转到首页
                        break;
                    case 1:
                        this.$router.push({path:'/index/webpage',query:{userId:this.author}});//跳转到首页
                        break;
                    case 2:
                        alert("延期开发...");
                        break;
                    case 3:
                        alert("延期开发...");
                        break;
                    default:
                        alert("延期开发...");
                        break;
                }
                this.bannerData[index].flag=true;
            },
            getavata(){
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/personal/getData',{
                    params: {
                        id: self.author//账户id
                    }
                }).then(function(res){
                    let personal = res.data;
                    self.circleUrl = personal.avatarUrl;
                });
            }
        },
        mounted() {
            this.list = this.states.map(item => {
                return { value: `value:${item}`, label: `${item}` };
            });
            this.author = localStorage.getItem('email');//当前登陆id
            this.getavata();
        },
    }
</script>

<style lang="less">
    *{margin: 0;padding: 0;}
    a{
        text-decoration: none;
        color: #fff;
    }
    .nav{
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.05);height: 4.5rem;padding: 0 12vw;background-color: #fff;
        display: flex;justify-content: space-between;align-items: center;cursor: pointer;}
    .banner-left{
        ul {list-style-type:none;display:inline-block;
            li{display: inline-block;height: 100%;padding: 0 1.5rem;line-height: 4.5rem;transition: background-color .5s;color: #666C7A;box-sizing: border-box;}
            li:hover{background-color: #F0F0F0;transition: background-color .5s;}
            .checked{border-bottom: 2px solid #D92E2E;color: #222429;display: inline-block;}
        }
        .el-select{margin-left: 1.5rem;}
    }
    .banner-right{display: flex;justify-content: space-between;align-items: center;
        .blogging{color: #D92E2E;display: inline-block;height:100%;padding: 0 1.5rem;line-height: 4.5rem;box-sizing: border-box;
            &:hover{background-color: #fff1f1;transition: background-color .5s;}
        }
        .item{padding: 0 2rem;
            .el-badge__content.is-fixed{right: 2.5rem;}
            .el-badge__content{
            font-size: .8rem;height: 1.2rem;line-height: 1.5rem;padding: 0px .4rem;
        }}
        .message{color: #C3C3C3;font-size: 1.6rem;}
        .logister{display: inline-block;height: 4.5rem;padding: 0 1.5rem;line-height: 4.5rem;transition: background-color .5s;position: relative;
            img{width: 3rem;height:3rem;border-radius: 50%;margin-top: 50%;transform: translateY(-25%);}
            .lohisterInner{padding:.5rem 0;background-color:#D92E2E;color:#fff;list-style: none;width: 12rem;height: 35rem;position: absolute;right:0rem;top:4.5rem;text-align:left;
                border-bottom-left-radius: .5rem;border-bottom-right-radius: .5rem; display: none;
                li{padding: 0 1rem;}
                span{display: inline-block;margin-left: 1rem;}
                .iconClass{padding-left: 1rem;}
            }
        }
        .logister:hover{background-color: #F0F0F0;transition: background-color .5s;
            .lohisterInner{z-index: 1000;visibility: block; display: block;
                li:hover{background-color: #D92E2E;color: #fff;
                    &:hover{background-color: #9C2828;}
                }
            }
        }
    }
</style>