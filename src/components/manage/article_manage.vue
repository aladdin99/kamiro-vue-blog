<template>
    <div class="article_manage">
        <el-tabs v-model="activeName">
            <el-tab-pane :label="'全部('+labelAll+')'" name="first">
                <div class="article_banner">
                    <el-select v-model="year_value" placeholder="年" size="small" clearable>
                        <el-option
                                v-for="item in year"
                                :key="item.value"
                                :value="item.value">
                        </el-option>
                    </el-select>
                    <el-select v-model="type_value" placeholder="文章类型" size="small" clearable>
                        <el-option
                                v-for="item in type"
                                :key="item.value"
                                :value="item.value">
                        </el-option>
                    </el-select>
                    <el-select v-model="sort_value" placeholder="分类专栏" size="small" clearable>
                        <el-option
                                v-for="item in sort"
                                :key="item.value"
                                :value="item.value">
                        </el-option>
                    </el-select>
                    <el-input v-model="keyword" placeholder="请输入关键字" size="small" class="keyword"></el-input>
                    <span class="search" @click="searchInfo()">搜索</span>
                </div>
                <ul class="article_info">
                    <li v-for="(item,index) in showData" :key="index">
                        <div class="article_title" title="编辑">
                            <router-link :to="{path:'/md/mavon',query:{userId:item.related,articleId:item.uniqueId}}" style="color: #676767;">
                                <span v-show="item.draftsFlag=='0'" class="drafts">草稿</span>
                                {{item.title}}
                            </router-link>
                        </div>
                        <div class="article_detail">
                            <div class="article_detail_left">
                                <span>{{item.type}}</span>
                                <span>{{item.time}}</span>
                                <span><i class="el-icon-postcard"></i>13</span>
                                <span><i class="el-icon-chat-dot-square"></i>0</span>
                            </div>
                            <div class="article_detail_right">
                                <span><router-link target="_blank" :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}" style="text-decoration: none;color: #349EDF;">查看</router-link></span>
                                <el-divider direction="vertical" v-show="item.draftsFlag!='0'"></el-divider>
                                <span v-show="item.draftsFlag!='0'">
                                    <el-popover
                                            :value="item.comment_visible?true:false"
                                            placement="bottom-start"
                                            transition="fade-in-linear"
                                            trigger="click">
                                        <div id="article_detail_comment" style="cursor: pointer;box-sizing: border-box;">
                                            <div v-show="item.comment_limit" @click="changeLimit(0,0,index,item.uniqueId),item.comment_visible=0"><span style="margin-left: 3rem;">评论公开</span></div>
                                            <div v-show="!item.comment_limit" @click="changeLimit(0,0,index,item.uniqueId),item.comment_visible=0"><i class="el-icon-check" style="margin-right: 1.5rem;"></i><span>评论公开</span></div>
                                            <div v-show="!item.comment_limit" @click="changeLimit(0,1,index,item.uniqueId),item.comment_visible=0" style="margin-top:1rem;"><span style="margin-left: 3rem;">审核后公开</span></div>
                                            <div v-show="item.comment_limit" @click="changeLimit(0,1,index,item.uniqueId),item.comment_visible=0" style="margin-top:1rem;"><i class="el-icon-check" style="margin-right: 1.5rem;"></i>审核后公开</div>
                                        </div>
                                    </el-popover>
                                    <span slot="reference" @click="item.comment_visible=1">
                                        <span v-show="!item.comment_limit">评论公开</span>
                                        <span v-show="item.comment_limit">审核后公开</span>
                                        <i class="el-icon-caret-bottom"></i>
                                    </span>
                                </span>
                                <el-divider direction="vertical"></el-divider>
                                <span style="color: #CA0C16;" @click="dialogVisible = true,sendId(item.uniqueId)">删除</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="article_none" v-show="!showData.length">
                    <img :src="none"><div>空空如也</div>
                    <router-link to="/md/mavon" style="text-decoration: none;"><span>写博客</span></router-link>
                </div>
            </el-tab-pane>
            <el-tab-pane :label="'公开('+labelPublic+')'" name="second">
                <ul class="article_info" v-show="publicData.length">
                    <li v-for="(item,index) in publicData" :key="index">
                        <div class="article_title" title="编辑">
                            <router-link :to="{path:'/md/mavon',query:{userId:item.related,articleId:item.uniqueId}}" style="color: #676767;">
                                {{item.title}}
                            </router-link>
                        </div>
                        <div class="article_detail">
                            <div class="article_detail_left">
                                <span>{{item.type}}</span>
                                <span>{{item.time}}</span>
                                <span><i class="el-icon-postcard"></i>13</span>
                                <span><i class="el-icon-chat-dot-square"></i>0</span>
                            </div>
                            <div class="article_detail_right">
                                <span><router-link target="_blank" :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}" style="text-decoration: none;color: #349EDF;">查看</router-link></span>
