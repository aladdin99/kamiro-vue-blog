import Vue from "vue";
import App from "./App.vue";
import router from "./router/homePage";
import store from "./store";

import axios from 'axios';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import IconSvg from './components/icon-components';
import mditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css'

Vue.config.productionTip = false;
Vue.prototype.$axios = axios;
Vue.use(ElementUI);
Vue.use(mditor);
Vue.component('icon-svg', IconSvg)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
