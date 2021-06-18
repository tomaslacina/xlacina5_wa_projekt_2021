<template>
    <div class="navbar">
        <h1>CHAT APP</h1>
        <div v-if="user !=null">
            <h2> Ahoj {{user.login}} </h2>
            <button @click="logout"> LOGOUT</button>
        </div>

        <div v-else>
            <button>LOGIN</button>
            <button>REGISTER</button>
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