<template>
  <div class="wrap">
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

      <div class="mx-auto postCard card" max-width="344" outlined>
        <v-list-item>
          <v-list-item-avatar size="48">
            <v-img :src="postUser.image"></v-img>
          </v-list-item-avatar>
          <v-list-item-content class="list_title_wrap">
            <v-list-item-title>{{ postUser.name }}</v-list-item-title>
            <v-list-item-subtitle class="caption">
              <Gender :genderRole="postUser.gender" />
              <span v-if="postUser.age">/ {{ postUser.age }}歳</span>
            </v-list-item-subtitle>
            <span v-if="postContent.category_name" class="categoryChip">
              <v-chip class="ma-1 category_chips" small outlined color="#a0a0a0">
                {{
                postContent.category_name
                }}
              </v-chip>
            </span>
            <!-- <span v-if="postContent.status == 1" class>
              <v-chip class="ma-1 category_chips" small outlined color="#a0a0a0">解決済みです</v-chip>
            </span>-->
          </v-list-item-content>
        </v-list-item>
        <v-card-text class="px-4 pb-0 pt-2">{{ postContent.text }}</v-card-text>
        <v-img v-if="postContent.post_image" :src="postContent.post_image" class="mt-2"></v-img>
        <v-card-actions class="iconWrap">
          <PostBookmarkComponent
            v-if="isBookmarkedPost"
            @remove-post-bookmark="
                                    removePostBookmark(postContent.id)
                                "
            :post_id="parseInt(postContent.id)"
            :isBookmarked="true"
          />
          <PostBookmarkComponent
            v-else
            @add-post-bookmark="
                                    addPostBookmark(postContent.id)
                                "
            :post_id="parseInt(postContent.id)"
            :isBookmarked="false"
          />
          <v-btn
            icon
            :disabled="isVisible.answerIcon"
            @click="answerOperationAtClick()"
            class="commentIcon"
          >
            <i class="far fa-comment"></i>
          </v-btn>
          <span class="caption captionColor answerCount">{{ postedAnswers.length }}</span>

          <span
            icon
            v-if="loginUser == postUser.id && isVisible.editReviewBtn"
            class="commentIcon"
            @click="editReviewOperationAtClick()"
          >
            <v-icon>mdi-dots-horizontal</v-icon>
            <!-- <span>ベストアンサーを編集</span> -->
          </span>
          <span
            icon
            v-if="loginUser == postUser.id && isVisible.reviewBtn"
            class="commentIcon"
            @click="reviewOperationAtClick()"
          >
            <v-icon>mdi-dots-horizontal</v-icon>
          </span>
          <MomentJs :time="postContent.created_at" class="caption captionColor data" />
        </v-card-actions>
      </div>

      <div v-if="isVisible.postedAnswer">
        <v-btn
          v-if="loginUser == postUser.id && isVisible.reviewBtn"
          text
          @click="reviewOperationAtClick()"
        >ベストアンサーを選択する</v-btn>
        <v-btn v-if="isVisible.reviewSubmitBtn" text @click="saveBestAnswerData()">ベストアンサーを決定</v-btn>
        <v-btn
          v-if="
                            loginUser == postUser.id && isVisible.editReviewBtn
                        "
          text
          @click="editReviewOperationAtClick()"
        >ベストアンサーを編集</v-btn>
        <v-card
          v-for="(answer, index) in postedAnswers"
          :key="index"
          class="postedAnswerCard card"
          outlined
        >
          <input
            v-if="isVisible.reviewCheckbox"
            v-model="reviewCheckbox"
            type="radio"
            name="bestAnswer[]"
            id="bestAnswerId"
            :value="answer.id"
            class="bestAnswerRadio"
          />
          <label v-if="isVisible.reviewCheckbox">ベストアンサーに選ぶ</label>
          <v-list-item>
            <v-list-item-avatar size="36">
              <v-img :src="answer.image"></v-img>
            </v-list-item-avatar>
            <v-list-item-content class="list_title_wrap">
              <v-list-item-title>{{ answer.name }}</v-list-item-title>
              <v-list-item-subtitle class="caption">
                <Gender :genderRole="answer.gender" />
                <span v-if="answer.age">/ {{ answer.age }}歳</span>
              </v-list-item-subtitle>

              <span v-if="answer.toggle == 1" class="statusChip">
                <v-chip class="ma-1" small outlined color="#a0a0a0">ベストアンサー</v-chip>
              </span>
            </v-list-item-content>
          </v-list-item>
          <v-card-text class="px-4 pb-0 pt-2">{{ answer.text }}</v-card-text>
          <v-img v-if="answer.image" :src="answer.image" class="mt-2"></v-img>

          <v-card-actions class="iconWrap">
            <AnswerBookmarkComponent
              v-if="
                                        isBookmarkedId.answer.includes(
                                            parseInt(answer.id)
                                        )
                                    "
              @remove-answer-bookmark="
                                        removeAnswerBookmark(answer.id)
                                    "
              :answer_id="parseInt(answer.id)"
              :isBookmarked="true"
            />
            <AnswerBookmarkComponent
              v-else
              @add-answer-bookmark="
                                        addAnswerBookmark(answer.id)
                                    "
              :answer_id="parseInt(answer.id)"
              :isBookmarked="false"
            />
            <MomentJs :time="answer.created_at" class="caption captionColor data" />
          </v-card-actions>
        </v-card>
      </div>

      <v-card v-if="isVisible.answerInput" class="mx-auto answerCard card" max-width="344" outlined>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-col cols="12">
            <v-textarea
              label="回答の内容を入力してください"
              id="answerText"
              name="answer"
              v-model="answerContent.text"
              :readonly="isReadOnly.text"
              :rules="[
                                    validationRules.required,
                                    validationRules.textCounter
                                ]"
              counter="500"
              color="#bc8f8f"
              rows="3"
              row-height="15"
            ></v-textarea>
          </v-col>

          <v-col cols="12">
            <v-text-field
              label="URL(任意)"
              id="answerUrl"
              name="url"
              v-model="answerContent.url"
              :readonly="isReadOnly.url"
              counter="500"
              color="#bc8f8f"
            ></v-text-field>
          </v-col>

          <v-col cols="12">
            <v-file-input
              chips
              counter
              accept="image/*"
              label="添付画像を選択してください"
              :rules="[validationRules.imageMax]"
              @change="fileSelected"
            ></v-file-input>
          </v-col>
          <input type="hidden" name="postId" id="postId" v-model="answerContent.postId" />
          <v-btn @click="cancelOperationAtClick()" class="cansel_btn" text>キャンセル</v-btn>
          <v-btn @click="saveAnswerPostData" color="#bc8f8f" class="submit_btn" text>回答</v-btn>
        </v-form>
      </v-card>
    </v-container>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import PostBookmarkComponent from "../items/PostBookmarkComponent";
