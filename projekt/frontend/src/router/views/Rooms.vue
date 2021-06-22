<template>
  <div class="container">


    <form @submit.prevent="createNewRoom"> 
      <input type="text" placeholder="Type name of new room" onfocus="this.value=''" class="form-control" v-model="title"/>
      <br>
      <button type="submit" class="btn btn-success">Create new room</button>
    </form>
    <br>

    <h3>Room list:</h3>
    <div class="row">
      <div class="col" v-for="room in rooms" :key="room.id_rooms">
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">{{ room.title }}</h5>
            <h6 class="card-title">Zamčeno:{{room.lock}}</h6>
            <router-link :to="{ name: 'room', params: { id: room.id_rooms } }" class="btn btn-primary">
              Enter
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      rooms: [],
    };
  },
  methods: {
    async loadAllRooms() {
      try {
        const response = await this.$http.get("/auth/rooms");
        this.rooms = response.data;
      } catch (e) {
        console.error("nastala chyba", e);
      }
    },
  

    async createNewRoom(){
      try{
        const response = await this.$http.post("/auth/rooms", {title: this.title});
        this.rooms=response.data;
        this.loadAllRooms();
      }catch(e){
        console.error("nastala chyba", e);
      }

    },
  },
  mounted() {
    this.loadAllRooms();
  },
};
</script>