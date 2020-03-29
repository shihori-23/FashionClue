<template>
  <v-container class="main_container">
    <p>お気に入り</p>
    <v-tabs
      v-model="tabConfigurations.tab"
      :centered="tabConfigurations.centered"
      :grow="tabConfigurations.grow"
      color="black"
      flat
    >
      <!-- <v-tabs-slider></v-tabs-slider> -->
      <v-tab href="#posts">Posts</v-tab>
      <v-tab href="#answers">Answer</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tabConfigurations.tab">
      <v-tab-item value="posts">
        <v-card
          class="bookmarkedCard"
          flat
          tile
          outlined
          ripple
          v-for="(bookmarkedPost,index) in bookmarkedPostsData"
          :key="index"
          :to="{ name: 'UserPostDetail' , params: { postId: bookmarkedPost.id }}"
        >
          <v-list-item>
            <v-list-item-avatar size="36">
              <v-img :src="bookmarkedPost.image"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class>
                {{ bookmarkedPost.name }}
                <span
                  v-if="bookmarkedPost.category_name"
                  class="categoryChip"
                >
                  <v-chip class="ma-1" x-small>{{ bookmarkedPost.category_name }}</v-chip>
                </span>
              </v-list-item-title>
              <v-list-item-subtitle>
                <Gender :genderRole="bookmarkedPost.gender" />
                <span v-if="bookmarkedPost.age">{{ bookmarkedPost.age }}歳</span>
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-card-text>{{bookmarkedPost.text}}</v-card-text>
          <v-img v-if="bookmarkedPost.post_image" :src="bookmarkedPost.post_image"></v-img>
        </v-card>
      </v-tab-item>

      <v-tab-item value="answers">
        <v-card
          class="bookmarkedCard"
          flat
          tile
          outlined
          ripple
          v-for="(bookmarkedAnswer,index) in bookmarkedAnswersData"
          :key="index"
          :to="{ name: 'UserPostDetail' , params: { postId: bookmarkedAnswer.post_id }}"
        >
          <v-list-item>
            <v-list-item-avatar size="36">
              <v-img :src="bookmarkedAnswer.image"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class>
                {{ bookmarkedAnswer.name }}
                <span
                  v-if="bookmarkedAnswer.category_name"
                  class="categoryChip"
                >
                  <v-chip class="ma-1" x-small>{{ bookmarkedAnswer.category_name }}</v-chip>
                </span>
              </v-list-item-title>
              <v-list-item-subtitle>
                <Gender :genderRole="bookmarkedAnswer.gender" />
                <span v-if="bookmarkedAnswer.age">{{ bookmarkedAnswer.age }}歳</span>
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-card-text>{{bookmarkedAnswer.text}}</v-card-text>
          <v-img v-if="bookmarkedAnswer.answer_image" :src="bookmarkedAnswer.answer_image"></v-img>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-container>
</template>
<script>
import Gender from "../items/GenderComponent";

export default {
  components: {
    Gender
  },
  /**
   *
   * @param {Object} tabConfigurations・・・・・・・タブに関する設定を管理
   * @param {Object} bookmarkedPostsData・・・お気に入りした質問投稿のデータを管理
   * @param {Object} bookmarkedAnswersData・・・お気に入りした回答のデータを管理
   * @param {Array} gender・・・性別のデータを管理
   *
   **/
  data() {
    return {
      tabConfigurations: {
        tab: null,
        centered: true,
        grow: true
      },
      bookmarkedPostsData: {},
      bookmarkedAnswersData: {}
      //   gender: ['女性', '男性'],
    };
  },

  created() {
    this.isBookmarkedPostsDataGet();
    this.isBookmarkedAnswersDataGet();
  },
  methods: {
    isBookmarkedPostsDataGet: function() {
      axios
        .get("api/post_bookmark/get")
        .then(res => {
          console.log(res.data.bookmarkedPostsData);
          const bookmarkedPostDataObj = res.data.bookmarkedPostsData;
          this.bookmarkedPostsData = bookmarkedPostDataObj;
          this.bookmarkedPostsData.gender = parseInt(
            bookmarkedPostDataObj.gender
          );
        })
        .catch(err => {
          console.log(err);
        });
    },
    isBookmarkedAnswersDataGet: function() {
      axios
        .get("api/answer_bookmark/get")
        .then(res => {
          console.log(res.data.bookmarkedAnswersData);
          this.bookmarkedAnswersData = res.data.bookmarkedAnswersData;
          this.bookmarkedAnswersData.gender = parseInt(
            res.data.bookmarkedAnswersData.gender
          );
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>

<style scoped>
.main_container {
  width: 100%;
  padding: 16px 0;
}

.elevation-2 {
  width: 100%;
}

.bookmarkedCard {
  width: 100%;
  /* margin: 8px auto; */
  margin-bottom: 16px;
}

.genderSpan {
  margin-right: 8px;
}
</style>