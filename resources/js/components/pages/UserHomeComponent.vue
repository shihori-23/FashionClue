<template>
  <v-container class="mainWrap">
    <v-tabs
      v-model="tabConfigurations.tab"
      :centered="tabConfigurations.centered"
      :grow="tabConfigurations.grow"
      color="#808080"
      flat
      class="tabBar"
      >
        <v-tab href="#lady">Lady's</v-tab>
        <v-tab href="#men">Men's</v-tab>
      </v-tabs>

      <v-tabs-items v-model="tabConfigurations.tab">
        <v-tab-item value=lady>
          <v-card
            class="postContentCard"
            flat
            tile
            outlined
            ripple
            v-for="(ladysPost,index) in ladysPostsData" :key="index"
            :to="{ name: 'UserPostDetail' , params: { postId: ladysPost.post_id }}"
          > 
            <v-list-item>
              <v-list-item-avatar size=36>
                <img :src="ladysPost.image"/>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title class="">{{ ladysPost.name }}
                  <span v-if="ladysPost.category" class="categoryChip">
                    <v-chip class="ma-1" x-small>{{ ladysPost.category }}</v-chip>
                  </span>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <span class="genderSpan">{{ gender[ladysPost.gender] }}</span>
                  <span v-if="ladysPost.age">{{ ladysPost.age }}歳</span>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-card-text>{{ladysPost.text}}</v-card-text>
            <v-img v-if="ladysPost.post_image" :src="ladysPost.post_image"></v-img>
            <v-card-actions class="iconWrap">
              <PostBookmarkComponent v-if="postBookmarkedId.includes(parseInt(ladysPost.post_id))" @remove-post-bookmark="removePostBookmark(ladysPost.post_id)" :post_id="parseInt(ladysPost.post_id)" :isBookmarked="true" />
              <PostBookmarkComponent v-else @add-post-bookmark="addPostBookmark(ladysPost.post_id)" :post_id="parseInt(ladysPost.post_id)" :isBookmarked="false"/>
              <span class="commentIcon"><i class="far fa-comment"></i></span><span class="caption captionColor">{{ladysPost.answer_count}}</span>
              <span class="caption captionColor data">{{ ladysPost.created_at }}</span>
            </v-card-actions>
          </v-card>
        </v-tab-item>

        <v-tab-item value="men">
          <v-card
            class="postContentCard"
            flat
            tile
            outlined
            ripple
            v-for="(mensPost,index) in mensPostsData" :key="index"
            :to="{ name: 'UserPostDetail' , params: { postId: mensPost.post_id }}"
          >
            <v-list-item>
              <v-list-item-avatar size=36><v-img :src="mensPost.image"></v-img></v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title class="">{{ mensPost.name }}
                  <span v-if="mensPost.category" class="categoryChip">
                    <v-chip class="ma-1" x-small>{{ mensPost.category }}</v-chip>
                  </span>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <span class="genderSpan">{{ gender[mensPost.gender] }}</span>
                  <span v-if="mensPost.age">{{ mensPost.age }}歳</span>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-card-text>{{mensPost.text}}</v-card-text>
            <v-img v-if="mensPost.post_image" :src="mensPost.post_image"></v-img>
            <v-card-actions class="iconWrap">
              <PostBookmarkComponent v-if="postBookmarkedId.includes(parseInt(mensPost.post_id))" @remove-post-bookmark="removePostBookmark(mensPost.post_id)" :post_id="parseInt(mensPost.post_id)" :isBookmarked="true" />
              <PostBookmarkComponent v-else @add-post-bookmark="addPostBookmark(mensPost.post_id)" :post_id="parseInt(mensPost.post_id)" :isBookmarked="false"/>
              <span class="commentIcon"><i class="far fa-comment"></i></span><span class="caption commentCaption">{{mensPost.answer_count}}</span>
              <span class="caption captionColor data">{{ mensPost.created_at }}</span>
            </v-card-actions>
          </v-card>
        </v-tab-item>
      </v-tabs-items>

  </v-container>
</template>
<script>

import PostBookmarkComponent from "../items/PostBookmarkComponent"

export default {
  components: {
    PostBookmarkComponent,
  },
  /**
  *
  * @param {Object} tabConfigurations・・・・・タブバーの設定を管理
  * @param {Array} gender・・・・・・・・・・・・性別データを管理
  * @param {Object} ladysPostsData・・・・・・・レディース分の質問投稿のデータを管理
  * @param {Object} mensPostsData・・・・・・・メンズ分の質問投稿のデータを管理
  * @param {Array} postBookmarkedId・・・・・・ログインユーザーがお気に入りしたpost_idを管理

  *
  **/
  data() {
    return {
      tabConfigurations:{
        tab: null,
        centered: true,
        grow: true,
      },
      gender:["レディース","メンズ"],
      ladysPostsData:{},
      mensPostsData:{},
      postBookmarkedId:[],
    };
  },

  created() {
    this.getPostsData();
  },
  methods: {
    getPostsData: function(){
      axios
        .get("api/get/home")
        .then(res => {
          const axiosGetData = res.data;
          this.ladysPostsData = axiosGetData.ladysPostsData;
          this.mensPostsData = axiosGetData.mensPostsData;
          this.postBookmarkedId = axiosGetData.postBookmarkedId;
          console.log(res.data);
        })
        .catch(err => console.log(err.response.data));
    },
    //質問投稿に対するお気に入りの登録
    addPostBookmark: function(id){
      axios
        .post("api/post/post_bookmark/" + id)
        .then(res => {
          console.log(res.data.isBookmarked);
          const postBookmarkIdArray = [];
          postBookmarkIdArray.push(id);
          this.postBookmarkedId= postBookmarkIdArray;
          console.log(this.postBookmarkedId);
        })
        .catch(err => console.log(err));
    }, 
    //質問投稿に対するお気に入りの削除
    removePostBookmark: function(id){
      axios
        .post("api/destory/post_bookmark/" + id)
        .then(res => {
        const postBookmarkIdArray = [];
        this.postBookmarkedId = postBookmarkIdArray;
        console.log(this.postBookmarkedId);
        })
        .catch(err => console.log(err));
    },
  }
};
</script>

<style scoped>
.mainWrap{
  padding:8px 0 56px;
}

p{
  margin-bottom: 0px;
}

.tabBar{
  position: sticky;
  top: 56px;
  z-index: 100;
}

.postContentCard{
  margin-bottom: 16px; 
}

.iconWrap{
  position: relative;

}

.commentIcon{
  font-size:24px;
  color:#808080;
  padding:12px 6px 12px 12px;
}

.captionColor{
  color: #808080;
}

.data{
  position: absolute;
  right:16px;
}
</style>