<!--                                <el-divider direction="vertical" v-show="item.draftsFlag!='0'"></el-divider>-->
<!--                                <span v-show="item.draftsFlag!='0'">-->
<!--                                    <el-popover-->
<!--                                            :value="item.comment_visible?true:false"-->
<!--                                            placement="bottom-start"-->
<!--                                            trigger="click">-->
<!--                                        <div id="article_detail_comment" style="cursor: pointer;box-sizing: border-box;">-->
<!--                                            <div v-show="item.comment_limit" @click="changeLimit(1,0,index,item.uniqueId),item.comment_visible=0"><span style="margin-left: 3rem;">评论公开</span></div>-->
<!--                                            <div v-show="!item.comment_limit" @click="changeLimit(1, 0,index,item.uniqueId),item.comment_visible=0"><i class="el-icon-check" style="margin-right: 1.5rem;"></i><span>评论公开</span></div>-->
<!--                                            <div v-show="!item.comment_limit" @click="changeLimit(1, 1,index,item.uniqueId),item.comment_visible=0" style="margin-top:1rem;"><span style="margin-left: 3rem;">审核后公开</span></div>-->
<!--                                            <div v-show="item.comment_limit" @click="changeLimit(1, 1,index,item.uniqueId),item.comment_visible=0" style="margin-top:1rem;"><i class="el-icon-check" style="margin-right: 1.5rem;"></i>审核后公开</div>-->
<!--                                        </div>-->
<!--                                    </el-popover>-->
<!--                                    <span slot="reference" @click="item.comment_visible=1">-->
<!--                                            <span v-show="!item.comment_limit">评论公开</span>-->
<!--                                            <span v-show="item.comment_limit">审核后公开</span>-->
<!--                                            <i class="el-icon-caret-bottom"></i>-->
<!--                                        </span>-->
<!--                                </span>-->
                                <el-divider direction="vertical"></el-divider>
                                <span style="color: #CA0C16;" @click="dialogVisible = true,sendId(item.uniqueId)">删除</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="article_none" v-show="!publicData.length">
                    <img :src="none"><div>空空如也</div>
                    <router-link to="/md/mavon" style="text-decoration: none;"><span>写博客</span></router-link>
                </div>
            </el-tab-pane>
            <el-tab-pane  :label="'私密('+labelPrivate+')'" name="third">
                <ul class="article_info" v-show="privateData.length">
                    <li v-for="(item,index) in privateData" :key="index">
                        <div class="article_title" title="编辑">
                            <router-link :to="{path:'/md/mavon',query:{userId:item.related,articleId:item.uniqueId}}" style="color: #676767;">
                                {{item.title}}
                            </router-link>
                        </div>
                        <div class="article_detail">
                            <div class="article_detail_left">
                                <span>{{item.type}}</span>
                                <span>{{item.time}}</span>
                                <span><i class="el-icon-postcard"></i>13</span>
                                <span><i class="el-icon-chat-dot-square"></i>0</span>
                            </div>
                            <div class="article_detail_right">
                                <span><router-link target="_blank" :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}" style="text-decoration: none;color: #349EDF;">查看</router-link></span>
