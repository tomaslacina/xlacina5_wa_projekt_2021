<template>
  <div class="container">
    <h3>Login</h3>
    <form @submit.prevent="doLogin">
      <div>
        <label class="form-label">Login</label>
        <input type="text" v-model="login" class="form-control" />
      </div>

      <div>
        <label class="form-label">Password</label>
        <input type="password" v-model="password" class="form-control" />
      </div>

      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      login: "",
      password: "",
      error: null,
    };
  },
  methods: {
    async doLogin() {
      this.error = null;

      // resolve a reject

      // then-catch - callbacky
      // this.$http.post("/login", { login: this.login, password: this.password })
      //   .then((data) => console.log(data))
      //   .catch(() => console.log("promise failed"))
      //   .finally(() => console.log("finally"))

      // async, await
      try {
        const response = await this.$http.post("/login", { login: this.login, password: this.password });
        const { token } = response.data;

        this.$tokenManager.setToken(token);

        this.$emit("userLogged", this.$tokenManager.getPayload());

        this.$router.push({ name: "rooms" });
      } catch (e) {
        this.error = "Wrong credentials";
      }
    },
  },
};
</script>
