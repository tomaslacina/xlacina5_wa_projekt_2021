<template>
  <div class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link :to="{ name: 'home' }" class="navbar-brand">Chat App</router-link>
      <div v-if="user != null">
        <h5>Hi user with ID {{ user.userId }}</h5>
        <button @click="logout">Logout</button>
      </div>
      <ul v-else class="navbar-nav">
        <li class="nav-item">
          <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">Login</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">Register</router-link>
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
  },
};
</script>

<style>

.navbar{
    background:green;
    padding: 20px 40px;
    color: black;
    font-weight:700;
}

</style>