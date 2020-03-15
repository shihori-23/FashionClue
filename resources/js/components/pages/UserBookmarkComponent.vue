<template>
  <v-container>
      <p>お気に入り</p>
      <v-tabs
      v-model="tabConfigurations.tab"
      class="elevation-2"
      :centered="tabConfigurations.centered"
      :grow="tabConfigurations.grow"
      >
      <v-tabs-slider></v-tabs-slider>
        <v-tab href="#posts">Posts</v-tab>
        <v-tab href="#answers">Answer</v-tab>
      </v-tabs>

      <v-tabs-items v-model="tabConfigurations.tab">
        <v-tab-item value="posts">
          <v-card
            flat
            tile
            v-for="(bookmarkedPost,index) in bookmarkedPostsData" :key="index"
          > 
            <v-card-text>投稿に対するお気に入り</v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item value="answers">
          <v-card
            flat
            tile
            v-for="(bookmarkedAnswer,index) in bookmarkedAnswersData" :key="index"
          >
            <v-card-text>回答に対するお気に入り</v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
  </v-container>
</template>
<script>

export default {
  components: {

  },
  /**
  *
  * @param {Object} tabConfigurations・・・・・・・タブに関する設定を管理
  * @param {Object} bookmarkedPostsData・・・お気に入りした質問投稿のデータを管理
  * @param {Object} bookmarkedAnswersData・・・お気に入りした回答のデータを管理
  *
  **/
  data() {
    return {
      tabConfigurations:{
        tab: null,
        centered: true,
        grow: false,
      },
      bookmarkedPostsData:{},
      bookmarkedAnswersData:{},
    };
  },

  created() {
    this.isBookmarkedPostsDataGet();
    this.isBookmarkedAnswersDataGet();
  },
  methods: {
    isBookmarkedPostsDataGet: function(){
      axios
        .get("api/get/post_bookmark")
        .then(res => {
          console.log(res.data.bookmarkedPostsData);
          this.bookmarkedPostsData = res.data.bookmarkedPostsData;
        })
        .catch(err => {
          console.log(err);
          }) 
    },
    isBookmarkedAnswersDataGet:　function(){
      axios
        .get("api/get/answer_bookmark")
        .then(res => {
          console.log(res.data.bookmarkedAnswersData);
          this.bookmarkedAnswersData = res.data.bookmarkedAnswersData;
        })
        .catch(err => {
          console.log(err);
        }) 
    },

  }
};
</script>

<style scoped>
</style>