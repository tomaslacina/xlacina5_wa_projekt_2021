import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import axiosInstance from "./code/http";
import TokenManager from "./code/token-manager";

Vue.config.productionTip = false;

Vue.prototype.$http = axiosInstance;

export const tokenManager = new TokenManager();
tokenManager.renew();

Vue.prototype.$tokenManager = tokenManager;

new Vue({
  router,
  render: (h) => h(App),
}).$mount("#app");