<!--                                <el-divider direction="vertical" v-show="item.draftsFlag!='0'"></el-divider>-->
<!--                                <span v-show="item.draftsFlag!='0'">-->
<!--                                    <el-popover-->
<!--                                            :value="item.comment_visible?true:false"-->
<!--                                            placement="bottom-start"-->
<!--                                            trigger="click">-->
<!--                                        <div id="article_detail_comment" style="cursor: pointer;box-sizing: border-box;">-->
<!--                                            <div v-show="item.comment_limit" @click="changeLimit(2,0,index,item.uniqueId),item.comment_visible=0"><span style="margin-left: 3rem;">评论公开</span></div>-->
<!--                                            <div v-show="!item.comment_limit" @click="changeLimit(2,0,index,item.uniqueId),item.comment_visible=0"><i class="el-icon-check" style="margin-right: 1.5rem;"></i><span>评论公开</span></div>-->
<!--                                            <div v-show="!item.comment_limit" @click="changeLimit(2,1,index,item.uniqueId),item.comment_visible=0" style="margin-top:1rem;"><span style="margin-left: 3rem;">审核后公开</span></div>-->
<!--                                            <div v-show="item.comment_limit" @click="changeLimit(2,1,index,item.uniqueId),item.comment_visible=0" style="margin-top:1rem;"><i class="el-icon-check" style="margin-right: 1.5rem;"></i>审核后公开</div>-->
<!--                                        </div>-->

