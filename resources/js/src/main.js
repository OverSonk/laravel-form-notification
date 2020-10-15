/*
  File Name: main.js
  Description: main vue(js) file
*/

import Vue from "vue";
import App from "./App.vue";
import { _ } from "lodash";

// Custom var
const { appName } = window.config;

Vue.prototype.appName = appName;

// Vue Router
import router from "./router";

// HasError

import { HasError } from "vform";
Vue.component(HasError.name, HasError);

new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
