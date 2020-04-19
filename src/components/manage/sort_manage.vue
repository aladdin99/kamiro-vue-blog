<template>
    <div class="sort_banner" style="min-height: 68rem;">
        <!--分类专栏-->
        <div class="sort_index" v-show="indexFlag">
            <div class="sort_banner">分类专栏</div>
            <div class="tip_banner">
                <span>个人分类与专栏管理合并啦！</span>
                <span @click="edit(0)">新建</span>
            </div>
            <el-tabs v-model="activeName" style="padding: 0 1.5rem;">
                <el-tab-pane :label="'全部('+sort_data.length+')'" name="first">
                    <div class="sort_title">
                        <div class="sort_category">
                            <span>类别</span>
                        </div>
                        <div class="sort_setUp">
                            <span>操作</span>
                            <span>前台是否显示</span>
                            <span>文章数</span>
                        </div>
                    </div>
                    <ul><li v-for="(item,index) in sort_data" :key="index">
                        <div class="sort_category_content">
                            <span><img :src="item.picture"></span>
                            <span>{{item.name}}</span>
                        </div>
                        <div class="sort_setUp_content">
                            <div>
                                <span @click="manage(item.id,item.name)">管理</span><el-divider direction="vertical"></el-divider>
                                <span @click="edit(1,item.name,item.describe,item.picture,item.id)">编辑</span>
                                <el-divider direction="vertical"></el-divider><span @click="deleted(item.id)">删除</span>
                            </div>
                            <div><el-switch :value="item.show==1?true:false" active-color="#13ce66" inactive-color="#ff4949" @change="switchs(index,item.show,item.id)"></el-switch></div>
                            <div>{{item.total}}</div>
                        </div>
                    </li></ul>
                    <div v-show="!sort_data.length">
                        <img :src="none" style="width: 35rem;height: 25rem;margin-top:10rem;">
                        <div style="font-size: 1.6rem;color: #6B6B6B;font-weight: bold;letter-spacing: .2rem;margin: 1.5rem 0;">空空如也</div>
                    </div>
                </el-tab-pane>

                <el-tab-pane :label="'回收站('+sort_data_del.length+')'" name="second">
                    <div class="sort_title">
                        <div class="sort_category">
                            <span>类别</span>
                        </div>
                        <div class="sort_setUp" style="dispaly:flex;justify-content:space-between;">
                            <span></span>
                            <span>操作</span>
                        </div>
                    </div>
                    <ul><li v-for="(item,index) in sort_data_del" :key="index">
                        <div class="sort_category_content">
                            <span><img :src="item.picture"></span>
                            <span>{{item.name}}</span>
                        </div>
                        <div class="sort_setUp_content" style="display:flex;justify-content:space-between;">
                            <div></div>
                            <div>
                                <span @click="recovery(item.id)" style="cursor:pointer;color: #349edf;">一键恢复</span><el-divider direction="vertical"></el-divider>
                                <span @click="deletedAgain(item.id)" style="cursor:pointer;color: #ca0c16;">彻底删除</span>
                            </div>
                        </div>
                    </li></ul>
                    <div v-show="!sort_data_del.length">
                        <img :src="none" style="width: 35rem;height: 25rem;margin-top:10rem;">
                        <div style="font-size: 1.6rem;color: #6B6B6B;font-weight: bold;letter-spacing: .2rem;margin: 1.5rem 0;">空空如也</div>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
        <!--分类管理-->
        <div class="sort_manage_content" v-show="mannerFlag">
            <div class="banner_one">
                <div class="back_manner">
                    <i class="el-icon-arrow-left"></i>
                    <span @click="backIndex" >返回分类专栏</span>
                </div>
                <div>
                    <span>{{clickName}}</span>
                    <i class="el-icon-arrow-right"></i>
                    <span>管理文章</span>
                </div>
            </div>
            <div class="content">
                <ul v-show="single_sort.length">
                    <li v-for="(item,index) in single_sort" :key="index">
                        <div>{{item.title}}</div>
                        <div>
                            <span><router-link target="_blank" :to="{path:'/index/user/details',query:{userId:item.related,articleId:item.uniqueId}}" style="color: #349EDF;">查看</router-link></span>
                            <el-divider direction="vertical"></el-divider>
                            <span><el-button type="text" @click="delArticle(item.related,item.uniqueId,index)" size="small">删除</el-button></span>
                        </div>
                    </li>
                </ul>
                <div v-show="!single_sort.length">
                    <img :src="none" style="width: 35rem;height: 25rem;margin-top:10rem;">
                    <div style="font-size: 1.6rem;color: #6B6B6B;font-weight: bold;letter-spacing: .2rem;margin: 1.5rem 0;">空空如也</div>
                </div>
            </div>
        </div>
        <!--分类编辑-->
        <div class="sort_edit" v-show="editFlag">
            <div class="back_manner">
                <i class="el-icon-arrow-left"></i>
                <span @click="backIndex">返回分类专栏</span>
            </div>
            <ul>
                <li>
                    <span><b>*</b> 分类专栏名称：</span>
                    <div style="display: flex;width: 50%;"><el-input placeholder="请输入分类专栏名称" size="small" style="width: 100%;" v-model="sort.name"></el-input></div>
                    <span class="tip" v-show="!sort.name">分类专栏名称不能为空！</span>
                </li>
                <li>
                    <span><b>*</b> 分类专栏简介：</span>
                    <el-input
                            type="textarea"
                            placeholder="例，以实战为线索，逐步深入React开发各个环节，掌握前端常用性能体验优化思路，打造完整的前端工作流，提升工程化编码能力和思维能力。"
                            v-model="sort.describe"
                            maxlength="150"
                            show-word-limit
                            rows=4
                            style="width: 50%;"
                    >
                    </el-input>
                    <span class="tip" v-show="!sort.describe">分类专栏简介不能为空！</span>
                </li>
                <li>
                    <span style="margin-left: 1rem;">分类专栏配图：</span>
                    <span style="display: inline-block;width: 10rem;height: 10rem;border-radius: .5rem;">
                        <el-upload
                                class="avatar-uploader"
                                action="http://localhost/graduation_project/blog2/src/php/manage/sort_manage_pictiure"
                                :show-file-list="false"
                                :on-success="handleAvatarSuccess"
                                :before-upload="beforeAvatarUpload">
                          <img v-if="sort.picture" :src="sort.picture" class="avatar">
                          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </span>
                </li>
                <li><span @click="submit(submitFlag)">提交</span></li>
            </ul>
        </div>
    </div>