<!--                                    </el-popover>-->
<!--                                    <span slot="reference" @click="item.comment_visible=1">-->
<!--                                            <span v-show="!item.comment_limit">评论公开</span>-->
<!--                                            <span v-show="item.comment_limit">审核后公开</span>-->
<!--                                            <i class="el-icon-caret-bottom"></i>-->
<!--                                    </span>-->
<!--                                </span>-->
                                <el-divider direction="vertical"></el-divider>
                                <span style="color: #CA0C16;" @click="dialogVisible = true,sendId(item.uniqueId)">删除</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="article_none" v-show="!privateData.length">
                    <img :src="none"><div>空空如也</div>
                    <router-link to="/md/mavon" style="text-decoration: none;"><span>写博客</span></router-link>
                </div>
            </el-tab-pane>
            <el-tab-pane :label="'草稿('+labelDrafts+')'" name="fourth">
                <ul class="article_info" v-show="labelDrafts">
                    <li v-for="(item,index) in draftsData" :key="index">
                        <div class="article_title" title="编辑"><span v-show="item.draftsFlag=='0'" class="drafts">草稿</span>{{item.title}}</div>
                        <div class="article_detail">
                            <div class="article_detail_left">
                                <span>{{item.type}}</span>
                                <span>{{item.time}}</span>
                                <span><i class="el-icon-postcard"></i>13</span>
                                <span><i class="el-icon-chat-dot-square"></i>0</span>
                            </div>
                            <div class="article_detail_right">
                                <span><router-link target="_blank" :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}" style="text-decoration: none;color: #349EDF;">查看</router-link></span>
                                <el-divider direction="vertical"></el-divider>
                                <span style="color: #CA0C16;" @click="dialogVisible = true,sendId(item.uniqueId)">删除</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="article_none" v-show="!labelDrafts">
                    <img :src="none"><div>空空如也</div>
                    <router-link to="/md/mavon" style="text-decoration: none;"><span>写博客</span></router-link>
                </div>
            </el-tab-pane>
        </el-tabs>

        <!--    删除文章的提示弹窗-->
        <el-dialog
                style="text-align:left;"
                title="提示"
                :visible.sync="dialogVisible"
                width="25%"
                :modal="true"
                :show-close="false"
                :close-on-click-modal="false">
            <span>确定要删除这篇文章吗？</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false" size="small">取 消</el-button>
                <el-button type="primary" @click="dialogVisible = false,deleteArticle(article_id)" size="small">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import none from "assets/none.jpg";//1.引入图片地址
    export default {
        name: "article_manage",
        data(){
            return{
                visible: false,
                author: '',//当前登陆者id
                none: none,//2.赋值图片地址,然后在:src中可以直接使用
                dialogVisible: false,
                activeName: 'first',
                year: [{
                    value: '2020',
                }, {
                    value: '2019',
                }, {
                    value: '2018',
                }],
                year_value: '',
                type: [{
                    value: '原创',
                }, {
                    value: '转载',
                }, {
                    value: '翻译',
                }],
                type_value: '',
                sort: [],//分类专栏列表
                sort_value: '',
                keyword: '',//关键字
                // comment_limit: 1,//1.代表评论公开 2.代表评论审核后公开
                getAllData: [],//获取所有文章
                showData: [],//应展示的文章
                publicData: [],//公开文章
                privateData: [],//私密文章
                draftsData: [],//草稿箱
                labelAll: "0",
                labelPublic: '0',
                labelPrivate: '0',
                labelDrafts: '0',
                article_id: '',//文章id
            }
        },
        methods:{
            sortName_get(){//获取分类专栏名
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/sort_manage_get',{
                    params: {
                        bind: self.author,
                    }
                }).then(function(res){
                    self.sort = [];
                    res.data.forEach(item=>{
                        self.sort.push({value:item.name});
                    });
                });
            },
            //'全部'下通过条件检索文章
            searchInfo(){
                this.showData = [];
                //筛选时间段
                if(this.year_value == ''){
                    this.showData = this.getAllData;
                }else{
                    this.getAllData.forEach(item=>{
                        if(item.time.split('-')[0] == this.year_value){
                            this.showData.push(item);
                        }
                    });
                }
                //筛选文章类型
                if(this.type_value == ''){
                    this.showData = this.showData;
                }else{
                    let type_data = [];
                    this.showData.forEach(item=>{
                        if(item.type == this.type_value){
                            type_data.push(item);
                        }
                    });
                    this.showData = type_data;
                }
                //筛选分类专栏
                // console.log(this.sort_value);
                if(this.sort_value == ''){
                    this.showData = this.showData;
                }else{
                    let sort_data = [];
                    this.showData.forEach(item=>{//字符串数组对象要转成数组/1
                        if(item.category[0].value == this.sort_value){
                            sort_data.push(item);
                        }
                    });
                    this.showData = sort_data;
                }
                //关键字搜索
                if(this.keyword == ''){
                    this.showData = this.showData;
                }else{
                    let keyword_data = [];
                    this.showData.forEach(item=>{
                        if(item.title.indexOf(this.keyword) != -1){
                            keyword_data.push(item);
                        }
                    });
                    this.showData = keyword_data;
                }
                // console.log(this.showData);
            },
            sendId(id){
                this.article_id = id;
            },
            //删除文章
            deleteArticle(id){
                // alert('删除'+id+this.author);
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/article_delete',{
                    params: {
                        id: self.author,
                        uniqueId: id
                    }
                }).then(function(res){
                    console.log(res);
                    self.searchAll();
                }).catch(function(res){
                    console.log(res);
                });
            },
            searchAll(){
                let self = this;
                self.publicData = [];//先清空公开的文章
                self.privateData = [];//先清空私密的文章
                self.draftsData = [];//先清空草稿的文章
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/article_manage',{
                    params: {
                        id: self.author,
                    }
                }).then(function(res){
                    self.getAllData = res.data;
                    self.getAllData = self.getAllData?self.getAllData:[];
                    self.labelAll = self.getAllData.length;//全部num
                    self.showData = self.getAllData;
                    // self.publicData =
                    self.getAllData.forEach(item=>{
                        if(item.shape == 0 && item.draftsFlag!='0'){//文章公开且非草稿
                            self.publicData.push(item);
                        }
                        if(item.shape == 1 && item.draftsFlag!='0'){//文章私密且非草稿
                            self.privateData.push(item);
                        }
                        if(item.draftsFlag=='0'){//文章是草稿
                            self.draftsData.push(item);
                        }
                    });
                    self.labelPublic = self.publicData.length;
                    self.labelPrivate = self.privateData.length;
                    self.labelDrafts = self.draftsData.length;
                    // console.log(self.publicData);
                    // var date = self.getAllData[0].time;
                    // alert(date.split('-')[0]);
                });
            },
            changeLimit(flag,limitValue,index,uniqueId){//flag.是在哪个列表下的(0-'全部'，1-'公开',2-'私密')  limitValue.评论权限值   index.文章位置  uniqueId.文章id
                switch(flag){
                    case 0:
                        this.showData[index].comment_limit = limitValue;//赋值处理，用于切换评论公开与审核后公开(全部)
                        break;
                    case 1:
                        this.publicData[index].comment_limit = limitValue;//赋值处理，用于切换评论公开与审核后公开（公开）
                        break;
                    case 2:
                        this.privateData[index].comment_limit = limitValue;//赋值处理，用于切换评论公开与审核后公开（私密）
                        break;
                }

                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/article_comment_limit',{
                    params: {
                        id: self.author,
                        uniqueId: uniqueId,
                        comment_limit: limitValue //评论权限 0.评论公开 1.审核后公开
                    }
                });
            },
        },
        mounted() {
            this.author = localStorage.getItem('email');//当前登陆id
            this.sortName_get();
            this.searchAll();
        }
    }
