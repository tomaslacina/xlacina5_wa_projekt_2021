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
            };
        },
        methods:{
            doLogin(){
                console.log(this.login, this.password);

            },
        }
    };

</script>