<template>
    <header>    
        <router-link :to="{ name: 'UserHome'}">
        <h1 class="title-1 logo">{{ name }}</h1>
        </router-link>
        <div class="header_icon">
        <v-btn icon>
            <v-icon @click="logout">mdi-logout</v-icon>
        </v-btn>
        </div>

    </header>
</template>
<script>
export default {
    data() {
        return {
            name:'Fashion Clue'
        };
    },
    created() {
        // this.push();
    },
    mounted() {
        // this.repush();
    },
    methods: {
        logout: function() {
        axios
            .post("logout")
            .then(res => {
            location.href = "/";
            })
            .catch(err => console.log(err));
        },
        // push: function() {
        //   axios
        //     .get("api/user/header/push", {})
        //     .then(res => {
        //       // console.log(res.data.notice);
        //       this.count = res.data.notice;
        //       if (res.data.notice == 0) {
        //         this.isPushed = false;
        //       } else {
        //         this.isPushed = true;
        //       }
        //     })
        //     .catch(err => console.log(err));
        // },
        // repush: function() {
        //   setInterval(() => {
        //     axios
        //       .get("api/user/header/push/interval")
        //       .then(res => {
        //         this.count = res.data.notice;
        //         if (res.data.notice == 0) {
        //           this.isPushed = false;
        //         } else {
        //           this.isPushed = true;
        //         }
        //       })
        //       .catch(error => console.log(error));
        //   }, 60000);
        // }
    }
    };
</script>
<style scoped>
    a {
    text-decoration: none;
    }

    header {
    width: 100%;
    position: fixed;
    height: 56px;
    background: #ffffff;
    box-shadow: 0px 1px 5px #f0eff0;
    display: flex;
    justify-content: space-between;
    margin-bottom: 56px;
    padding: 14px 8px;
    z-index: 9000;  
    }

    .logo {
    color: #6c6c6c;
    }

    .header_icon {
    display: flex;
    justify-content: right;
    }

    .v-btn--icon.v-size--default {
    height: 32px;
    width: 32px;
    }

    .v-icon {
    font-size: 32px !important;
    }

    .v-icon:hover {
    color: #bc8f8f;
    }

</style>