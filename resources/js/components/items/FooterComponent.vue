    <template>
  <footer>
    <router-link :to="{ name: 'UserHome'}">
      <v-btn icon>
        <span class="lnr lnr-home footericon"></span>
        <!-- <i class="fas fa-home"></i> -->
      </v-btn>
    </router-link>
    <router-link :to="{ name: 'UserBookmark'}">
      <v-btn icon>
        <span class="lnr lnr-bookmark footericon"></span>
        <!-- <i class="far fa-bookmark"></i> -->
      </v-btn>
    </router-link>
    <router-link :to="{ name: 'UserPost'}">
      <v-btn icon>
        <span class="lnr lnr-plus-circle footericon"></span>
        <!-- <i class="far fa-edit"></i> -->
      </v-btn>
    </router-link>
    <router-link :to="{ name: 'UserNotice'}">
      <v-btn icon @click="isVisibleNoctice = false">
        <v-badge :value="isVisibleNoctice" overlap dot color="#bc8f8f">
          <span class="lnr lnr-alarm footericon"></span>
          <!-- <i class="far fa-bell"></i> -->
        </v-badge>
      </v-btn>
    </router-link>
    <router-link :to="{ name: 'UserProfile'}">
      <v-btn icon>
        <span class="lnr lnr-user footericon"></span>
        <!-- <i class="fas fa-user"></i> -->
      </v-btn>
    </router-link>
  </footer>
</template>
<script>
export default {
  data() {
    return {
      isVisibleNoctice: false
    };
  },
  created() {
    this.getNoticeData();
  },
  mounted() {},
  methods: {
    getNoticeData: function() {
      axios
        .get("api/notice")
        .then(res => {
          console.log(res.data.notice);
          if (res.data.notice == 0) {
            this.isVisibleNoctice = false;
          } else {
            this.isVisibleNoctice = true;
          }
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

footer {
  position: fixed;
  bottom: 0;
  /* background: #ffcc99; */
  background: #fff;
  box-shadow: 1px 1px 5px #f0eff0;
  width: 100%;
  height: 56px;
  display: flex;
  justify-content: space-between;
  padding: 14px 24px;
  z-index: 9000;

  .footericon {
    font-size: 24px;
  }
}

i {
  font-size: 24px;
  /* font-weight: 200; */
}

i:hover {
  color: #bc8f8f;
}

.mdi-bookmark-outline {
  font-size: 32px;
}
</style>