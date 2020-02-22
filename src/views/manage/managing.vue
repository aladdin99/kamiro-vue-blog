<template>
    <div class="managing">
        <navigationBar></navigationBar>
        <div class="mainmanage">
            <el-container>
                <el-aside width="200px" style="background-color: #FDE0EC;">
                    <div class="leftManageBar" ref="leftHeight">
                        <router-link to="/md/mavon" style="text-decoration: none;" class="manage_edit_link">
                            <div class="manage_edit">
                                <i class="el-icon-edit" style="padding-right: 5px;"></i>Markdown编辑器
                            </div>
                        </router-link>
                        <router-link :to="{path:'/index/user',query:{id:userId}}"  class="manage_blog_link">
                            <div class="manage_blog">
                                我的博客
                            </div>
                        </router-link>
                        <el-collapse v-model="activeNames" @change="getHeight">
                            <el-collapse-item title="博客管理" name="1" style="text-align: center;">
                                <ul>
                                    <li v-for="(item,index) in manage" :key="index" @click="checked(index,item.label)" :class="{'checked':blog_value==item.label}">{{item.value}}</li>
                                </ul>
                            </el-collapse-item>
                            <el-collapse-item title="设置管理" name="2">
                                <ul>
                                    <li>博客设置</li>
                                    <li>博客模块管理</li>
                                </ul>
                            </el-collapse-item>
                        </el-collapse>
                    </div>
                </el-aside>
                <el-main style="padding: 0;min-height:30rem;background-color: #177cb0">
                    <div v-show="blog_value==0"><article_manage></article_manage></div>
                    <div v-show="blog_value==1"><comment_manage></comment_manage></div>
<!--                    //点击左侧'分类专栏'才获取页面数据(父组件传值)-->
                    <div v-show="blog_value==2"><sort_manage :sortFlag="sortFlag"></sort_manage></div>
                </el-main>
            </el-container>
        </div>
    </div>
</template>

<script>
import navigationBar from "components/navigationBar.vue";
import article_manage from "components/manage/article_manage.vue";
import comment_manage from "components/manage/comment_manage.vue";
import sort_manage from "components/manage/sort_manage.vue";
export default {
    name: "managing",
    components: {
        navigationBar,article_manage,comment_manage,sort_manage
    },
    data(){
        return{
            activeNames: ['1'],
            manage: [
                {label:0,value:'文章管理'},
                {label:1,value:'评论管理'},
                {label:2,value:'分类专栏'},
            ],
            blog_value: 0,
            listData: true,
            listValue: 0,
            sortFlag: 0,//点击左侧'分类专栏'才获取页面数据(父组件传值)
            userId: ''
        }
    },
    methods:{
        getHeight(){
            // let height= this.$refs.leftHeight.offsetHeight;  //100
            // alert(height);
            this.listData = !this.listData;
        },
        checked(index,label){
            this.blog_value = index;
            if(label==2){//点击左侧'分类专栏'才获取页面数据(父组件传值)
                this.sortFlag = 1;
            }
        }
    },
    mounted() {
        this.userId = localStorage.getItem('email');//当前登陆id
    },
    watch:{
        listData:function(newVal){
            let self = this;
            this.$nextTick(function(){
                // let i = 0;
                if(self.listValue<1){
                    this.getHeight();
                    self.listValue++;
                }
                //some code
                console.log(this.$refs.leftHeight.offsetHeight,newVal)//ul最新的高度
            })
        }
    }
}
</script>

<style lang="less">
.managing{display: inline-block;width: 100%; background-color: #f5f6f7;
    .mainmanage{padding: 0 12vw;background-color:#065279;margin-top: 1.5rem;min-height: 92vh;}
}
.leftManageBar{display: inline-block;width: 20rem;background-color: #99a9bf;cursor: pointer;border-right: .2rem solid #f5f6f7;box-sizing: border-box;
    .manage_edit{background-color: #fff;color: #CA0C16;padding: 1.5rem;font-size: 1.6rem;border-bottom: 1px solid #e9e9e9;
        .manage_edit_link{text-decoration: none;color: #CA0C16;}
        &:hover{background-color:#CA0C16; color: #fff;}
    }
    .manage_blog_link{text-decoration: none;color: #2c3e50;}
    .manage_blog{background-color: #fff;padding: 1.2rem 1.2rem 1.2rem 2.5rem;font-size: 1.6rem;letter-spacing: .2rem;border-bottom: 1px solid #e9e9e9;text-align: left;
        &:hover{background-color:#CA0C16; color: #fff;}
    }
    ul{background-color: #fff;list-style: none;
        li{padding: 1rem;font-size: 1.4rem;}
    }
    .checked{color: #fff;background-color: #CA0C16;}
    .el-collapse-item__header{font-size: 1.4rem;padding-left: 2.5rem;letter-spacing: .2rem;}
}
</style>