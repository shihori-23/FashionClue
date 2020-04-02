<template>
  <div>
    <div class="container">
      <button class="btn-border" v-if="!isBookmarked" @click="BookmarkOperationAtClick">
        <span class="lnr lnr-heart"></span>
        <!-- <v-icon>mdi-heart-outline</v-icon> -->
      </button>
      <button class="btn-border" v-else @click="removeBookmarkOperationAtClick">
        <span class="lnr lnr-heart isBookmarkedIcon"></span>
        <!-- <v-icon color="#fbadff">mdi-heart</v-icon> -->
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    answer_id: Number,
    isBookmarked: Boolean
  },
  data() {
    return {};
  },
  methods: {
    BookmarkOperationAtClick() {
      this.$emit("add-answer-bookmark");
    },
    removeBookmarkOperationAtClick() {
      this.$emit("remove-answer-bookmark");
    }
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
</style>
