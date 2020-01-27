<template>
  <div class="login">
    <div id="nav">
      <el-container style="height: 80vh;">
        <el-main style="display: flex;justify-content:center;">
          <el-card class="box-left">
            <el-carousel trigger="click" style="margin-top: 15px;">
              <el-carousel-item v-for="item in 4" :key="item">
                <h3 class="small">{{ item }}</h3>
              </el-carousel-item>
            </el-carousel>
            <div>
              <el-divider></el-divider>
              <span>青春是一个短暂的美梦, 当你醒来时, 它早已消失无踪</span>
            </div>
          </el-card>
          <el-card class="box-right">
            <div class="box-inner">
              <div class="head-item">
                <span :class="{login:isLogin}" @click="change(true)">账号登录</span>
                <span :class="{login:!isLogin}" @click="change(false)">注册登录</span>
              </div>
              <div class="input-item" v-show="isLogin">
                <el-input v-model="registerData.email" placeholder="手机号/邮箱/用户名" size="small" type="email"></el-input>
                <el-input v-model="registerData.pass" placeholder="密码" stext-linkhow-password size="small" maxlength="6"></el-input>
                <a href="#" class="text-link">忘记密码</a>
              </div>
              <div class="input-item" v-show="!isLogin">
                <el-form :model="registerData" ref="registerData" label-width="100px" class="demo-dynamic">
                <el-form-item
                        prop="name"
                        label="昵称"
                        hide-required-asterisk="true"
                        :rules="[
                { required: true, message: '请输入昵称', trigger: 'blur' },
                ]"
                >
                  <el-input v-model="registerData.name" size="small"></el-input>
                </el-form-item>
                <el-form-item
                      prop="email"
                      label="邮箱"
                      :rules="[
                { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] }
                ]"
                >
                    <el-input v-model="registerData.email" size="small"></el-input>
                </el-form-item>
                <el-form-item
                      label="密码"
                      prop="pass"
                      :rules="[
                { required: true, message: '请输入密码', trigger: 'blur' },
                ]"
                >
                  <el-input type="password" v-model="registerData.pass" autocomplete="off" size="small"></el-input>
                </el-form-item>
                </el-form>
                <a href="#" class="text-link" v-show="isLogin" >忘记密码</a>
              </div>
<!--              <router-link to="/index">-->
                <el-button size="medium" :disabled="!registerData.email||!registerData.pass"
                           :class="{'login-test':(registerData.email&&registerData.pass)}" v-show="isLogin"  @click="login">登录</el-button>
<!--              </router-link>-->
                <el-button size="medium" v-show="!isLogin" :disabled="!registerData.email||!registerData.pass||!registerData.name"
                           :class="{'login-test':(registerData.email&&registerData.pass&&registerData.name)}" @click="register">注册</el-button>
            </div>
            <div><el-divider content-position="right">不信戳进来看</el-divider></div>
          </el-card>
        </el-main>
      </el-container>
    </div>
    <el-divider></el-divider>
    <el-footer>
      关于我们
      <div>
        <span>雨纷纷</span>
        <el-divider direction="vertical"></el-divider>
        <span>旧故里</span>
        <el-divider direction="vertical"></el-divider>
        <span>草木深</span>
      </div>
    </el-footer>
<!--    <img alt="Vue logo" src="../assets/logo.png" />-->
<!--    <HelloWorld msg="Welcome to Your Vue.js App" />-->
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from "@/components/HelloWorld.vue";

export default {
  name: "login",
  components: {
    // HelloWorld
  },
  data() {
    return {
      isLogin: true,
      registerData: {
          email: '',
          name: '',
          pass: ''
      }
    }
  },
  methods: {
    change(flag){   //登录/注册切换标识
      this.isLogin = flag?true:false;
      this.registerData.email = "";
      this.registerData.pass = "";
      this.registerData.name = "";
    },
    register(){// Get请求_账号注册
      let self = this;
      this.$axios.get('http://localhost/graduation_project/blog2/src/php/register',{
          params: {
              email: this.registerData.email,
              password: this.registerData.pass,
              nickName: this.registerData.name
          }
      }).then(function(res){
        if(res.data.status){
          alert("该账号已存在!");
        }else{
          alert("已发送验证链接到您的邮箱~");
          self.change(true);
        }
      }).catch(function(res){
        console.log(res);
      });
    },
    login(){// Get请求_账号登录
      let self = this;
      this.$axios.get('http://localhost/graduation_project/blog2/src/php/login',{
        params: {
          email: self.registerData.email,
          password: self.registerData.pass,
        }
      }).then(function(res){
        console.log(res.data.isLogin);//0:密码错误;1:验证成功;-1:账号不存在
        if(res.data.isLogin==1){//验证成功
          this.$router.push({
            path:'./index',
            // 路由传参(此处数据暂时没有用到)
            query: {
              // name: obj[i].name,
              email: this.registerData.email,
              // password: obj[i].password
            }
          })
        }
      }).catch(function(res){
        console.log(res);
      });
    },
    submitForm(formName) {//表单验证
      this.$refs[formName].validate((valid) => {
          if (valid) {
              alert('submit!');
          } else {
              console.log('error submit!!');
              return false;
          }
      });
    },
  },
  mounted() {
    this.change(true);
  }
};
</script>

<style lang="less">
  #nav {
    /*padding: 30px;*/
    a{
      text-decoration: none;
      color: #2c3e50;
    }
  }

  .box-left{
    height: 60vh;width:60vh;margin-top: 5vh;margin-right: 15px;
    .el-carousel__item h3 {color: #475669;font-size: 14px;opacity: 0.75;line-height: 150px;margin: 0;}
    .el-carousel__item:nth-child(2n) {background-color: #99a9bf;}
    .el-carousel__item:nth-child(2n+1) {background-color: #d3dce6;}
  }
  .box-right{
    height: 60vh;width:60vh;margin-top: 5vh;margin-left: 15px;
    .box-inner{
      width:80%;margin-left:50%;transform:translateX(-50%);padding:5% 0;
      span{padding: 0 2rem;}
      .head-item{display:flex;width: 80%; justify-content:space-around;border-bottom: 2px solid #f5f5f5;cursor: pointer;margin-left: 50%;transform: translateX(-50%)}
      .input-item{margin-top: 30px;
        .register{padding: 1.5rem 0;}
        .el-input{width: 80%;
          &:nth-child(2){margin-top: 2rem;}
        }
        .text-link{display:inline-block;margin-top: 2rem;width: 80%;text-align: right;text-decoration: none;}
        span{padding: 0!important;}
      }
      .el-button{width: 80%;margin-top: 5rem;background-color: #f5f5f5;color: #ccc;}
      .login-test{color: #fff;background-color: #ca0c16;}
      .register-number{
        display:flex;width: 80%;margin-left: 50%;transform: translateX(-50%);
      }
    }
  }
  .login{
    border-bottom: 2px solid #ca0c16;
  }
</style>
