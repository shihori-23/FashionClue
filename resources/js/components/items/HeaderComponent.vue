<template>
    <header>
        <router-link
            v-if="$route.path === '/user/home'"
            :to="{ name: 'UserHome' }"
        >
            <!-- <img :src="'img/logo.png'" height="64px" /> -->
            <h1 class="logo-title">Clue</h1>
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
            <span class="pev_icon">
                <span class="lnr lnr-chevron-left"></span>
            </span>
            <span class="body-1 text-center font-weight-bold pev_left"
                >プロフィール編集</span
            >
        </router-link>
        <router-link v-else :to="{ name: 'UserHome' }">
            <span class="pev_icon">
                <span class="lnr lnr-chevron-left"></span>
            </span>
        </router-link>
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

.logo-title {
    font-family: "Montserrat", "Noto Sans JP", sans-serif;
    color: #6c6c6c;
    text-align: left;
    font-size: 1.2em;
    letter-spacing: 10px;

    padding: 8px 16px;
}

.header_wrap {
    display: flex;
    justify-content: flex-start;

    .pev_left {
        margin-left: 20%;
    }
}

.pev_icon {
    color: #6c6c6c;
    font-size: 24px;
    line-height: 40px;
    margin-left: 8px;
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
    color: #996666;
}
</style>
