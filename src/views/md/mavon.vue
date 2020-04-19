<template>
    <div class="mavon">
        <div class="mavon_articleTitle">
            <div>
                <i class="el-icon-arrow-left"></i><router-link to="/manage/managing" style="text-decoration: none;color: #2c3e50;">文章管理</router-link>
                <div><input type="text" placeholder="输入文章标题" v-model="wr_title"></div>
            </div>
            <div>
                <span class="mavon_save" @click="save()">保存草稿</span>
                <span class="mavon_release" @click="dialogFormVisible = true">发布文章</span>
                <span class="mavon_avatar"><router-link to="/personal/index"><img :src="circleUrl"></router-link></span>
            </div>
        </div>
        <div class="md">
            <mavon-editor
                    v-model = "wr_content"
                    ref=md
                    defaultOpen="edit"
                    @imgAdd="$imgAdd"
                    @imgDel="$imgDel"
                    @save="saveMavon"
                    style="height: 100%;border: 1px solid #ccc ;box-shadow: none;"/>
        </div>
        <!--        <div> 这个html片段可以用来转化md文档格式-->
        <!--            <mavon-editor-->
        <!--                    class="md"-->
        <!--                    :value="wr_content"-->
        <!--                    :subfield = "false"-->
        <!--                    :defaultOpen = "'preview'"-->
        <!--                    :toolbarsFlag = "false"-->
        <!--                    :editable="false"-->
        <!--                    :scrollStyle="true"-->
        <!--                    :ishljs = "true"-->
        <!--            ></mavon-editor>-->
        <!--        </div>-->
        <el-dialog title="发布文章"
                   :visible.sync="dialogFormVisible"
                   :show-close="false"
                   width="3"
                   style="text-align: left;">
            <div style="margin-bottom: 2.5rem;">
                <span>文章标签：</span>
                <el-cascader :options="options" :show-all-levels="false" v-model="tag"></el-cascader>
            </div>
            <div style="margin-bottom: 2.5rem;">
                <span>分类专栏：</span>
                <el-select v-model="wr_category" placeholder="请选择">
                    <el-option
                            v-for="(item,index) in category"
                            :key="index"
                            :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div style="margin-bottom: 2.5rem;">
                <span>文章类型：</span>
                <el-select v-model="type" placeholder="请选择">
                    <el-option
                            v-for="item in mold"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
                <el-input v-show="type==1" v-model="links" placeholder="请填写原文链接" style="display: inline-block;width: 50%;margin-left: 1.5rem;"></el-input>
            </div>
            <div>
                <span>发布形式：</span>
                <el-select v-model="shape" placeholder="请选择">
                    <el-option
                            v-for="(item,index) in form"
                            :key="index"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="pushArticle(),dialogFormVisible = false">发布文章</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        name: "blogging",
        data(){
            return{
                img_file: {},
                circleUrl:"http://localhost/graduation_project/blog2/src/assets/avatar/IMG_1066(20200214-130610).JPG",
                dialogFormVisible: false,
                options: [{//文章标签数据
                    value: 'shujvku',
                    label: "数据库",
                    children:[{
                        value: 'mysql',
                        label: 'mysql'
                    },{
                        value: 'sql',
                        label: 'sql'
                    },{
                        value: 'redis',
                        label: 'resis'
                    },{
                        value: 'mongodb',
                        label: 'mongodb'
                    },{
                        value: 'json',
                        label: 'json'
                    }]
                },{
                    value: 'gongjv',
                    label: '工具',
                    children: [{
                        value: 'git',
                        label: 'git'
                    },{
                        value: 'github',
                        label: 'github'
                    },{
                        value: 'windows',
                        label: 'windows'
                    },{
                        value: 'sublime',
                        label: 'sublime text'
                    },{
                        value: 'webstorm',
                        label: 'webstorm'
                    },{
                        value: 'idea',
                        label: 'intellij idea'
                    },{
                        value: 'vscode',
                        label: 'visual studio code'
                    }]
                },{
                    value: 'qiandaun',
                    label: '前端',
                    children: [{
                        value: 'JavaScript',
                        label: 'JavaScript'
                    },{
                        value: 'css',
                        label: 'css'
                    },{
                        value: 'html',
                        label: 'html'
                    },{
                        value: 'vue.js',
                        label: 'vue.js'
                    },{
                        value: 'node.js',
                        label: 'node.js'
                    },{
                        value: 'jquery',
                        label: 'jquery'
                    },{
                        value: 'react',
                        label: 'react'
                    }]
                },{
                    value: 'housuan',
                    label: '后端',
                    children: [{
                        value: 'Java',
                        label: 'Java'
                    },{
                        value: 'PHP',
                        label: 'PHP'
                    },{
                        value: 'Python',
                        label: 'Python'
                    },{
                        value: 'C++',
                        label: 'C++'
                    },{
                        value: 'Spring',
                        label: 'Spring'
                    },{
                        value: 'C语言',
                        label: 'C语言'
                    },{
                        value: 'C#',
                        label: 'C#'
                    }]
                }],
                checkAll: false,
                isIndeterminate: true,
                category: ['程序人生','前端','后端','数据结构与算法','生活记录'],
                mold: [{
                    value: 0,
                    label: '原创'
                }, {
                    value: 1,
                    label: '转载'
                }, {
                    value: 2,
                    label: '翻译'
                }],
                form: [{
                    value: 0,
                    label: '公开'
                }, {
                    value: 1,
                    label: '私密'
                }, {
                    value: 2,
                    label: '粉丝可见'
                }],
                tag: '',
                type: '',
                shape: '',//0.公开 1.私密 2.粉丝可见
                links: '',
                author: '',//用户id
                nickName: '',//昵称
                wr_title: '',//文章标题
                wr_content: '',//文章内容
                wr_tag: '',//文章标签
                wr_category: '',//文章类别
                wr_type: '',//文章类型
                draftsFlag: 1,//文章默认是非草稿
                uniqueId: '',//文章的唯一标识
            }
        },
        methods:{
            save(){//保存到草稿箱
                this.draftsFlag = 0;
                this.pushArticle();
            },
            checked(title,content){
                if(!title){
                    alert('文章标题不能为空！');
                }else if(!content){
                    alert('文章内容不能为空！');
                }
            },
            pushArticle(){//发表文章
                // alert(this.uniqueId);
                this.wr_tag = this.tag?this.tag[1]:'';
                this.wr_title = this.wr_title;
                this.wr_type = this.mold[this.type]?this.mold[this.type].label:'';
                let self = this;
                this.checked(self.wr_title,self.wr_content);//简单验证文章内容不能为空！

                let category_form = [];
                this.category.forEach(item=>{
                    if(item.value == self.wr_category){
                        category_form.push(item);
                    }
                });

                // console.log(self.author,self.wr_title,self.wr_content,self.wr_tag,self.wr_category,self.wr_type, self.links);
                if(self.wr_title&&self.wr_content){//文章编写的时候要注意部分词义可能与mysql中语法冲突 导致无法保存而报错。
                    this.$axios.post('http://localhost/graduation_project/blog2/src/php/article/article',{
                        related: self.author,//当前登陆者
                        nickName: self.nickName,//昵称
                        title: self.wr_title,//文章标题
                        content: self.wr_content,//文章内容
                        tag: self.wr_tag,//文章标签
                        category: category_form,//文章分类
                        type: self.wr_type,//文章类型
                        links: self.links,//非原创链接
                        shape: self.shape?self.shape:0,//发布形式 0.公开 1.私密 2.粉丝可见
                        draftsFlag: self.draftsFlag,//文章是否是草稿 0.草稿 1.非草稿
                        uniqueIdFlag: self.uniqueId,//文章的唯一ID
                    },{
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个
                    }).then(function (res) {//返回了文章id
                        // console.log(res);
                        //发布成功跳转
                        if(self.draftsFlag){//直接发布
                            let content = self.wr_content;
                            self.$router.push({ path: '/md/mavon/released', query: { title: self.wr_title,content: content,articleId:res.data,userId:self.author }});
                            //清空数据
                            self.wr_title = '';
                            self.wr_content = '';
                            self.type = '';
                            self.tag = '';
                            self.wr_category = '';
                            self.draftsFlag = 1;
                        }else{//存为草稿
                            alert('已成功保存到草稿箱！');
                            self.draftsFlag = 1;
                            if(!self.uniqueId){
                                self.uniqueId = res.data.replace('\r\n\r\n','');//直接只返回文章的id（稍作处理'\n'符）
                            }
                        }
                    });
                }
            },
            //富文本保存的方法
            saveMavon(value,render){//render.包含文章内容+图片 value.仅包括文章中的所有图片
                this.wr_content = render;
                // console.log("this is render"+render);
                // console.log("this is value"+value);
                // this.getSimpleText(this.wr_content);
            },
            //富文本中提取纯文本(删掉所有的样式和图片,只保留纯文本和标点符号)
            getSimpleText(html){
                var re1 = new RegExp("<.+?>","g");//匹配html标签的正则表达式，"g"是搜索匹配多个符合的内容
                var msg = html.replace(re1,'');//执行替换成空字符
                var result = msg.replace(/[\r\n]/g,"");//取消文本中的换行
                return result;
            },
            // 绑定@imgAdd event
            $imgAdd(pos, $file) {
                console.log("触发图片上传");
                // 第一步.将图片上传到服务器.
                var formdata = new FormData();
                formdata.append('image', $file);
                this.img_file[pos] = $file;
                let self = this;
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/article/article_picture',{
                    file: $file.miniurl,
                    name: $file.name
                },{
                    headers: {'Content-Type': 'multipart/form-data'} //加上这个
                }).then(function(res){
                    let _res = res.data;
                    // 第二步.将返回的url替换到文本原位置![...](0) -> ![...](url)
                    self.$refs.md.$img2Url(pos, _res);
                });
            },
            $imgDel(pos) {
                delete this.img_file[pos];
            },
            get_sort_clip(){//获取分类栏
                let self = this;
                self.category = [];
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/sort_manage_get',{
                    params: {
                        bind: self.author,//账户id
                }
                }).then(function(res){
                    let getsorts = res.data;
                    getsorts.forEach(item=>{
                        let obj = new Object();
                        obj.id = item.id;
                        obj.value = item.name;
                        self.category.push(obj);
                    });
                    console.log(self.category);
                });
            },
            getArticle(userId,articleId){//更新文章(先获取文章再提交文章)
                if(!userId||!articleId) return;
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/article/article_get_item',{
                    params: {
                        uniqueId: articleId,
                        related: userId
                    }
                }).then(function(res){
                    self.wr_title = res.data.title;
                    self.wr_content = res.data.content;
                    self.uniqueId = articleId;
                });
            },
        },
        mounted() {
            this.author = localStorage.getItem('email');//当前登陆id
            this.nickName = localStorage.getItem('nickName');//当前登录者昵称
            this.uniqueId = '';
            let userId = this.$route.query.userId;
            let articleId = this.$route.query.articleId;
            this.getArticle(userId,articleId);//直接获取文章，更新文章
            this.get_sort_clip();
        }
    }
