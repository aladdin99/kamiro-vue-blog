import Vue from "vue";
import VueRouter from "vue-router";
import login from "../views/login.vue";

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
    component: () =>
      import("../views/homePage/index.vue")
  }
];

const router = new VueRouter({
  routes
});

export default router;
