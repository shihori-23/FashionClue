    <template>
    <footer>
        <router-link :to="{ name: 'UserHome'}">
        <v-btn icon>
            <i class="fas fa-home"></i>
            <!-- <v-icon>mdi-home-outline</v-icon> -->
        </v-btn>
        </router-link>
        <router-link :to="{ name: 'UserBookmark'}">
        <v-btn icon>
            <i class="far fa-bookmark"></i>
        </v-btn>
        </router-link>
        <router-link :to="{ name: 'UserPost'}">
        <v-btn icon>
            <i class="far fa-edit"></i>
        </v-btn>
        </router-link>
        <router-link :to="{ name: 'UserNotice'}">
        <v-btn icon>
            <i class="far fa-bell"></i>
            <!-- <v-icon>mdi-bookmark-outline</v-icon> -->
        </v-btn>
        </router-link>
        <router-link :to="{ name: 'UserSetting'}">
        <v-btn icon>
            <i class="fas fa-user"></i>
            <!-- <v-icon>mdi-settings</v-icon> -->
        </v-btn>
        </router-link>
    </footer>
</template>
<style scoped>
    a {
        text-decoration: none;
    }

    footer {
        position: fixed;
        bottom: 0;
        /* background: #ffcc99; */
        background: #fff;
        box-shadow: 1px 1px 5px #F0Eff0;
        width: 100%;
        height: 56px;
        display: flex;
        justify-content: space-between;
        padding: 14px 24px;
        z-index: 9000;
    }

    i {
        font-size: 24px;
    }

    i:hover {
        color:#bc8f8f;
    }
</style>