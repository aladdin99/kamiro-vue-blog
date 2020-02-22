<template>
    <div class="dataChange">
        <div class="bannerTop">个人资料</div>
        <div class="setUp">
            <div class="avatar">
                <span>
                    <el-upload
                            style="padding: 0;"
                            class="avatar-uploader"
                            action="http://localhost/graduation_project/blog2/src/php/personal/getAvatar"
                            :show-file-list="false"
                            :data="uploadData"
                            :on-success="handleAvatarSuccess"
                            :before-upload="beforeAvatarUpload">
                      <img v-if="imageUrl" :src="imageUrl" class="avatar">
                      <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </span>
                <div>修改头像</div>
            </div>
            <div class="means">
                <div class="part1">
                    <span>ID: {{form.id}}</span>
                    <span>个人主页 <i class="el-icon-arrow-right"></i></span>
                </div>
                <div class="part2">
                    <span>关注 3</span>
                    <span>粉丝 2</span>
                </div>
                <ul class="part3">
                    <li class="modify" style="display: flex;justify-content: space-between;width: 100%;height: 3rem;padding: 0;">
                        <div>昵称: <span>{{form.nickName}}</span></div>
                        <span class="specail">
                            <el-button type="text" @click="dialogVisible(true)">修改资料</el-button>
                            <el-dialog title="修改资料" :close-on-click-modal="false" :visible.sync="dialogFormVisible" width="50rem" top="10vh">
                                <ul>
                                    <li>昵称:
                                        <input type="text" v-model="form.nickName" class="input-dialog">
                                    </li>
                                    <li>实名:
                                        <input type="text" v-model="form.realName" class="input-dialog">
                                    </li>
                                    <li>职位:
                                        <input type="text" v-model="form.position" class="input-dialog">
                                    </li>
                                    <li>性别:
                                        <el-select v-model="form.sexName" placeholder="男" style="width:17rem;margin-left: 1.5rem;" size="small">
                                            <el-option label="男" value="男"></el-option>
                                            <el-option label="女" value="女"></el-option>
                                        </el-select>
                                    </li>
                                    <li>生日:
                                        <el-date-picker type="date" placeholder="选择日期" v-model="form.birthday" value-format="yyyy-MM-dd" style="width: 17rem;margin-left: .5rem;padding: 0 0 0 1rem;" size="small"></el-date-picker>
                                    </li>
                                    <li>行业:
                                        <el-select v-model="form.industry" placeholder="请选择" style="width:17rem;margin-left: 1.5rem;" size="small">
                                            <el-option v-for="(item,index) in industrys" :key="item" :label=industrys[index] :value=industrys[index]></el-option>
                                        </el-select>
                                    </li>
                                    <li>地区:
                                        <el-select @change="changeState" v-model="valueSt" placeholder="请选择" style="width:10rem;margin-left: 1.5rem;" size="small">
                                           <el-option v-for="(item,index) in state" :key="index" :label=item.label :value=item.value></el-option>
                                        </el-select>
                                        <el-select @change="changeState" v-model="valuePr" placeholder="请选择" style="width:10rem;margin-left: 1.5rem;" size="small">
                                           <el-option v-for="(item,index) in province" :key="index" :label=item.label :value=item.value></el-option>
                                        </el-select>
                                        <el-select v-model="valueCi" placeholder="请选择" style="width:10rem;margin-left: 1.5rem;" size="small">
                                           <el-option v-for="(item,index) in city" :key="index" :label=item.label :value=item.value></el-option>
                                        </el-select>
                                    </li>
                                    <li style="display: flex;">简介:
                                        <el-input
                                                type="textarea"
                                                placeholder="请输入内容"
                                                v-model="form.introduction"
                                                maxlength="300"
                                                show-word-limit
                                                resize="none"
                                                rows="3"
                                                style="margin-left: 1.7rem;width: 35rem;"
                                        ></el-input>
                                    </li>
                                    </ul>
                                <div slot="footer" class="dialog-footer">
                                    <el-button @click="dialogVisible(false)">取 消</el-button>
                                    <el-button type="primary" @click="dialogVisible(false),submit()">确 定</el-button>
                                </div>
                            </el-dialog>
                        </span>
                    </li>
                    <li>实名: <span>{{form.realName}}</span></li>
                    <li>性别: <span>{{form.sexName}}</span></li>
                    <li>生日: <span>{{form.birthday}}</span></li>
                    <li>地区: <span>{{form.region.state}} {{form.region.province}} {{form.region.city}}</span></li>
                    <li>行业: <span>{{form.industry}}</span></li>
                    <li>职位: <span>{{form.position}}</span></li>
                    <li>简介: <span>{{form.introduction}}</span></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "dataInfo",
        data(){
            return{
                uploadData: {//上传时附带的额外参数
                    id:'',
                },
                dialogFormVisible: false,
                industrys: [ "互联网.电子商务","电子.微电子","批发.零售","贸易.进出口","广告.会展.公关" ],
                valueSt: '',
                valuePr: '',
                valueCi: '',
                state:[{value: 1,label:"中国"},{value: 2,label:"美国"},{value: 3,label:"英国"},{value: 4,label:"法国"},{value: 5,label:"俄罗斯"}],
                province: [],
                city: [],
                form: {
                    id: '',
                    nickName: '',
                    realName: '',
                    position: '',//职位
                    birthday: '',//生日
                    industry: "",//行业
                    sexName: "",
                    region: {
                        state:"",//地区
                        province:"",//省份
                        city:"",//城市
                    },
                    introduction: ''//简介
                },
                formLabelWidth: '120px',
                imageUrl: ''
            }
        },
        methods:{
            dialogVisible(flag){
                return this.dialogFormVisible = flag;
            },
            changeState(){//处理级联数据(目前只做了简单的福建部分地区级联，后期改造方法再做全国的级联)
                if(this.valueSt==1){//省级数据(后期通过接口获取)
                    this.province = [{value: 1,label:"北京"},{value: 2,label:"天津"},{value: 3,label:"福建省"},{value: 4,label:"河北省"},{value: 5,label:"山西省"}];
                }else{
                    this.province = [];
                    this.city = [];
                    this.valuePr = '';
                    this.valueCi = '';
                };
                if(this.valuePr==3){//市级数据(后期通过接口获取)
                    this.city = [{value: 1,label:"福州市"},{value: 2,label:"厦门市"},{value: 3,label:"莆田市"},{value: 4,label:"三明市"},{value: 5,label:"泉州市"}];
                }else{
                    this.city = [];
                    this.valueCi = '';
                }
            },
            getInfo(){//获取个人资料页面信息
                let self = this;
                this.$axios.get('http://localhost/graduation_project/blog2/src/php/personal/getData',{
                    params:{
                        id: self.form.id
                    }
                }).then(function (res) {
                    let personal = res.data;
                    self.form.nickName = personal.nickName;
                    self.form.realName = personal.realName;
                    self.form.sexName = personal.sexName;
                    self.form.birthday = personal.birthday;
                    if(personal.region){
                        self.form.region = JSON.parse(personal.region);
                    }
                    self.form.industry = personal.industry;
                    self.form.position = personal.position;
                    self.form.introduction = personal.introduction;
                    self.imageUrl = personal.avatarUrl;
                    console.log(self.imageUrl);
                }).catch(function (res) {
                    console.log(res);
                });
            },
            screen(value,arr){//筛选级联出来的值
                let result = '';
                if(arr){
                    arr.forEach(item=>{
                        if(item.value == value){
                            result = item.label;
                        }
                    });
                }
                return result;
            },
            submit(){//修改资料/提交
                let self = this;
                //传入级联后的值
                self.form.region.state = this.screen(self.valueSt,self.state);
                self.form.region.province = this.screen(self.valuePr,self.province);
                self.form.region.city = this.screen(self.valueCi,self.city);

                this.$axios.post('http://localhost/graduation_project/blog2/src/php/personal/saveData',{
                    status: 1,//代表修改资料
                    personal_info: self.form
                },{
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个
                }).then(function(res){
                    // console.log(JSON.parse(self.form.region));
                    console.log(res);
                }).catch(function(res){
                    console.log(res);
                });
            },

            // saveImg(imageUrl){ //保存头像
            //     let self = this;
            //     this.$axios.post('http://localhost/graduation_project/blog2/src/php/personal/saveData',{
            //         status: 0,//代表修改头像
            //         avatarUrl: imageUrl,
            //         id: self.form.id
            //     },{
            //         headers: {'Content-Type': 'application/x-www-form-urlencoded'} //加上这个
            //     }).then(function(res){
            //         console.log(res);
            //     }).catch(function(res){
            //         console.log(res);
            //     });
            // },
            //上传头像的两个方法
            handleAvatarSuccess(res, file) {
                this.imageUrl = URL.createObjectURL(file.raw);
                // this.saveImg(this.imageUrl);
                // console.log(this.imageUrl);
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
        mounted() {
            this.form.id = localStorage.getItem('email');//当前登陆id
            this.uploadData.id = this.form.id;
            this.getInfo();
        }
    }
</script>

<style lang="less">
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
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
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
    .avatar {
        width: 10rem;
        height: 10rem;
        border-radius: .3rem;
        display: block;
    }

    .dataChange{display: inline-block;width: 65vw;padding-right: 5rem;
        .bannerTop{font-size: 2rem;color: #3d3d3d;line-height: 9rem;border-bottom: 1px solid #e0e0e0;font-weight: bold;}
        .setUp{display: flex;padding: 2rem 0;text-align: left;width: 100%;
            .avatar{flex: 1;cursor: pointer;
                span{display: inline-block;width: 10rem;height: 10rem;border-radius: 50%;margin-left: 50%;transform: translateX(-50%)}
                div{text-align: center;color: #3399ea;}
            }
            .means{flex: 7;padding-left: 1rem;display: inline-block;width: 100%;background-color: #fff;
                .part1{display: flex;justify-content: space-between;align-items: center;
                    span:nth-child(1){font-size: 1.4rem;color: #999;}
                    span:nth-child(2){color: #3399ea;cursor: pointer;}
                }
                .part2{padding: 1rem 0;font-size: 1.4rem;color: #4D4D4D;border-bottom: 1px solid #e0e0e0;
                    span{padding-right: 2rem;}
                }
                .part3{list-style: none;padding: 1rem 0;
                    li{padding: .8rem 0;font-size: 1.4rem;color: #4D4D4D;
                        &>span{margin-left: 1rem;}
                        &>div>span{margin-left: 1rem;}
                        .el-dialog{
                            ul{padding: 0 2rem;list-style: none;
                                li{font-size: inherit;color: #606266;}
                                .input-dialog{
                                    padding:0 1.5rem;box-sizing:border-box;font-size:1.4rem;color:#4d4d4d;height: 3rem;width:17rem;border-radius: .4rem;border: 1px solid #dcdfe6!important;margin-left: 1.5rem;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>