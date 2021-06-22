<template>
  <div class="container md-5">
  <h4 v-if="room">Welcome! This is room {{ room.title }} with ID {{ room.id_rooms }}</h4>
  </div>
</template>

<script>
//import Chat from "./components/Chat";

export default {
  data() {
    return {
      room: null,
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
  },
  mounted() {
    this.fetchRoomDetail(this.$route.params.id);
  },
};
</script>
