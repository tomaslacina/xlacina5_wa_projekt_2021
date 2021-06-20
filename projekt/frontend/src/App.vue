<template>
  <div id="app">
    <navbar :user="user" @logout="onLogout" :logoutFn="onLogout"> </navbar>

    <div class="mt-4">
      <router-view @userLogged="onUserLog"></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from "./components/Navbar";

export default {
  name: "App",
  components: {
    Navbar,
  },
  data: () => {
    return {
      user: null,
    };
  },
  methods: {
    onUserLog(userData) {
      this.user = userData;
    },
    onLogout() {
      this.user = null;
      this.$tokenManager.logout();
      this.$router.push({ name: "home" });
    },
  },
  mounted(){
    this.user = this.$tokenManager.getPayload()
  }
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
