<template>
  <div class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link :to="{ name: 'home' }" class="navbar-brand">CHAT APP</router-link>
       
      <div v-if="user!=null">
        <h5>Logged-in user with login <b> {{user.login}} </b> , your ID is <b> {{ user.userId }} </b> </h5>
      </div>

      <div v-if="user != null">
        
        <div> 
        <router-link :to="{ name: 'rooms' }" class="navbar-brand"><button class="btn btn-primary">ROOMS</button></router-link>
        <button @click="logout" class="btn btn-danger" >LOGOUT</button>
        </div>

      
       
      </div>
      <ul v-else class="navbar-nav">
        <li class="nav-item">
          <router-link :to="{ name: 'login' }" class="nav-link" active-class="active"><button class="btn btn-success">LOGIN</button></router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'register' }" class="nav-link" active-class="active"><button class="btn btn-warning">REGISTER</button></router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: false,
    },
    logoutFn: Function,
  },

  methods: {
    logout() {
      this.$emit("logout");
    },
}}

</script>

<style>

.navbar{
    background:green;
    padding: 20px 40px;
    color: black;
    font-weight:700;
}

</style>