</template>

<script>
import none from "assets/none.jpg";//1.引入图片地址
export default {
    name: "sort_manage",
    props: ["sortFlag"],
    data() {
        return {
            none: none,
            author: '',//当前登录账号
            imageUrl:'',
            activeName: 'first',
            value: true,
            indexFlag: true,//分类专栏主页是开启的
            mannerFlag: false,//默认管理页面是关闭的
            editFlag: false,//默认编辑页面是关闭的
            sort: {
                name: '',//分类名称
                describe: '',//分类专栏简介
                picture: '',//图片地址
            },
            sort_data: [],//存放获取到的分类栏数据
            sort_data_del: [],//存放获取到的回收分类栏数据
            submitFlag: '',//1.编辑分类栏  0.新建分类栏
            sort_id: '',//单个分类栏ID
            sort_detail: [],//所有分类夹内的文章
            single_sort: [],//指定分类夹内的文章
            clickName: "",
        }
    },
    methods: {
        delArticle(related,uniqueId,index){
            let self = this;
            this.$confirm('确定要删除当前文章?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: '删除成功!'
                });
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/article_delete',{
                    params: {
                        id: related,//作者id
                        uniqueId: uniqueId,//文章id
                    }
                }).then(function(res){
                    self.getSort();
                    self.getSortDetail();
                    // index
                    self.single_sort.splice(index,1);
                    console.log(res);
                });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消删除'
                });
            });
        },
        manage(id,name){//管理
            this.indexFlag = false;
            this.mannerFlag = true;
            this.editFlag = false;
            this.single_sort = [];
            this.sort_detail.forEach(item=>{
                if(item.id == id) {
                    this.single_sort.push(item);
                }
            });
            this.clickName = name;
        },
        edit(flag,name,describe,picture,id){
            this.indexFlag = false;
            this.mannerFlag = false;
            this.editFlag = true;
            this.submitFlag = flag?1:0;
            this.sort_id = id;
            if(flag){
                this.sort.name = name;
                this.sort.describe = describe;
                this.sort.picture = picture;
            }else{
                this.sort.name = "";
                this.sort.describe = "";
                this.sort.picture = "";
            }
        },
        backIndex(){
            this.indexFlag = true ;
            this.mannerFlag = false;
            this.editFlag = false;
        },
        deletedAgain(id){
            let self = this;
            this.$confirm('是否确定要彻底删除当前分类专栏?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: '彻底删除成功!'
                });
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/manage/sort_manage',{
                    status: 5,//彻底删除当前分类栏
                    id: id,//当前分类栏的id
                    bind: self.author,//账户id
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个解决跨域
                }).then(function (res) {
                    console.log(res);
                    self.getSort();
                });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消删除'
                });
            });
        },
        recovery(id) {//恢复回收中单个分类专栏
            let self = this;
            this.$confirm('是否确定要一键恢复当前分类专栏?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: '恢复成功!'
                });
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/manage/sort_manage',{
                    status: 4,//恢复当前分类栏
                    id: id,//当前分类栏的id
                    bind: self.author,//账户id
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个解决跨域
                }).then(function (res) {
                    console.log(res);
                    self.getSort();
                });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消恢复'
                });
            });
        },
        deleted(id) {//删除单个分类专栏
            let self = this;
            this.$confirm('确定要删除当前分类专栏?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: '删除成功!'
                });
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/manage/sort_manage',{
                    status: 3,//删除当前分类栏
                    id: id,//当前分类栏的id
                    bind: self.author,//账户id
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个解决跨域
                }).then(function (res) {
                    console.log(res);
                    self.getSort();
                });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消删除'
                });
            });
        },
        switchs(index,show,id){//更新是否前台展示该分类栏
            this.sort_data[index].show = show?0:1;
            let self = this;
            this.$axios.post('http://localhost/graduation_project/blog2/src/php/manage/sort_manage',{
                status: 2,//更新是否前台展示该分类栏
                id: id,//当前分类栏的id
                bind: self.author,//账户id
                show: self.sort_data[index].show
            },{
                headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个解决跨域
            }).then(function (res) {
                console.log(res);
            });
        },
        getSort(){//获取所有分类栏
            let self = this;
            self.sort_data = [];
            self.sort_data_del = [];
            this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/sort_manage_get',{
                params: {
                    bind: self.author,//账户id
                }
            }).then(function(res){
                // self.sort_data = res.data;
                res.data.forEach(item=>{
                    item.total = 0;
                    if(item.recover=='0'){// 0.未回收的全部分类栏
                        self.sort_data.push(item);
                    }else if(item.recover=='1'){// 1.已回收的全部分类栏
                        self.sort_data_del.push(item);
                    }
                });
            });
        },
        getSortDetail(){//获取分类栏中的所有文章标题 id 以及分类
            let self = this;
            this.$axios.get('http://localhost/graduation_project/blog2/src/php/manage/sort_manage_detail',{
                params: {
                    bind: self.author,//账户id
                }
            }).then(function(res){
                let data = res.data;
                data.forEach(item=>{
                    item.id = item.category.id;
                    item.value = item.category.value;
                });
                data.forEach(item=>{
                    self.sort_data.forEach(info=>{
                        if(item.id == info.id){
                            info.total++;
                        }
                    });
                });
                self.sort_detail = data;
            });
        },

        checkd(){//检查是否都填完了
            if(!this.sort.name){
                alert('分类专栏名称不能为空！');
            }else if(!this.sort.describe){
                alert('分类专栏简介不能为空！');
            }else if(!this.sort.picture){
                alert('分类专栏配图不能为空！');
            }
        },
        submit(submitFlag){//提交分类专栏信息修改
            this.checkd();
            let self = this;
            if(this.sort.name&&this.sort.describe&&this.sort.picture){
                this.$axios.post('http://localhost/graduation_project/blog2/src/php/manage/sort_manage',{
                    status: submitFlag?1:0,//1.编辑分类栏  0.新建分类栏
                    id: self.sort_id,//单个分类栏ID
                    bind: self.author,//账户id
                    name: self.sort.name, //分类名称
                    describe: self.sort.describe,//分类简介
                    picture: self.sort.picture //表面图片路径
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个解决跨域
                }).then(function (res) {
                    console.log(res);
                    alert('操作成功!');
                    self.backIndex();
                    self.sort.name = '';
                    self.sort.describe = '';
                    self.sort.picture = '';
                    self.getSort();
                });
            }
        },
        //上传头像的两个方法
        handleAvatarSuccess(res, file) {//res就是后端返回来的图片地址
            this.imageUrl = URL.createObjectURL(file.raw);
            this.sort.picture = res;//图片地址
        },
        beforeAvatarUpload(file) {
            const isJPG = file.type === 'image/jpeg';
            const isLt2M = file.size / 1024 / 1024 < 2;

            if (!isJPG) {
                this.$message.error('上传头像图片只能是 JPG 格式!');
            }
            if (!isLt2M) {
                this.$message.error('上传头像图片大小不能超过 2MB!');
            }
            return isJPG && isLt2M;
        }
    },
    mounted(){
        this.author = localStorage.getItem('email');//当前登陆id
    },
    watch: {//点击左侧'分类专栏'才获取页面数据(父组件传值)
        sortFlag:function(newVal){
            if(newVal){
                this.getSort();
                this.getSortDetail();
            }
        }
    }
}
</script>

