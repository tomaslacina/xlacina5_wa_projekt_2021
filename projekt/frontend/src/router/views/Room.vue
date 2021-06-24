<template>

  <div class="container md-5">
  <div>
  <center><h4 v-if="room">Welcome in room <b> {{ room.title }} </b> with ID <b> {{ room.id_rooms }} </b></h4></center>
  </div>


  <div>
  <table class="table table-dark">
     <thead>
      <tr>
        <th>Actually in room:</th>
      </tr>
    </thead>
    <tbody class="tbody-warning">
      <tr v-for="user in users" :key="user.id_users">
        <td>{{user['name']}}</td>
      </tr>
    </tbody>
  </table>
  </div>

  <div v-if="owner==true">
      <center><h5>You are owner in this room</h5></center>
      
      <center><form @submit.prevent="deleteRoom">
          <button type="submit" class="btn btn-danger" >Delete this room</button>
      </form></center>
    </div>

    <div v-else>
      <center><h5>You are not owner this room</h5>
      <form @submit.prevent="leaveRoom">
          <button type="submit" class="btn btn-danger" >Leave this room</button>
      </form>
      </center>
    </div>
    <br>


  <div>
  <table class="table table-dark">
    <thead>
      <tr>
        <th>Name and Surname</th>
        <th>message</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="message in messages" :key="message.id_messages">
        <td>{{message['name']}}</td>
        <td>{{message['message']}}</td>
      </tr>
    </tbody>
  </table>
  </div>

  <div>

  <form @submit.prevent="sendMessage">
    <label class="form-label">Message:</label>
    <input type="text" placeholder="Type your message here" onfocus="this.value=''" class="form-control" v-model="message" required/>
    <br>
    <button type="submit" class="btn btn-success">Send message</button>
  </form>
  <br><br>
  </div>

  </div>


</template>

<script>
//import Chat from "./components/Chat";

export default {
  data() {
    return {
      room: null,
      messeges:null,
      users:[],
      message:"",
      owner:null,
      timer: null,
    };
  },
  methods: {

    async fetchRoomDetail(roomId) {
      try {
        const response = await this.$http.get(`/auth/rooms/${roomId}`);
        this.room = response.data;
      } catch (e) {
        this.$router.push({ name: "notFound" });
      }
    },

    async getMessages(roomId){
      try{
        const response = await this.$http.get(`/auth/rooms/getMessages/${roomId}`);
        this.messages=response.data;
      } catch(e){
        this.$router.push({name: "notFound"});
      }
    },

    async sendMessage(roomId){
      try{
        roomId=this.$route.params.id;
        const response = await this.$http.post(`/auth/rooms/sendMessage/${roomId}`,{message:this.message});
        this.messages=response.data;
        this.getMessages(roomId);
        
      } catch(e){
        this.$router.push({name: "notFound"});
      }

    },

    async enterRoom(roomId){
      try{
        roomId = this.$route.params.id;
        const response = await this.$http.post(`/auth/rooms/enterRooms/${roomId}`);
        this.users=response.data;
      }catch (e){
        console.log(e)

      }
    },

    async leaveRoom(roomId){
       try{
        roomId = this.$route.params.id;
        await this.$http.delete(`/auth/rooms/leaveRoom/${roomId}`);
        this.$router.push({name:"rooms"});
      }catch (e){
        console.log(e)

      }
    },

    async isUserOwnerThisRoom(roomId){
      try{
        roomId = this.$route.params.id;
        const response = await this.$http.post(`/auth/rooms/isUserOwner/${roomId}`);
        this.owner=response.data;
        console.log(this.owner)
      }catch (e){
        console.log(e)

      }
    },

    async deleteRoom(roomId){

       try{
        roomId = this.$route.params.id;
        await this.$http.delete(`/auth/rooms/${roomId}`);
        this.$router.push({name:"rooms"});
      }catch (e){
        console.log(e)

      }

    },

    timerRefresh(){

      this.timer = setInterval(()=> {

        this.getMessages(this.$route.params.id)}, 1000);

    }

  },

   created(){

    this.timer1();

   },



   beforeDestroy () {

      clearInterval(this.timer);

   },

  mounted() {

    this.fetchRoomDetail(this.$route.params.id);
    this.getMessages(this.$route.params.id);
    this.enterRoom(this.$route.params.id);
    this.isUserOwnerThisRoom(this.$route.params.id);
  
  
  },
};
</script>
