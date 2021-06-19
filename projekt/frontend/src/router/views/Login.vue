<template>
<div> 
    <h3>Login</h3>
   
    <form @submit.prevent="doLogin">
        <div>
            <label class="form-label">Login</label>
            <input type="text" v-model="login" class="form-control">
            
         </div>   

         <div>
             <label class="form-label">Password</label>
             <input type="password" v-model="password" class="form-control">

        </div>

        <div v-if="error" class="alert alert-danger" >
            {{error}}
        </div>

       
       <button type="submit" class="btn-primary">Login</button>
    </form>
</div>



</template>


<script>
    
    export default{
        data:()=>{
            return{
                login:"",
                password:"",
                error:null,
            };
        },
        methods:{
            async doLogin(){     
                this.error=null;
                
                //1. zpusob:
                
                //this.$http.post("/login",{login: this.login, password: this.password})
                //.then((data)=>console.log(data))
                //.catch(()=>console.log("promise failed"))
                //.finally(()=>console.log("finally"))

                //2. zpusob:

                try{
                   const response = await this.$http.post("/login",{login: this.login, password: this.password});
                   const{token}=response.data;
                   console.log(token);
                   this.$router.push({name:"rooms"})


                }catch(e){
                    console.error(e)
                    this.error="Wrong credentials";

                }

            },
        }
    };

</script>