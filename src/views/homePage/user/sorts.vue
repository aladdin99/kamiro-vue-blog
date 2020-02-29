<template>
    <div class="sorts">
        <div :class="{'UbannerMenu':bannerScroll}">
            <navigationBar></navigationBar>
        </div>
        <div class="banner_title">
            <div>
                <span>绿色羽毛</span>
                <span>面朝大海，春暖花开！</span>
            </div>
            <div></div>
        </div>
        <el-container class="mainbody">
            <el-aside width="30rem" style="position: relative;">
                <div>
                    <userLeftBar
                            :class="{'UleftMenu':leftScroll}"
                            :userId="userId"
                            :originalNum="original.length"
                            :lastest="lastest"
                            :collection_clip="collection_clip"
                            @get_collection_clip_detail="get_collection_clip_detail"></userLeftBar>
                    <span ref="searchBar"></span>
                </div>
            </el-aside>
            <!--Middle content preview section-->
            <el-main class="mainstay">
<!--                <catalogPreview :userId="userId" :alldata="alldata" :original="original" @changeData="changeData"></catalogPreview>-->
                <sortPreview :collection_clip_detail="collection_clip_detail" :userId="userId"></sortPreview>
            </el-main>
        </el-container>
    </div>
</template>

<script>
    import navigationBar from "components/navigationBar.vue";
    import userLeftBar from "components/user/userLeftBar.vue";
    import sortPreview from "components/user/sortPreview";
    export default {
        name: "user",
        components: {
            navigationBar, userLeftBar,sortPreview
        },
        data(){
            return{
                bannerScroll:false,
                leftScroll:false,
                userId: '',//当前页面的用户ID
                sortId: '',//分类栏ID
                alldata: '',//所有文章
                original: '',//原创文章
                lastest: '',//最新文章
                collection_clip: "",//分类专栏
                collection_clip_detail: ''//当前选中的分类专栏
            }
        },
        methods: {
            getScrollPosition() {//监听banner栏坐标
                let top = document.documentElement.scrollTop || document.body.scrollTop;
                let left = document.documentElement.scrollLeft || document.body.scrollLeft;
                if (top) {//获取右边栏底部标签'searchBar'距顶部的距离
                    var searchBar = this.$refs.searchBar.getBoundingClientRect().top;
                }
                let currentHeigh = window.innerHeight;//当前内容高度  1235///680
                this.bannerScroll = (top > 45) ? true : false;
                this.leftScroll = (searchBar < currentHeigh) ? true : false;
                return {top, left}
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
                        item.content = self.getSimpleText(item.content);//文章预览页面.只展示纯文本!
                        if(item.type=='原创'){
                            self.original.push(item);//原创文章
                        }
                    });
                    self.alldata = article;//全部文章
                    let lastest_data = self.alldata.sort(self.compare('sortFlag',false));
                    lastest_data.forEach((item,index)=>{
                        if(index<5){
                            self.lastest.push(item);//最新文章
                        }
                    });
                });
            },
            character(time_into){//时间格式字符串转成数字
                let time_out = 0;
                time_out = time_into.replace(/-/g,'');
                time_out = time_out.replace(/:/g,'');
                time_out = time_out.replace(/ /g,'');
                time_out = parseInt(time_out);
                return time_out;
            },
            compare(property,flag){//根据数组中的某个元素的值进行排序;property传入的数组 flag：true正序 false倒序
                return function(a,b){
                    var value1 = a[property];
                    var value2 = b[property];
                    return flag?(value1 - value2):(value2 - value1);
                }
            },
            getSimpleText(html){//富文本中提取纯文本(删掉所有的样式和图片,只保留纯文本和标点符号)
                var re1 = new RegExp("<.+?>","g");//匹配html标签的正则表达式，"g"是搜索匹配多个符合的内容
                var msg = html.replace(re1,'');//执行替换成空字符
                var result = msg.replace(/[\r\n]/g,"");//取消文本中的换行
                return result;
            },
            get_collection_clip() {
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/sort_manage_get', {
                    params: {
                        bind: self.userId,//账户id
                    }
                }).then(function (res) {
                    self.collection_clip = res.data;
                    self.alldata.forEach(item => {
                        if (item.category) {
                            let ins = item.category[0].id;
                            self.collection_clip.forEach(info => {
                                if (!info.essay) {//如果不存在该字段 那么就添加
                                    info.essay = [];
                                }
                                if (ins == info.id) {
                                    info.essay.push(item);
                                    // console.log(info);
                                }
                            });
                        }
                    });
                    self.get_collection_clip_detail();
                });
            },
            get_collection_clip_detail(data){
                let sortFlag = data?data:this.sortId;
                this.collection_clip.forEach(item=>{
                    if(item.id == sortFlag){
                        this.collection_clip_detail = item;
                    }
                });
                // console.log(this.collection_clip_detail);
            },
            goBack () {//监听浏览器返回
                sessionStorage.clear();
                window.history.back();
                history.pushState(null, null, document.URL);
            },
        },
        mounted() {
            //监听banner栏坐标
            window.addEventListener('scroll',this.getScrollPosition,false);
            this.userId = this.$route.query.userId;
            this.sortId = this.$route.query.sortId;
            this.getArticle();
            this.get_collection_clip();

            //监听浏览器返回
            if (window.history && window.history.pushState) {
                // 向历史记录中插入了当前页
                history.pushState(null, null, document.URL);
                window.addEventListener('popstate', this.goBack, false);
            }
        },
        destroyed() {
            //监听banner栏坐标(摧毁)
            window.removeEventListener('scroll',this.getScrollPosition,false);
            //监听浏览器返回(摧毁)
            window.removeEventListener('popstate', this.goBack, false);
        },
        watch: {
            sortId:function(newVal) {
                this.$router.replace({
                    path: '/index/user/sorts',
                    name: 'sorts',
                    query: {userId: this.userId,sortId: newVal}
                });
            },
        }
    }
</script>

<style lang="less">
    .sorts{
        height: 100%;
        background-color: #343536;
    }
    .UbannerMenu {position: fixed;top: 0;width: 100%;z-index: 101;}
    .UleftMenu {position: fixed;z-index: 100;width:30rem;bottom: 0;}//上滑超出直接将左侧组件置bottom为零(无需计算超出多少高度)

    .banner_title{color:#fff;display:flex;justify-content: space-between;padding: 2rem 12vw 1rem 12vw;
        div{flex:1;display: flex;flex-direction: column;align-items: flex-start;text-align: left;
            span{color: #e2e2e2 !important;padding: .25rem 0;}
            span:nth-child(1){font-size: 2.4rem;}
            span:nth-child(2){font-size: 1.4rem;}
        }
    }

    .mainbody{padding: 0 12vw;margin-top: 1.5rem;
        .mainstay{padding: 0 2rem;text-align: left;height: 100%;}
    }
</style>