<style lang="less">
    a{text-decoration: none;}
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        width: 10rem;
        height: 10rem;
        border-radius: .3rem;
        height: 10rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 10rem;
        height: 10rem;
        border-radius: .3rem;
        line-height: 10rem;
        text-align: center;
    }
    .avatar{
        width: 10rem;
        height: 10rem;
        border-radius: .3rem;
        display: block;
    }
    .sort_banner{background-color: #fff ;box-sizing: border-box;height: 100%;width: 100%;padding: 1.5rem 0;
        .sort_index{
            .sort_banner{text-align: left;color: #212529;font-size: 1.8rem;padding: 1.6rem 1.5rem;font-weight: bold;}
            .tip_banner{display: flex;justify-content: space-between;padding: 0 1.5rem;font-size: 1.4rem;color: #999;
                span:nth-child(2){display: inline-block;padding: .5rem 1.8rem;border-radius:.5rem;border: 1px solid #CA0C16;color: #CA0C16;cursor: pointer;
                    &:hover{color: #fff;background-color: #CA0C16;}
                }
            }
            .sort_title{display: flex;justify-content: space-between;color: #999;border-bottom: 1px solid #f3f3f3;padding-bottom: 1.5rem;
                .sort_category{margin-left: 1rem;flex: 1;text-align: left;}
                .sort_setUp{display: flex;flex: 1;
                    span:nth-child(1){flex: 3;}
                    span:nth-child(2){flex: 2;}
                    span:nth-child(3){flex: 2;}
                }
            }
            ul{list-style: none;
                li{display: flex;justify-content: space-between;align-items: center;padding: 2rem 0;border-bottom: 1px dotted #ddd;
                    &:hover{background-color: #fafafa;}
                    .sort_category_content{flex: 1;display: flex;justify-content: left;align-items: center;
                        span:nth-child(1){display:inline-block;width: 4.5rem;height:4.5rem;border: 1px solid #349EDF;cursor: pointer;
                            img{display:inline-block;width: 4.5rem;height:4.5rem; }
                        }
                        span:nth-child(2){margin-left: 2.5rem;color: #61575a;font-weight: bold;}
                    }
                    .sort_setUp_content{flex:1;display: flex;justify-content: space-between;align-items: center;
                        div:nth-child(1){flex: 3;
                            span{color: #349edf;font-size: 1.2rem;cursor: pointer;}
                            span:last-child{color: #ca0c16;}
                        }
                        div:nth-child(2){flex: 2;}
                        div:nth-child(3){flex: 2;color: #545454;}
                    }
                }
            }
        }
        .sort_manage_content{padding: 1.5rem 1.5rem;padding-right: 4rem;
            .banner_one{display: flex;justify-content: space-between;align-items: center;padding: 0;border: none;
                div:nth-child(2){
                    /*span:nth-child(1){font-size: 1.8rem;color: #000;font-weight: bold;cursor: pointer;}*/
                    span{font-size: 1.4rem;color: #303133;font-weight: 500;cursor: pointer;}
                    i{padding: 0 .5rem;font-size: 1.4rem;color: #303133;font-weight: 500;}
                }
            }
            .content{
                li {display: flex;justify-content: space-between;padding: 2rem 0 1rem 0;border-bottom: 1px dotted #ddd;list-style: none;
                    div:nth-child(1){font-size: 1.6rem;font-weight: 400;color: #212529;}
                    div:nth-child(2){color: #349edf;cursor: pointer;font-size: 1.2rem;
                        span:last-child{color: #CA0C16;}
                    }
                }
            }
        }
        .back_manner{display: flex;justify-content: left;align-items: center;cursor:pointer;margin-bottom:1rem;font-size:1.6rem;color: #303133;font-weight: 500; i{margin-right: .2rem;font-size: 1.6rem;}}
        .sort_edit{padding: 1.5rem 1.5rem;
            ul{list-style: none;
                li{display: flex;justify-content: left;align-items: flex-start;padding: 1.5rem .5rem;
                    span:nth-child(1){margin-right: .5rem}
                    .tip{margin-left: 1rem;color: #f56c6c;font-size: 1.2rem;margin-top: .5rem;}
                }
                li:last-child{
                    span{padding: .5rem 1.5rem;border: 1px solid #CA0C16;color: #CA0C16;border-radius: .5rem;cursor:pointer;margin-left: 2rem;
                        &:hover{color: #fff;background-color: #CA0C16;}
                    }
                }
                b{color: #CA0C16;}
            }
        }
    }
</style>