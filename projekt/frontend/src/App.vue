<template>
  <div id="app">
    <h1>CHAT APP</h1>
    <navbar></navbar>
  </div>
</template>

<script>

import Navbar from "./components/Navbar";



export default {
  name: 'App',
  components: {
    navbar: Navbar   //prvni je nazev co pouziju v template, druhe je nazev komponenty xxx.vue
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
