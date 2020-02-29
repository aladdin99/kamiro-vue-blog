import Vue from "vue";
import VueRouter from "vue-router";
import login from "../../views/login.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "login",
    component: login
  },
  {
    path: "/index",
    name: "index",
    component: () => import("../../views/homePage/index.vue"),
    // children: [
    //   {
    //     path: "/index/user",
    //     name: "user",
    //     component: ()=> import("../../views/homePage/user/user.vue")
    //   }
    // ]
    // children:[
    //   {
    //     path: '/',
    //     redirect: "/index/user"
    //   },
    //   {
    //     path: '/index/user',
    //     name: "user",
    //     component: () => import("../../views/homePage/user/user.vue")
    //   }
    // ]
  },
  {
    path: "/index/user",
    name: "user",
    component: () => import("../../views/homePage/user/user.vue"),
  },
  {
    path: "/index/webpage",
    name: "webpage",
    component: () => import("../../views/homePage/webpage.vue"),
  },
  {
    path: "/index/webpage_collect",
    name: "webpage_collect",
    component: () => import("../../views/homePage/webpage_collect.vue"),
  },
  {
    path: "/index/user/details",
    name: "details",
    component: () => import("../../views/homePage/user/details/details.vue"),
  },
  {
    path: "/index/user/sorts",
    name: "sorts",
    component: () => import("../../views/homePage/user/sorts.vue"),
  },
  {
    path: "/personal/index",
    name: "personal",
    component: () => import("../../views/personal/index.vue"),
  },
  {
    path: "/md/mavon",
    name: "mavon",
    component: () => import("../../views/md/mavon.vue"),
  },
  {
    path: "/md/mavon/released",
    name: "released",
    component: () => import("../../views/md/released.vue"),
  },
  {
    path: "/manage/managing",
    name: "managing",
    component: () => import("../../views/manage/managing.vue"),
  },
  {
    path: "/settings/account_settings",
    name: "settings",
    component: () => import("../../views/settings/account_settings"),
  },
];

const router = new VueRouter({
  routes
});

export default router;