</script>

<style lang="less">
    .mavon{background-color: #f3f3f3;margin: 0;padding: 0;padding-top: 1rem;
        .mavon_articleTitle{display: flex;justify-content: space-between;align-items: center;padding: 0 1rem;
            &>div:nth-child(1){flex: 1;font-size: 1.8rem;text-align: left;cursor: pointer;line-height: 3rem;display:flex;align-items: center;
                i{padding-right: 5px;font-size: 2rem;}
                div{display: inline-block;width: 80%;
                    input{display: inline-block;width: 100%;margin-left: 1rem;height: 4rem;border-radius: .5rem;font-size: 2rem;padding: 0 1.5rem;
                        box-shadow: none; outline-color: invert ;
                        outline-style: none ;
                        outline-width: 0px ;
                        border-style: none ;
                        text-shadow: none ;
                        -webkit-appearance: none ;
                        -webkit-user-select: text ;
                        outline-color: transparent ;
                        box-shadow: none;
                        border: 1px solid #ccc ;
                    }
                }
            }
            &>div:nth-child(2){display: flex;justify-content: right ;align-items: center;margin-right: 1rem;
                /* .release,.save{display:inline-block;text-align:center;line-height:3.5rem;width: 9rem;height: 3.5rem;background-color: #CA0C16;color: #fff;border-radius: .5rem;cursor: pointer;}*!*!*/
                /* .save{margin-right: 1rem;background-color: #fff;color: #CA0C16;border: 1px solid #CA0C16;height: 3.5rem;}*/
                .mavon_save{background-color: #fff;display: inline-block;height: 3.5rem;line-height:3.5rem;width: 9rem;border-radius: .5rem;border: 1px solid #CA0C16;color: #CA0C16;margin-right: 1.5rem;cursor: pointer;}
                .mavon_release{background-color: #CA0C16;display: inline-block;height: 3.5rem;line-height:3.5rem;width: 9rem;border-radius: .5rem;border: 1px solid #fff;color: #fff;cursor: pointer;}
                .mavon_avatar{padding-left: 2rem;
                    img{width: 3.5rem;height: 3.5rem;border-radius: 50%;}
                }
            }
        }
        .md{height: 80vh;background-color: #428bca;margin-top: 2rem;}
    }
</style>