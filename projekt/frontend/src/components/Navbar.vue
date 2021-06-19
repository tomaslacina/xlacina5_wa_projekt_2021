<template>
    <div class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <router-link :to="{name:'home'}" class="navbar-brand">Chat app</router-link>
            
            <div v-if="user !=null">
                <h2> Ahoj {{user.login}} </h2>
                <button @click="logout"> LOGOUT</button>
            </div>

        <ul v-else class="navbar-nav">
            <li class="nav-item">
                <router-link :to="{name: 'login'}" class="nav-link" active-class="active">Login</router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{name: 'register'}" class="nav-link" active-class="active">Register</router-link>
            </li>
        </ul>
        </div>
    </div>
</template>



<script>
    export default {
        //props:["login"], //zakladni zapis
        //dalsi zapis:
        props:{
           // login:String    //[String, Boolean, Array,... - lze i vic tipu]
            user: {
                type: Object,
                required:false,
            },
        },
        
        methods:{
            logout(){
                this.$emit("logout")
            },
        },
    };


</script>

<style>

.navbar{
    background:green;
    padding: 20px 40px;
    color: white;
    font-weight:700;
}

</style>