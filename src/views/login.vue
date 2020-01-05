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
                <el-input v-model="accuount" placeholder="手机号/邮箱/用户名" size="small" maxlength="11"></el-input>
                <el-input v-model="password" placeholder="密码" stext-linkhow-password size="small" maxlength="6"></el-input>
                <a href="#" class="text-link">忘记密码</a>
              </div>
              <div class="input-item" v-show="!isLogin">
                <!--                            .el-select-dropdown__item-->
                <div class="register-number">
                  <el-select v-model="value" placeholder="请选择" size="small" style="width: 120px;" popper-class="select-down">
                    <el-option
                            v-for="item in cities"
                            :key="item.area"
                            :label="item.prefix"
                            :value="item.area">
                      <span style="float: left">{{ item.prefix }}</span>
                      <span style="float: right; color: #8492a6; font-size: 13px">{{ item.area }}</span>
                    </el-option>
                  </el-select>
                  <el-input v-model="accuount" placeholder="手机号/邮箱/用户名" size="small" maxlength="11" style="width: 55%;margin:0;"></el-input>
                </div>
                <el-input v-model="password" placeholder="密码" stext-linkhow-password size="small" maxlength="6"></el-input>
                <a href="#" class="text-link">忘记密码</a>
              </div>
              <router-link to="/index"><el-button size="medium" :disabled="!accuount||!password" :class="{'login-test':(accuount&&password)}">登录</el-button></router-link>
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
      accuount: "",
      password: "",
      cities: [{prefix:"+86",area:"中国"},{prefix:"+1",area:"美国"},{prefix:"+1",area:"加拿大"},{prefix:"+81",area:"日本"},
        {prefix:"+65",area:"新加坡"},{prefix:"+852",area:"中国香港"},{prefix:"+886",area:"中国台湾"},],
      value: "",
    }
  },
  methods: {
    change(flag){
      this.isLogin = flag?true:false;
      this.accuount = "";
      this.password = "";
    }
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
      span{padding: 0 20px;}
      .head-item{display:flex;width: 80%; justify-content:space-around;border-bottom: 2px solid #f5f5f5;cursor: pointer;margin-left: 50%;transform: translateX(-50%)}
      .input-item{margin-top: 30px;
        .el-input{width: 80%;
          &:nth-child(2){margin-top: 20px;}
        }
        .text-link{display:inline-block;margin-top: 20px;width: 80%;text-align: right;text-decoration: none;}
        span{padding: 0!important;}
      }
      .el-button{width: 80%;margin-top: 60px;background-color: #f5f5f5;color: #ccc;}
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
