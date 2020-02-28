<template>
    <v-app>
        <Header />
        <div class="router">
        <transition>
            <router-view></router-view>
        </transition>
        </div>
        <v-snackbar v-model="snackbar" :timeout="timeout">
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
    // this.getUid();
  },
  methods: {
    // getUid: function() {
    //   axios
    //     .get("api/uid")
    //     .then(res => {
    //       let role = res.data.role;
    //       if (role === 2) {
    //         this.$router.push({ name: "CharismaHome" });
    //       } else {
    //         this.snackbar = true;
    //       }
    //     })
    //     .catch(err => console.log(err));
    // }
  }
};
</script>

<style scoped>
.router {
  margin-top: 56px;
}
</style>