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
    path: "/index/user/details",
    name: "details",
    component: () => import("../../views/homePage/user/details/details.vue"),
  },
  {
    path: "/personal/index",
    name: "personal",
    component: () => import("../../views/personal/index.vue"),
  },
  {
    path: "/md/blogging",
    name: "personal",
    component: () => import("../../views/md/blogging.vue"),
  },
];

const router = new VueRouter({
  routes
});

export default router;