</script>

<style lang="less">
    .article_manage{width: 100%; background-color: #fff ;padding: 1.5rem 2rem;box-sizing: border-box;min-height: 78rem;
        .article_banner{background-color: #f2f5f7;padding: 2rem 0;box-sizing: border-box;
            .el-select{
                &:nth-child(1){width: 8rem;}
                &:nth-child(2){width: 12rem;margin-left: 4rem;}
                &:nth-child(3){width: 12rem;margin-left: 4rem;}
            }
            .keyword{width: 16rem;margin-left: 4rem;}
            .search{display: inline-block;padding: .7rem 2.5rem;background-color: #CA0C16;color: #fff;border-radius: .5rem;margin-left: 4rem;cursor: pointer;}
        }
        .article_info{list-style: none;
            li{display: inline-block;width:100%;background-color: #fff;height: 8rem;border-bottom: 1px solid #e9e9e9;
                .article_title,.article_detail{flex:1;}
                .article_title{text-align: left;font-size: 1.8rem;color: #4d4d4d;word-wrap: break-word;word-break: break-word;cursor: pointer;padding: 1.5rem 0;
                    &:hover{color: #CA0C16;}
                }
                .article_detail{display: flex;justify-content: space-between;
                    .article_detail_left{color: #999;font-size: 1.2rem;
                        &>span{margin-left: 3rem;}
                        &>span:nth-child(1){margin-left: 0;}
                        i{margin-right: .4rem;font-size: 1.4rem;}
                    }
                    .article_detail_right{font-size: 1.2rem;color: #349EDF;padding: 0px 1.5rem;border-right: 1px solid #e9e9e9;cursor: pointer;
                        //#article_detail_comment{}//el-popover内无法使用类名样式
                    }
                }
            }
        }
        .article_none{margin-top: 10rem;
            img{width: 35rem;height: 25rem;}
            div{font-size: 1.6rem;color: #6B6B6B;font-weight: bold;letter-spacing: .2rem;margin: 1.5rem 0;}
            span{display: inline-block;background-color: #CA0C16;color: #fff;padding: 1rem 10rem;margin-top: 1.5rem;font-size: 1.8rem;border-radius: .5rem;cursor: pointer;}
        }
        .drafts{display: inline-block;font-size: 1.2rem;color:#999;padding: .25rem 1rem;border: 1px solid #e9e9e9;margin-right: 1rem;}
    }
</style>