<!--一篇博文内容-->
<template>
    <div class="user_detail">
        <!-- Top navigation bar-->
        <div class="special_bar" style="z-index: 100;">
            <navigationBar></navigationBar>
        </div>
        <el-container class="mainbody">
            <!--Left user information bar-->
<!--            <el-aside width="30rem" style="position: relative;" :class="{'leftScroll':leftScroll}">-->
<!--                <userLeftBar-->
<!--                        :userId="userId"-->
<!--                        :originalNum="original.length"-->
<!--                        :lastest="lastest"-->
<!--                        :leftScroll="leftScroll"-->
<!--                        :collection_clip="collection_clip"-->
<!--                ></userLeftBar>-->
<!--                <span ref="searchBar"></span>-->
<!--            </el-aside>-->
            <!--Middle content preview section-->
            <el-main class="mainstay">
                <catalogDetail></catalogDetail>
            </el-main>
        </el-container>
    </div>
</template>

<script>
    import navigationBar from "components/navigationBar.vue";
    // import userLeftBar from "components/user/userLeftBar.vue";
    import catalogDetail from "components/user/catalogDetail.vue";
    export default {
        name: "user",
        components: {
            navigationBar,catalogDetail
        },
        data(){
            return{
                bannerScroll:false,
                leftScroll:false,
                userId: '',
                alldata: '',//所有文章
                original: '',//原创文章
                lastest: '',//最新文章
                collection_clip: "",//分类专栏
            }
        },
        methods:{
            getScrollPosition(){//监听banner栏坐标
                let top = document.documentElement.scrollTop || document.body.scrollTop;
                // let left = document.documentElement.scrollLeft || document.body.scrollLeft;
                // if(top){//获取右边栏底部标签'searchBar'距顶部的距离
                //     var searchBar = this.$refs.searchBar.getBoundingClientRect().top;
                // }
                // let currentHeigh = window.innerHeight;//当前内容高度  1235///680
                this.bannerScroll = (top>45)?true:false;
                // this.leftScroll = (searchBar<currentHeigh)?true:false;
                // console.log(this.bannerScroll);
                return {top}
            },
            getArticle(){//获取文章信息
                let self = this;
                self.original = [];
                self.lastest = [];
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/article/article_get',{
                    params: {
                        id: self.userId//账户id
                    }
                }).then(function(res){
                    let article = res.data;
                    article.forEach(item=>{
                        item.sortFlag = self.character(item.time);//插入sortFlag,根据这个排序更新时间
                        if(item.type=='原创'){
                            self.original.push(item);//原创文章
                        }
                    });
                    self.alldata = article;//全部文章
                    let lastest_data = article.sort(self.compare('sortFlag',false));
                    lastest_data.forEach((item,index)=>{
                        if(index<5){
                            self.lastest.push(item);//最新文章
                        }
                    });
                    // console.log(self.lastest);
                });
            },
            compare(property,flag){//根据数组中的某个元素的值进行排序;property传入的数组 flag：true正序 false倒序
                return function(a,b){
                    var value1 = a[property];
                    var value2 = b[property];
                    return flag?(value1 - value2):(value2 - value1);
                }
            },
            character(time_into){//时间格式字符串转成数字
                let time_out = 0;
                time_out = time_into.replace(/-/g,'');
                time_out = time_out.replace(/:/g,'');
                time_out = time_out.replace(/ /g,'');
                time_out = parseInt(time_out);
                return time_out;
            },
            // get_collection_clip(){
            //     let self = this;
            //     this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/sort_manage_get',{
            //         params: {
            //             bind: self.userId,//账户id
            //         }
            //     }).then(function(res){
            //         self.collection_clip = res.data;
            //         self.alldata.forEach(item=>{
            //             if(item.category[0]){
            //                 let ins = item.category[0].id;
            //                 self.collection_clip.forEach(info=>{
            //                     if(!info.essay){//如果不存在该字段 那么就添加
            //                         info.essay = [];
            //                     }
            //                     if(ins == info.id) {
            //                         info.essay.push(item);
            //                     }
            //                 });
            //             }
            //         });
            //     });
            // }
        },
        mounted() {
            //监听banner栏坐标
            window.addEventListener('scroll',this.getScrollPosition,false);
            this.userId = this.$route.query.userId;
            this.getArticle();
            // this.get_collection_clip();
        },
        destroyed() {
            //监听banner栏坐标(摧毁)
            window.removeEventListener('scroll',this.getScrollPosition,false)
        }
    }
</script>

<style lang="less">
    .user_detail{
        height: 100%;
        min-height: 100vh;
        background: url("../../../../assets/theme.jpg");
        background-repeat:no-repeat;//背景图不重复
        background-attachment:fixed;//固定背景图位置
        /*background-color: rgba(0,0,0,.3);*/
    }
    .special_bar{background-color: rgba(85,84,85, 0.5);color: rgba(85,84,85, 0.5);}
    .user_detail{
        .UbannerMenu {position: fixed;top: 0!important;width: 100%;}
        .UleftMenu_detail {position: fixed;z-index: 100;width:30rem;top: calc(0% + 6rem);}//上滑超出直接将左侧组件置bottom为零(无需计算超出多少高度)

        .mainbody{padding: 0 12vw;margin-top: 1.5rem;
            .mainstay{padding: 0 2rem;text-align: left;height: 100%;}
        }
    }
</style>