import Vue from 'vue';
import App from './App.vue';
import router from "./router";
import axiosInstance from "./code/http";

Vue.config.productionTip = false;

Vue.prototype.$http = axiosInstance;

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
