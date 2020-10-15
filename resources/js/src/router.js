/*
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
*/

import Vue from "vue";
import Router from "vue-router";
Vue.use(Router);

const router = new Router({
  mode: "history",
  base: "/",
  routes: [
    // Partials Layout
    {
      path: "/",
      component: () => import("./layouts/Main.vue"),
      children: [
        {
          name: "home",
          path: "/"
        },
      ]
    },
    {
      path: "/error-404",
      name: "pageError404",
      component: () => import("./pages/Error404.vue")
    },
    // Redirect to 404 page, if no match found
    {
      path: "*",
      redirect: "/error-404"
    }
  ]
});


export default router;