import AnswerBookmarkComponent from "../items/AnswerBookmarkComponent";
import MomentJs from "../items/MomentJs";
import Gender from "../items/GenderComponent";
import Mixin from "../../mixin";

export default {
  components: {
    PostBookmarkComponent,
    AnswerBookmarkComponent,
    MomentJs,
    Gender
  },
  /**
   *
   * @param {Object} validationRules・・・・・・・バリデーションルールの設定
   * @param {Boolean} valid・・・・・・・バリデーションチェック用の真偽値
   * @param {Boolean} isReadOnly・・・各フォームが読み取り専用かどうかの状態を管理
   * @param {Boolean} isVisible・・・各セクションの表示非表示の切り替えを管理
   * @param {Boolean} isBookmarkedPost・・・質問投稿に対するブックマークの有無。
   * @param {Object} postContent・・・質問投稿のデータを管理
   * @param {Object} postUser・・・質問投稿をしたユーザーのデータを管理
   * @param {Object} postedAnswers・・・質問投稿に対するすでに回答されたデータを管理
   * @param {Array} selectedTastes・・・質問投稿者の登録したテイストデータを管理
   * @param {Array} gender・・・性別データを管理
   * @param {Object} answerPost・・・質問投稿に対する新たに回答する入力データを管理
   * @param {Array} isBookmarkId・・・ログインユーザーのお気に入り済のidを管理
   * @param {String} fileInfo・・・画像プレビュー用のURLを管理（現在不使用)
   *
   **/

  data() {
    return {
      //　バリデーション系の定義
      validationRules: {
        required: value => !!value || "入力必須です。",
        textCounter: value =>
          (value || "").length <= 500 || "回答は500字以下で入力してください。",
        urlCounter: value =>
          (value || "").length <= 500 || "urlは500字以下で入力してください。",
        imageMax: value =>
          !value ||
          value.size < 200000000 ||
          "画像は2MB以下のものを選択してください!"
      },
      valid: true,
      isReadOnly: {
        question: false,
        text: false,
        url: false
      },
      isVisible: {
        answerInput: false,
        postedAnswers: false,
        reviewBtn: true,
        reviewSubmitBtn: false,
        reviewCheckbox: false,
        editReviewBtn: false,
        answerIcon: false
      },
      isBookmarkedPost: false,
      postContent: {},
      postUser: {},
      postedAnswers: {},
      selectedTastes: [],
      answerContent: {
        postId: this.$route.params.postId
      },
      isBookmarkedId: {
        post: [],
        answer: []
      },
      fileInfo: "",
      reviewCheckbox: []
    };
  },
  mixins: [Mixin],
  created() {
    this.getPostData();
    this.answerIsBookmarkedCheck();
  },
  mounted() {
    this.getLoginUserData();
  },
  computed: {
    ...mapGetters(["loginUser"])
  },
  watch: {
    reviewCheckbox: function(newVal, oldVal) {
      console.log(this.reviewCheckbox);
    }
  },
  methods: {
    //ログインしているユーザーの情報
    ...mapActions(["getLoginUserData"]),
    //質問内容の取得
    getPostData: function() {
      axios
        .get("api/question/get/" + this.$route.params.postId)
        .then(res => {
          console.log(res.data);
          const getData = res.data;
          this.postContent = getData.postContent;
          this.postUser = getData.postUser;
          this.postUser.gender = parseInt(getData.postUser.gender);
          const postedAnswersData = getData.postedAnswers;
          this.postedAnswers = postedAnswersData;
          this.postedAnswers.gender = parseInt(postedAnswersData.gender);
          const bookmarkData = parseInt(getData.bookmarkData);

          if (getData.postContent.status == 1) {
            this.isVisible.reviewBtn = false;
            this.isVisible.editReviewBtn = true;
            this.isVisible.answerIcon = true;
          }

          if (postedAnswersData.length > 0) {
            this.isVisible.postedAnswer = true;
            console.log(this.postedAnswers);
          }

          if (bookmarkData == 0) {
            this.isBookmarkedPost = false;
          } else if (bookmarkData == 1) {
            this.isBookmarkedPost = true;
          }

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
    //回答に対してお気に入りしているか確認
    answerIsBookmarkedCheck: function() {
      axios
        .get("api/answer_bookmark/get/" + this.$route.params.postId)
        .then(res => {
          console.log(res.data.bookmarkId);
          this.isBookmarkedId.answer = res.data.bookmarkId;
        })
        .catch(err => console.log(err));
    },
    // コメント（回答）系のmethods
    //　「回答する」アイコンを押したときの処理
    answerOperationAtClick: function() {
      this.isVisible.answerInput = true;
      this.isVisible.postedAnswer = false;
    },
    cancelOperationAtClick: function() {
      this.isVisible.answerInput = false;
      if (this.postedAnswers.length > 0) {
        this.isVisible.postedAnswer = true;
      }
    },
    //「評価をつける」をクリックした時
    reviewOperationAtClick: function() {
      this.isVisible.reviewSubmitBtn = true;
      this.isVisible.reviewBtn = false;
      this.isVisible.reviewCheckbox = true;
    },
    //「評価を編集する」をクリックした時
    editReviewOperationAtClick: function() {
      this.isVisible.reviewSubmitBtn = true;
      this.isVisible.editReviewBtn = false;
      this.isVisible.reviewCheckbox = true;
    },
    //　画像ファイルの定義
    fileSelected(imageFile) {
      const file = imageFile;
      const name = file.name;
      const size = file.size;
      const type = file.type;
      const errors = "type";

      //　画像の定義(プレビュー表示一旦保留)
      this.answerContent.image = imageFile;
      console.log(this.answerContent.image);
    },
    //　回答の入力データを定義
    setAnswerData: function() {
      let formData = new FormData();

      Object.keys(this.answerContent).forEach(attributeName => {
        console.log(attributeName, this.answerContent[attributeName]);
        formData.append(attributeName, this.answerContent[attributeName]);
      });
      // formData.append("image", this.fileInfo);

      return formData;
    },
    // 回答のデータを送信
    saveAnswerPostData: function() {
      if (this.$refs.form.validate()) {
        const formData = this.setAnswerData();

        var config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
        axios
          .post("api/answer/post", formData, config)
          .then(res => {
            console.log(res.data);
            this.isVisible.answerInput = false;
            this.isVisible.postedAnswer = true;
            this.postedAnswers = res.data.postedAnswers;
          })
          .catch(err => {
            console.log(err.response);
            this.setAxiosErrorData(err);
          });
      } else {
        console.log("エラーがあるよ！");
      }
    },
    //質問投稿に対するお気に入りの登録
    addPostBookmark: function(id) {
      axios
        .post("api/post_bookmark/post/" + id)
        .then(res => {
          console.log(res.data.isBookmarked);
          this.isBookmarkedPost = true;
        })
        .catch(err => {
          this.setBookmarkAxiosErrorData(err);
          console.log(err.response);
        });
    },
    // 質問投稿に対するお気に入りの削除
    removePostBookmark: function(id) {
      axios
        .post("api/post_bookmark/destory/" + id)
        .then(res => {
          this.isBookmarkedPost = false;
        })
        .catch(err => {
          this.setBookmarkAxiosErrorData(err);
          console.log(err);
        });
    },
    // 回答に対するお気に入り登録
    addAnswerBookmark: function(id) {
      axios
        .post("api/answer_bookmark/post/" + id)
        .then(res => {
          console.log(res.data.isBookmarked);
          const answerBookmarkIdArray = this.isBookmarkedId.answer;
          answerBookmarkIdArray.push(id);
          this.isBookmarkedId.answer = answerBookmarkIdArray;
          console.log(this.isBookmarkedId.answer);
        })
        .catch(err => {
          this.setBookmarkAxiosErrorData(err);
        });
    },
    // 回答に対するお気に入りの解除
    removeAnswerBookmark: function(id) {
      axios
        .post("api/answer_bookmark/destory/" + id)
        .then(res => {
          console.log(res.data.bookmarksId);
          this.isBookmarkedId.answer = res.data.bookmarksId;
        })
        .catch(err => {
          this.setBookmarkAxiosErrorData(err);
        });
    },
    //ベストアンサーを選ぶ処理
    saveBestAnswerData: function() {
      const id = this.reviewCheckbox;
      axios
        .post("api/best_answer/post/" + id)
        .then(res => {
          this.isVisible.reviewSubmitBtn = false;
          this.isVisible.editReviewBtn = true;
          this.isVisible.reviewCheckbox = false;
          console.log(res.data);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style lang="scss" scoped>
body {
  font-size: 14px;
}
p {
  margin: 0;
}

i {
  font-size: 24px;
}

.wrap {
  padding-bottom: 56px;
  //   background-color: #ddd;
}

.mainWrap {
  padding: 0;
  background-color: #ddd;
}

.card {
  width: 100%;
  //   margin: 8px 0 0;
  /* padding:8px 16px; */
}

.textWrap {
  margin: 16px 0 0;
}
/* 質問に対するスタイル */
.postCard {
  padding-top: 16px;
  background-color: #fff;
}

.list_title_wrap {
  position: relative;

  .category_chips {
    position: absolute;
    top: 8px;
    right: 0;
  }
  .statusChip {
    position: absolute;
    top: 8px;
    right: 0;
  }
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

/* 回答投稿に対するスタイル */

/* 投稿済みの回答に対するスタイル */
.postedAnswerCard {
  width: 100%;
  padding-top: 10px;
  padding-bottom: 8px;
  margin-bottom: 8px;
}
.answerCount {
  margin-left: 8px;
}
</style>
