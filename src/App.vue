<template>
  <div id="app">
      <!--      <router-link to="/">Home</router-link> |-->
      <!--      <router-link to="/about">About</router-link>  -->
    <router-view />
  </div>
</template>

<style lang="less">
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  /*padding: 30px;*/
    a{
        text-decoration: none;
        color: #2c3e50;
    }
}

html {font-size: 62.5%; *{margin: 0;padding: 0;}}
body {
    font-size: 1.4rem;color: #4d4d4d;font-family: SF Pro Display,Roboto,Noto,Arial,PingFang SC,Hiragino Sans GB,Microsoft YaHei,"sans-serif";
}
</style>
