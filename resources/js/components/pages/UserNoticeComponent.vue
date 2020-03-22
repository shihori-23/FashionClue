<template>
  <v-container>
    <p>通知</p>

  </v-container>
</template>
<script>

export default {
  components: {

  },
  data() {
    return {
    };
  },

  created() {
    this.getNoticeData();

  },
  methods: {
    getNoticeData: function(){
      axios.get('api/get/notice')
      .then(res => {
        console.log(res.data);
      })
      .catch(err => console.log(err));
      
    },
  }
};
</script>

<style scoped>
</style>