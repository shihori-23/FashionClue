<template>
    <header>
        <router-link
            v-if="$route.path === '/user/home'"
            :to="{ name: 'UserHome' }"
        >
            <img :src="'img/logo.png'" height="64px" />
        </router-link>
        <p
            v-else-if="$route.path === '/user/bookmark'"
            class="body-1 text-center font-weight-bold"
        >
            ブックマーク
        </p>
        <p
            v-else-if="$route.path === '/user/post'"
            class="body-1 text-center font-weight-bold"
        >
            投稿
        </p>
        <p
            v-else-if="$route.path === '/user/notice'"
            class="body-1 text-center font-weight-bold"
        >
            通知
        </p>
        <p
            v-else-if="$route.path === '/user/profile'"
            class="body-1 text-center font-weight-bold"
        >
            マイページ
        </p>
        <router-link
            v-else-if="$route.path === '/user/setting'"
            :to="{ name: 'UserProfile' }"
            class="header_wrap"
        >
            <span class="pev_icon"><i class="fas fa-angle-left"></i></span>
            <span class="body-1 text-center font-weight-bold pev_left"
                >プロフィール編集</span
            >
        </router-link>
        <router-link v-else :to="{ name: 'UserHome' }">
            <span class="pev_icon"><i class="fas fa-angle-left"></i></span>
        </router-link>

        <!-- <div class="header_icon">
            <v-btn icon>
                <v-icon @click="logout">mdi-logout</v-icon>
            </v-btn>
        </div> -->
    </header>
</template>
<script>
export default {
    data() {
        return {
            name: "Fashion Clue"
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
                    location.href = "/fashionclue";
                })
                .catch(err => console.log(err));
        }
    }
};
</script>
<style lang="scss" scoped>
a {
    text-decoration: none;
}

header {
    width: 100%;
    position: fixed;
    height: 56px;
    background: #ffffff;
    box-shadow: 0px 1px 5px #f0eff0;
    /* display: flex;
    justify-content: space-between; */
    margin-bottom: 56px;
    padding: 8px 8px;
    z-index: 9000;

    .body-1 {
        color: "#6c6c6c";
        margin: 0;
        vertical-align: middle;
        line-height: 40px;
        color: #6c6c6c;
    }
}

.logo {
    color: #6c6c6c;
}

.header_wrap {
    display: flex;
    justify-content: flex-start;

    .pev_left {
        margin: 0 15%;
    }
}

.pev_icon {
    color: #6c6c6c;
    font-size: 32px;
    margin-left: 16px;
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
