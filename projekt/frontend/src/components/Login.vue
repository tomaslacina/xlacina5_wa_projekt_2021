<template>
<div> 
    <h3>Login</h3>
   
    <form @submit.prevent="doLogin">
       <input type="text" v-model="login">
       <input type="password" v-model="password">
       
       <button type="submit">Login</button>
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