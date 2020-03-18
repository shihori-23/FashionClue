<template>
  <div class="wrap">
    <v-container class="main_profile">
      <!-- <h2 class="subtitle-1">プロフィール</h2> -->
      <v-card
        class="mx-auto profileCard"
        flat
      >
        <v-list-item>
          <v-list-item-avatar size=56><img :src="userProfileData.image" alt="ユーザーのアイコン画像"></v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="title">{{ userProfileData.name }}</v-list-item-title>
            <v-list-item-subtitle>
              <span class="caption">{{gender[userProfileData.gender]}}</span>
              ・<span v-if="userProfileData.age" class="caption">{{ userProfileData.age }}歳</span>
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>


        <v-card-text class="bioTextWrap">
          <p>自己紹介</p>
          <p v-if="userProfileData.bio" class="bioText">{{ userProfileData.bio }}</p>
          <span v-if="selectedTastes">
            <v-chip v-for="(selectedTaste , index) in selectedTastes" :key="index" class="ma-1" small dark color="#bc8f8f"># {{ selectedTastes[index]}}</v-chip>
          </span>
        </v-card-text>

        <v-card-actions class="text-center">
          <v-btn
            text
            block
            color="#bc8f8f"
            :to="{ name: 'UserSetting'}"
          >
            プロフィールを編集する
          </v-btn>
        </v-card-actions>
      </v-card>

      <v-tabs
      v-model="tabConfigurations.tab"
      :centered="tabConfigurations.centered"
      :grow="tabConfigurations.grow"
      color="#808080"
      flat
      class="tabBar"
      >
        <v-tab href="#posts">Posts</v-tab>
        <v-tab href="#answers">Answer</v-tab>
      </v-tabs>

      <v-tabs-items v-model="tabConfigurations.tab">
        <v-tab-item value="posts">
          <v-card
            class="userContentCard"
            flat
            tile
            outlined
            ripple
            v-for="(post,index) in userPostData" :key="index"
            :to="{ name: 'UserPostDetail' , params: { postId: post.post_id }}"
          > 
            <v-list-item>
              <v-list-item-avatar size=36>
                <img :src="userProfileData.image"/>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title class="">{{ userProfileData.name }}
                  <span v-if="post.category_name" class="categoryChip">
                    <v-chip class="ma-1" x-small>{{ post.category_name }}</v-chip>
                  </span>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <span class="genderSpan">{{ gender[userProfileData.gender] }}</span>
                  <span v-if="userProfileData.age">{{ userProfileData.age }}歳</span>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-card-text>{{post.text}}</v-card-text>
            <v-img v-if="post.post_image" :src="post.post_image"></v-img>
          </v-card>
        </v-tab-item>

        <v-tab-item value="answers">
          <v-card
            class="userContentCard"
            flat
            tile
            outlined
            ripple
            v-for="(answer,index) in userAnswerData" :key="index"
            :to="{ name: 'UserPostDetail' , params: { postId: answer.post_id }}"
          >
            <v-list-item>
              <v-list-item-avatar size=36><v-img :src="userProfileData.image"></v-img></v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title class="">{{ userProfileData.name }}
                  <span v-if="answer.category_name" class="categoryChip">
                    <v-chip class="ma-1" x-small>{{ answer.category_name }}</v-chip>
                  </span>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <span class="genderSpan">{{ gender[userProfileData.gender] }}</span>
                  <span v-if="userProfileData.age">{{ userProfileData.age }}歳</span>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-card-text>{{answer.text}}</v-card-text>
            <v-img v-if="answer.answer_image" :src="answer.answer_image"></v-img>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-container>

  </div>
</template>

<script>
export default {
  data() {
  /**
  *
  * @param {Object} tabConfigurations・・・タブバーの設定を管理
  * @param {Object} userProfileData・・・ユーザーのプロフィールデータを管理
  * @param {Object} userPostData・・・ユーザーのプロフィールデータを管理
  * @param {Object} userAnswerData・・・ユーザーのプロフィールデータを管理
  * @param {Array} gender・・・性別データを管理
  * @param {Array} selectedTastes・・・選択済のテイストを管理
  * @param {Array} axiosErrorMessages・・・DB側のバリデーションエラーを受け取る
  *
  **/

    return {
      tabConfigurations:{
        tab: null,
        centered: true,
        grow: true,
      },
      userProfileData: {},
      userPostData:{},
      userAnswerData:{},
      gender: ['レディース', 'メンズ'],
      selectedTastes:[],
    };
  },
  created() {
  },
  mounted() {
      this.getUserProfileData();
  },
  methods: {
    //プロフィールの取得
    getUserProfileData: function() {
      axios
        .get("api/show/profile")
        .then(res => {
          const resData = res.data;
          const userProfileData = resData.profile;
          this.userProfileData = userProfileData;
          this.userProfileData.gender = parseInt(userProfileData.gender);
          this.selectedTastes = resData.selectedTastes;
          this.userPostData = resData.userPostData;
          this.userAnswerData = resData.userAnswerData;
          console.log(res.data);
          this.selectedTasteConvert(res);
        })
        .catch(err => console.log(err.response.data));
    },
    //　テイストタグのデータを配列に入れる処理
    selectedTasteConvert: function(res) {
        const selectedTasteArray = res.data.selectedTastes;
        const selectedtasteList = selectedTasteArray.map(function(row){
        return [ row["taste_name"] ]
        }).reduce(function(a,b){
          return a.concat(b);
        });
        this.selectedTastes = selectedtasteList;
        console.log(this.selectedTastes);  
    },
  }
};
</script>

<style scoped>
p{
  margin-bottom: 0px;
}
.main_profile{
  padding: 8px 0;
}
.profileCard{
  padding:8px 16px;

}
.bioTextWrap{
  padding:8px 16px 0px;
  font-size:0.8em;
}
.bioText{
  margin-bottom:8px;
  font-size:0.7em;
}
.tabBar{
  position: sticky;
  top: 56px;
  z-index: 100;
}
.userContentCard{
  margin-bottom: 16px; 
}

</style>