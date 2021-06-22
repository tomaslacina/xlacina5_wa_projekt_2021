<template>
    <div class="container">
        <h3>Register</h3>

         <div v-if="error" class="alert alert-danger">
            {{ error }}
          </div>

            <form @submit.prevent="register">
                <div>
                    <label class="form-label">Login</label>
                    <input type="text" v-model="login" class="form-control" placeholder="your_login" required/>
                </div>

                <div>
                    <label class="form-label">Password</label>
                    <input type="password" v-model="password" class="form-control" required />
                </div>

                 <div>
                    <label class="form-label">E-mail</label>
                    <input type="email" v-model="email" class="form-control" placeholder="example@yourmail.com" required/>
                </div>               

                <div>
                    <label class="form-label">Name</label>
                    <input type="text" v-model="name" class="form-control" placeholder="Thomas"/>
                </div>

                <div>
                    <label class="form-label">Surname</label>
                    <input type="text" v-model="surname" class="form-control" placeholder="Hacker" />
                </div>

                <div>
                    <label class="form-label">Gender</label>
                    <input type="text" v-model="gender" class="form-control" placeholder="Male, Female, Other">
                 </div>

                <div>
                    <label class="form-label">Role</label>
                    <input type="text" v-model="role" class="form-control" placeholder="Student"/>
                </div>
                <br>



      <button type="submit" class="btn btn-primary">Register</button>
    </form>
        
        
        
        
    </div>


</template>


<script>
export default {
  data: () => {
    return {
      login: "",
      email:"",
      password: "",
      name:"",
      surname:"",
      gender:"",
      role:"",
      error: null,
    };
  },
  methods: {
    async register() {
      this.error = null;
      // async, await
      try {
        const response = await this.$http.post("/register", { login: this.login, password: this.password, email: this.email, name: this.name, surname: this.surname, gender: this.gender, role: this.role });
        const{token}=response.data;
        this.$tokenManager.setToken(token);
        this.$router.push({ name: "login" });
      } catch (e) {
        this.error = "Email or login already exists in databases / login must be created with a-z,A-Z,1-9, spaces";
      }
    },
  },
};
</script>
