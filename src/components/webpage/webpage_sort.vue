<template>
    <div class="webapge_sort">
        <el-tabs type="border-card" v-model="activeCollectName" >
            <el-tab-pane :label="'Ta创建的专栏（'+sortCreateData.length+'）'" name="first">
                <div class="none_sort" v-show="!sortCreateData.length">
                    <img :src="none">
                    <div>空空如也</div>
                </div>
                <div class="createSort" v-for="(item,index) in sortCreateData" :key="index" @click="router_link(item.id)">
                    <span>{{item.name}}</span>
                    <span>
                        <div>
                            <span>文章数 32</span>
                        </div>
                        <div>关注</div>
                    </span>
                </div>
            </el-tab-pane>
            <el-tab-pane :label="'TA关注的专栏（'+sortFollowData.length+'）'" name="second">
                <div class="none_sort" v-show="!sortFollowData.length">
                    <img :src="none">
                    <div>空空如也</div>
                </div>
                <div class="createSort" v-for="(item,index) in sortFollowData" :key="index">
                    <span>{{item.name}}</span>
                    <span>
                        <div>
                            <span>文章数 32</span>
                        </div>
                        <div>关注</div>
                    </span>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import none from "assets/none.jpg";//1.引入图片地址
    export default {
        name: "webpage_sort",
        props:["userId"],
        data(){
            return{
                activeCollectName: "first",
                none:none,
                sortCreateData: [],//Ta创建的分类专栏
                sortFollowData: [],//Ta关注的分类专栏
                sortNoticedData: [],//当前登录账号的关注数据
            }
        },
        methods: {

        }
    };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only 测试已回退后再次提交的版本-->
<style scoped lang="less">
    .createSort{padding: 1rem 2rem;border-bottom: 1px solid #e4e7ed;&:last-child{border-bottom: 0px;}
        &>span:nth-child(1){font-size: 1.8rem;color: #4d4d4d;line-height: 2.7rem;cursor: pointer;}
        &>span:nth-child(2){display: flex;justify-content: space-between;font-size: 1.4rem;color: #999;align-items: center;
            &>div:nth-child(2),&>div:nth-child(3) {color: #9C2828;padding: .5rem 1.5rem;border: 1px solid  #ced2d9;border-radius: .5rem;cursor: pointer;}
            .follwed:hover{color: #fff;background-color: #9C2828;transition: all 0.3s;}
            .following{color: #ced2d9!important;background-color: #fff;transition: all 0.3s;border: 1px solid #ced2d9;}
        }
    }
</style>
