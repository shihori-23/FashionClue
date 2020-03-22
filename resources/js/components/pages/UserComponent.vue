<template>
    <v-app>
        <Header />
        <div class="router">
            <router-view></router-view>
        </div>
        <v-snackbar v-model="snackbar" :timeout="timeout" class="snackbar">
        ログインしました
        <v-btn color="blue" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <Footer />
    </v-app>
</template>
<script>
import Header from "../items/HeaderComponent";
import Footer from "../items/FooterComponent";
export default {
  components: {
    Header,
    Footer
  },
  data() {
    return {
      snackbar: false,
      timeout: 2000
    };
  },

  created() {
    this.getUid();
  },
  mounted(){

  },
  methods: {
    getUid: function() {
      axios
        .get("api/uid")
        .then(res => {
          console.log(res.data.uid);
          this.snackbar = true;
        })
        .catch(err => console.log(err));
    },
  }
};
</script>

<style scoped>
.router {
  margin-top: 56px;
}
.snackbar{
  margin-bottom:56px;
  z-index: 200;
}
</style>