<template>
  <div id="app"> 
    <navbar :user="user" @logout="onLogout"></navbar>
  

  <div class="mt-4">
    <router-view></router-view>
  </div>
  </div>
</template>

<script>

import Navbar from "./components/Navbar";





export default {
  name: 'App',
  components: {
    navbar: Navbar,   //prvni je nazev co pouziju v template, druhe je nazev komponenty xxx.vue   navbar: Navbar  / lze to i takto jen Navbar                 
  },
  data:()=>{
    return {
      user:{
        login:"xlacina5",
        id:"2",
      },
    };
  },
  methods:{
    onLogout(){
      this.user=null;
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
