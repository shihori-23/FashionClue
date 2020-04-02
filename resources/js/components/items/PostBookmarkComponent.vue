<template>
  <div>
    <div class="container">
      <button class="btn-border" v-if="!isBookmarked" @click.prevent="BookmarkOperationAtClick">
        <span class="lnr lnr-heart"></span>
        <!-- <v-icon>mdi-heart-outline</v-icon> -->
      </button>
      <button class="btn-border" v-else @click.prevent="removeBookmarkOperationAtClick">
        <span class="lnr lnr-heart isBookmarkedIcon"></span>
        <!-- <v-icon color="#ed4956">mdi-heart</v-icon> -->
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    post_id: Number,
    isBookmarked: Boolean
  },
  data() {
    return {
      originIsBookmarked: this.isBookmarked
    };
  },
  methods: {
    BookmarkOperationAtClick() {
      this.$emit("add-post-bookmark");
    },
    removeBookmarkOperationAtClick() {
      this.$emit("remove-post-bookmark");
    }
    //一旦残しておきます！
    // addBookmark(id) {
    // axios
    //     .post("api/post/post_bookmark/" + id)
    //     .then(res => {
    //     console.log(res.data.isBookmarked);
    //     this.originIsBookmarked = true;
    //     })
    //     .catch(err => console.log(err));
    // },

    // removeBookmark(id) {
    // axios
    //     .post("api/destory/post_bookmark/" + id)
    //     .then(res => {
    //     console.log(res.data.isBookmarked);
    //     this.originIsBookmarked = false;
    //     })
    //     .catch(err => console.log(err));
    // }
    //一旦残しておきます！
  }
};
</script>
<style scoped>
a {
  text-decoration: none;
}

.isBookmarkedIcon {
  color: #ed4956;
}

.btn-border {
  font-size: 24px;
}
</style>
