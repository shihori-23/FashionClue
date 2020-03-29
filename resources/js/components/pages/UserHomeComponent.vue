<template>
  <v-container class="mainWrap">
    <v-dialog v-model="isDialogOpen.errorDialog" width="400">
      <v-card>
        <v-card-title class="headline lighten-2" primary-title>Error</v-card-title>
        <v-card-text>
          <p
            v-for="(message, index) in axiosErrorMessages"
            :key="index"
          >{{ axiosErrorMessages[index] }}</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#bc8f8f" text @click="closeDialog('errorDialog')">閉じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card v-if="isNotificationOpen" outlined flat max-width="93%" class="notificationCard">
      <v-card-text class="notificationText">
        プロフィールの登録が完了していません。
        <br />設定ページより登録お願いします。
      </v-card-text>
      <v-card-actions>
        <v-btn text color="#bc8f8f" :to="{ name: 'UserSetting' }">プロフィール登録ページへ移動</v-btn>
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
      <v-tab href="#lady">Lady's</v-tab>
      <v-tab href="#men">Men's</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tabConfigurations.tab">
      <v-tab-item value="lady">
        <v-card
          class="postContentCard"
          flat
          tile
          outlined
          ripple
          v-for="(ladysPost, index) in ladysPostsData"
          :key="index"
          :to="{
                        name: 'UserPostDetail',
                        params: { postId: ladysPost.post_id }
                    }"
        >
          <v-list-item>
            <v-list-item-avatar size="36">
              <img :src="ladysPost.image" />
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title class>
                {{ ladysPost.name }}
                <span v-if="ladysPost.category_name" class="categoryChip">
                  <v-chip class="ma-1" x-small>
                    {{
                    ladysPost.category_name
                    }}
                  </v-chip>
                </span>
              </v-list-item-title>
              <v-list-item-subtitle>
                <Gender :genderRole="ladysPost.gender" />
                <span v-if="ladysPost.age">{{ ladysPost.age }}歳</span>
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-card-text>{{ ladysPost.text }}</v-card-text>
          <v-img v-if="ladysPost.post_image" :src="ladysPost.post_image"></v-img>
          <v-card-actions class="iconWrap">
            <PostBookmarkComponent
              v-if="
                                postBookmarkedId.includes(
                                    parseInt(ladysPost.post_id)
                                )
                            "
              @remove-post-bookmark="
                                removePostBookmark(ladysPost.post_id)
                            "
              :post_id="parseInt(ladysPost.post_id)"
              :isBookmarked="true"
            />
            <PostBookmarkComponent
              v-else
              @add-post-bookmark="
                                addPostBookmark(ladysPost.post_id)
                            "
              :post_id="parseInt(ladysPost.post_id)"
              :isBookmarked="false"
            />
            <span class="commentIcon">
              <i class="far fa-comment"></i>
            </span>
            <span class="caption captionColor">
              {{
              ladysPost.answer_count
              }}
            </span>
            <MomentJs :time="ladysPost.created_at" class="caption captionColor data" />
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
          v-for="(mensPost, index) in mensPostsData"
          :key="index"
          :to="{
                        name: 'UserPostDetail',
                        params: { postId: mensPost.post_id }
                    }"
        >
          <v-list-item>
            <v-list-item-avatar size="36">
              <v-img :src="mensPost.image"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class>
                {{ mensPost.name }}
                <span v-if="mensPost.category_name" class="categoryChip">
                  <v-chip class="ma-1" x-small>
                    {{
                    mensPost.category_name
                    }}
                  </v-chip>
                </span>
              </v-list-item-title>
              <v-list-item-subtitle>
                <Gender :genderRole="mensPost.gender" />
                <span v-if="mensPost.age">{{ mensPost.age }}歳</span>
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-card-text>{{ mensPost.text }}</v-card-text>
          <v-img v-if="mensPost.post_image" :src="mensPost.post_image"></v-img>
          <v-card-actions class="iconWrap">
            <PostBookmarkComponent
              v-if="
                                postBookmarkedId.includes(
                                    parseInt(mensPost.post_id)
                                )
                            "
              @remove-post-bookmark="
                                removePostBookmark(mensPost.post_id)
                            "
              :post_id="parseInt(mensPost.post_id)"
              :isBookmarked="true"
            />
            <PostBookmarkComponent
              v-else
              @add-post-bookmark="
                                addPostBookmark(mensPost.post_id)
                            "
              :post_id="parseInt(mensPost.post_id)"
              :isBookmarked="false"
            />
            <span class="commentIcon">
              <i class="far fa-comment"></i>
            </span>
            <span class="caption commentCaption">
              {{
              mensPost.answer_count
              }}
            </span>
            <MomentJs :time="mensPost.created_at" class="caption captionColor data" />
          </v-card-actions>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-container>
