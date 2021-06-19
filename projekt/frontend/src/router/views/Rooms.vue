<template>
    <div>
        <h3>Rooms</h3>
        <router-link v-for="room in rooms" :key="room.id_rooms" tag="div" :to="{name:'room', params:{id:room.id_rooms}}">
            <h3>{{room.title}}</h3>
        </router-link>
    </div>
</template>

<script>
    export default{

        data(){
        return{
            rooms:[]
        }
    },

    methods:{
       async loadAllRooms(){

            try{
                const response = await this.$http.get("/auth/rooms");
                console.log(response);
                this.rooms = response.data;

            }catch(e){
                console.error("Nastala chyba",e);

            }
            
        },

    },

    mounted(){
        this.loadAllRooms();
    },
    
    }


</script>