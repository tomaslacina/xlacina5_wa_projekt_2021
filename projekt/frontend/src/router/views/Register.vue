<template>
    <div class="container">
        <h3>Register</h3>

            <form @submit.prevent="registration">
                <div>
                    <label class="form-label">Login</label>
                    <input type="text" v-model="login" class="form-control" placeholder="your_login"/>
                </div>

                <div>
                    <label class="form-label">Password</label>
                    <input type="password" v-model="password" class="form-control" />
                </div>

                 <div>
                    <label class="form-label">E-mail</label>
                    <input type="email" v-model="email" class="form-control" placeholder="example@yourmail.com"/>
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
                    <label class="form-label">Gender: </label>
                    <input type="radio" id="male" name="gender" value="male"> male
                    
                    <input type="radio" id="female" name="gender" value="female"> female
                    
                    <input type="radio" id="other" name="gender" value="other"> other
                    
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
      password: "",
      error: null,
    };
  },
  methods: {
    async register() {
      this.error = null;

      // async, await
      try {
        await this.$http.post("/register", { login: this.login, password: this.password, email: this.email, name: this.name, surname: this.surname, gender: this.gender, role: this.role });
        console.log(this.login);
        this.$router.push({ name: "login" });
      } catch (e) {
        this.error = "User with this email or this login already exists! Please try-it again";
      }
    },
  },
};
</script>
