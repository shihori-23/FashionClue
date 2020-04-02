<template>
  <div class="wrap">
    <v-container class="main_profile">
      <!-- <h2 class="subtitle-1">プロフィール</h2> -->
      <v-card class="mx-auto profileCard" flat>
        <v-list-item>
          <v-list-item-avatar size="56">
            <img :src="userProfileData.image" alt="ユーザーのアイコン画像" />
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="title">{{ userProfileData.name }}</v-list-item-title>
            <v-list-item-subtitle>
              <Gender :genderRole="userProfileData.gender" class="caption" />
              <span v-if="userProfileData.age" class="caption">/ {{ userProfileData.age }}歳</span>
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>

        <v-card-text class="bioTextWrap">
          <p class="caption">自己紹介</p>
          <p v-if="userProfileData.bio" class="bioText">{{ userProfileData.bio }}</p>
          <span v-if="selectedTastes">
            <v-chip
              v-for="(selectedTaste , index) in selectedTastes"
              :key="index"
              class="ma-1"
              small
              dark
              color="#bc8f8f"
            ># {{ selectedTastes[index]}}</v-chip>
          </span>
        </v-card-text>

        <div class="text-center">
          <div>
            <v-btn text color="#8c8c8c" :to="{ name: 'UserSetting'}">プロフィールを編集する</v-btn>
          </div>
          <v-btn text color="#bc8f8f" @click="logout">ログアウト</v-btn>
        </div>
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
            v-for="(post,index) in userPostData"
            :key="index"
            :to="{ name: 'UserPostDetail' , params: { postId: post.post_id }}"
          >
            <v-list-item>
              <v-list-item-avatar size="36">
                <img :src="userProfileData.image" />
              </v-list-item-avatar>

              <v-list-item-content class="list_title_wrap">
                <v-list-item-title class>{{ userProfileData.name }}</v-list-item-title>
                <v-list-item-subtitle class="caption">
                  <Gender :genderRole="userProfileData.gender" />
                  <span v-if="userProfileData.age">/ {{ userProfileData.age }}歳</span>
                </v-list-item-subtitle>
                <span v-if="post.category_name" class="categoryChip">
                  <v-chip
                    class="ma-1 category_chips"
                    small
                    outlined
                    color="#a0a0a0"
                  >{{ post.category_name }}</v-chip>
                </span>
              </v-list-item-content>
            </v-list-item>
            <v-card-text class="px-4 pb-4 pt-0 textColor">{{post.text}}</v-card-text>
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
            v-for="(answer,index) in userAnswerData"
            :key="index"
            :to="{ name: 'UserPostDetail' , params: { postId: answer.post_id }}"
          >
            <v-list-item>
              <v-list-item-avatar size="36">
                <v-img :src="userProfileData.image"></v-img>
              </v-list-item-avatar>
              <v-list-item-content class="list_title_wrap">
                <v-list-item-title class>{{ userProfileData.name }}</v-list-item-title>
                <v-list-item-subtitle class="caption">
                  <Gender :genderRole="userProfileData.gender" />
                  <span v-if="userProfileData.age">/ {{ userProfileData.age }}歳</span>
                </v-list-item-subtitle>
                <span v-if="answer.category_name" class="categoryChip">
                  <v-chip
                    class="ma-1 category_chips"
                    small
                    outlined
                    color="#a0a0a0"
                  >{{ answer.category_name }}</v-chip>
                </span>
              </v-list-item-content>
            </v-list-item>
            <v-card-text class="px-4 pb-4 pt-0 textColor">{{answer.text}}</v-card-text>
            <v-img v-if="answer.answer_image" :src="answer.answer_image"></v-img>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </div>
</template>

<script>
import Gender from "../items/GenderComponent";

export default {
  components: {
    Gender
  },
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
      tabConfigurations: {
        tab: null,
        centered: true,
        grow: true
      },
      userProfileData: {},
      userPostData: {},
      userAnswerData: {},
      selectedTastes: []
    };
  },
  created() {},
  mounted() {
    this.getUserProfileData();
  },
  methods: {
    //プロフィールの取得
    getUserProfileData: function() {
      axios
        .get("api/profile/show")
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
        .catch(err => console.log(err));
    },
    //　テイストタグのデータを配列に入れる処理
    selectedTasteConvert: function(res) {
      const selectedTasteArray = res.data.selectedTastes;
      const selectedtasteList = selectedTasteArray
        .map(function(row) {
          return [row["taste_name"]];
        })
        .reduce(function(a, b) {
          return a.concat(b);
        });
      this.selectedTastes = selectedtasteList;
      console.log(this.selectedTastes);
    },
    //　ログアウト
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
p {
  margin-bottom: 0px;
}
.main_profile {
  padding: 8px 0;
}
.profileCard {
  padding: 8px 16px;
}
.v-tabs-items {
  background-color: #dddddd;
}
.list_title_wrap {
  position: relative;

  .category_chips {
    position: absolute;
    top: 8px;
    right: 0;
  }
}
.bioTextWrap {
  padding: 8px 16px 0px;
  font-size: 0.8em;
}
.bioText {
  margin-bottom: 8px;
  font-size: 0.8em;
}

.tabBar {
  position: sticky;
  top: 56px;
  z-index: 100;
}
.userContentCard {
  margin-bottom: 8px;
}

.textColor {
  color: #222 !important;
}
</style>