</template>
<script>
import PostBookmarkComponent from "../items/PostBookmarkComponent";
import MomentJs from "../items/MomentJs";
import Gender from "../items/GenderComponent";
import Mixin from "../../mixin";

export default {
  components: {
    PostBookmarkComponent,
    MomentJs,
    Gender
  },
  /**
  *
  * @param {Object} tabConfigurations・・・・・タブバーの設定を管理
  * @param {Object} isNotificationOpen・・・・・性別登録がない場合に表示するお知らせの表示非表示を管理
  * @param {Array} gender・・・・・・・・・・・・性別データを管理
  * @param {Array} filledUserGender・・・・・・性別の登録情報を管理
  * @param {Object} ladysPostsData・・・・・・・レディース分の質問投稿のデータを管理
  * @param {Object} mensPostsData・・・・・・・メンズ分の質問投稿のデータを管理
  * @param {Array} postBookmarkedId・・・・・・ログインユーザーがお気に入りしたpost_idを管理

  *
  **/
  data() {
    return {
      tabConfigurations: {
        tab: "",
        centered: true,
        grow: true
      },
      isNotificationOpen: false,
      gender: ["レディース", "メンズ"],
      userGenderData: [],
      ladysPostsData: {},
      mensPostsData: {},
      postBookmarkedId: []
    };
  },
  mixins: [Mixin],
  created() {
    this.getPostsData();
  },
  methods: {
    //　質問投稿のデータを取得
    getPostsData: function() {
      axios
        .get("api/get/home")
        .then(res => {
          const axiosGetData = res.data;
          this.ladysPostsData = axiosGetData.ladysPostsData;
          this.mensPostsData = axiosGetData.mensPostsData;
          this.postBookmarkedId = axiosGetData.postBookmarkedId;
          this.filledUserGender(res);
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
    //性別の登録があるか判断
    filledUserGender: function(res) {
      const userGender = parseInt(res.data.userGenderData);
      if (userGender == 0) {
        this.tabConfigurations.tab = "lady";
        console.log("ログインしている人はレディースだよ");
      } else if (userGender == 1) {
        this.tabConfigurations.tab = "men";
        console.log("ログインしている人はメンズだよ");
      } else {
        this.isNotificationOpen = true;
      }
      this.userGenderData = userGender;
    },
    //質問投稿に対するお気に入りの登録
    addPostBookmark: function(id) {
      axios
        .post("api/post_bookmark/post/" + id)
        .then(res => {
          console.log(res.data.isBookmarked);
          this.postBookmarkedId.push(id);
        })
        .catch(err => {
          this.setBookmarkAxiosErrorData(err);
          console.log(err);
        });
    },
    //質問投稿に対するお気に入りの削除
    removePostBookmark: function(id) {
      axios
        .post("api/post_bookmark/destory/" + id)
        .then(res => {
          const order = this.postBookmarkedId.findIndex(item => item == id);
          this.postBookmarkedId.splice(order, 1);

          console.log(this.postBookmarkedId);
        })
        .catch(err => {
          this.setBookmarkAxiosErrorData(err);
          console.log(err);
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.mainWrap {
  padding: 8px 0 56px;
}

.notificationCard {
  margin: 0 auto;
}

.notificationText {
  padding-bottom: 0px;
}

p {
  margin-bottom: 0px;
}

.tabBar {
  position: sticky;
  top: 56px;
  z-index: 100;
}

.postContentCard {
  margin-bottom: 16px;
}

.iconWrap {
  position: relative;
}

.commentIcon {
  font-size: 24px;
  color: #808080;
  padding: 12px 6px 12px 12px;
}

.captionColor {
  color: #808080;
}

.data {
  position: absolute;
  right: 16px;
}
</style>
