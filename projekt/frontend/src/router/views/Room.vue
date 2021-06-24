<template>

  <div class="container md-5">
  <div>
  <h4 v-if="room">Welcome! This is room {{ room.title }} with ID {{ room.id_rooms }}</h4>
  </div>

  <h4> Actualy in room:</h4>
  <div v-for="user in users" :key="user.id_user">
    <h4>{{user['name']}}</h4>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>name</th>
        <th>message</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="message in messages" :key="message.id_messages">
        <td>{{message['name']}}</td>
        <td>{{message['message']}}</td>
        <td></td>
      </tr>
    </tbody>
  </table>

  <form @submit.prevent="sendMessage">
    <label class="form-label">Message:</label>
    <input type="text" placeholder="Type your message here" onfocus="this.value=''" class="form-control" v-model="message"/>
    <button type="submit" class="btn btn-success">Send message</button>
  </form>

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
    };
  },
  methods: {

    async fetchRoomDetail(roomId) {
      try {
        const response = await this.$http.get(`/auth/rooms/${roomId}`);
        this.room = response.data;
      } catch (e) {
        // todo poriesit stav ked je zadane neplatne ID miestnosti
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

    }

  },
  mounted() {
    this.fetchRoomDetail(this.$route.params.id);
    this.getMessages(this.$route.params.id)
  },
};
</script>
