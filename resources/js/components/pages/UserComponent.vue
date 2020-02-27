<template>
    <v-app>
        <!-- <UserHeader /> -->
        <div class="router">
        <transition name="slide" mode="out-in">
            <router-view></router-view>
        </transition>
        </div>
        <v-snackbar v-model="snackbar" :timeout="timeout">
        ログインしました
        <v-btn color="blue" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <!-- <UserFooter /> -->
    </v-app>
</template>
<script>
// import UserHeader from "../component/header";
// import UserFooter from "../component/footer";
export default {
  components: {
    // UserHeader,
    // UserFooter
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
.slide-enter-active {
  transition: all .3s ease;
}
.slide-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-enter, .slide-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>