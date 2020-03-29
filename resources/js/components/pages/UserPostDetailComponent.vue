<template>
  <div class="wrap">
    <v-container class>
      <h1 class="subtitle-1">質問詳細画面</h1>

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

      <v-row>
        <v-col cols="12">
          <v-card class="mx-auto postCard card" max-width="344" outlined>
            <v-list-item>
              <v-list-item-avatar size="36">
                <v-img :src="postUser.image"></v-img>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title class>
                  {{ postUser.name }}
                  <span v-if="postUser.category_name" class="categoryChip">
                    <v-chip class="ma-1" x-small>
                      {{
                      postUser.category_name
                      }}
                    </v-chip>
                  </span>
                  <span v-if="postContent.status == 1" class="statusChip">
                    <v-chip class="ma-1" x-small>解決済みです</v-chip>
                  </span>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <Gender :genderRole="postUser.gender" />
                  <span v-if="postUser.age">{{ postUser.age }}歳</span>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-card-text>{{ postContent.text }}</v-card-text>
            <v-img v-if="postContent.post_image" :src="postContent.post_image"></v-img>
            <v-card-actions class="iconWrap">
              <v-btn icon @click="answerOperationAtClick()">
                <i class="fas fa-comment"></i>
              </v-btn>
              <PostBookmarkComponent
                v-if="
                                    isBookmarkedId.post.includes(
                                        parseInt(postContent.id)
                                    )
                                "
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
              <MomentJs :time="postContent.created_at" class="caption captionColor data" />
            </v-card-actions>
          </v-card>
        </v-col>

        <v-col v-if="isVisible.postedAnswer" cols="12">
          <span>回答({{ postedAnswers.length }})</span>
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
            max-width="344"
            outlined
          >
            <div>
              <input
                v-if="isVisible.reviewCheckbox"
                v-model="reviewCheckbox"
                type="radio"
                name="bestAnswer[]"
                id="bestAnswerId"
                :value="answer.id"
              />
              <div class="answerImgFlex">
                <div class="answeIcoImg">
                  <img :src="answer.image" />
                </div>

                <p>{{ answer.name }}</p>
                <span v-if="answer.toggle == 1" class="statusChip">
                  <v-chip class="ma-1" x-small>ベストアンサー</v-chip>
                </span>
              </div>
              <div class="textWrap">
                <p>{{ answer.text }}</p>
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
                <span class="caption">
                  {{
                  answer.created_at
                  }}
                </span>
              </div>
            </div>
          </v-card>
        </v-col>

        <v-card
          v-if="isVisible.answerInput"
          class="mx-auto answerCard card"
          max-width="344"
          outlined
        >
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
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import PostBookmarkComponent from "../items/PostBookmarkComponent";
import AnswerBookmarkComponent from "../items/AnswerBookmarkComponent";
import MomentJs from "../items/MomentJs";
import Gender from "../items/GenderComponent";

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
   * @param {Object} isReadOnly・・・各フォームが読み取り専用かどうかの状態を管理
   * @param {Object} isVisible・・・各セクションの表示非表示の切り替えを管理
   * @param {Object} isDialogOpen・・・Dialogの表示非表示を管理。
   * @param {Object} postContent・・・質問投稿のデータを管理
   * @param {Object} postUser・・・質問投稿をしたユーザーのデータを管理
   * @param {Object} postedAnswers・・・質問投稿に対するすでに回答されたデータを管理
   * @param {Array} selectedTastes・・・質問投稿者の登録したテイストデータを管理
   * @param {Array} gender・・・性別データを管理
   * @param {Object} answerPost・・・質問投稿に対する新たに回答する入力データを管理
   * @param {Array} isBookmarkId・・・ログインユーザーのお気に入り済のidを管理
   * @param {String} fileInfo・・・画像プレビュー用のURLを管理（現在不使用)
   * @param {Array} axiosErrorMessages・・・DB側のバリデーションエラーを受け取る
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
        editReviewBtn: false
      },
      isDialogOpen: {
        errorDialog: false
      },
      disabledReviewCheckBox: false,
      postContent: {},
      postUser: {},
      postedAnswers: {},
      selectedTastes: [],
      gender: ["女性", "男性"],
      answerContent: {
        postId: this.$route.params.postId
      },
      isBookmarkedId: {
        post: [],
        answer: []
      },
      fileInfo: "",
      axiosErrorMessages: [],
      reviewCheckbox: []
    };
  },
  created() {
    this.getPostData();
    this.postIsBookmarkedCheck();
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

          if (getData.postContent.status == 1) {
            this.isVisible.reviewBtn = false;
            this.isVisible.editReviewBtn = true;
          }

          if (postedAnswersData.length > 0) {
            this.isVisible.postedAnswer = true;
            console.log(this.postedAnswers);
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
    //質問に対してお気に入りしているか確認
    postIsBookmarkedCheck: function() {
      axios
        .get("api/bookmark/get/" + this.$route.params.postId)
        .then(res => {
          console.log(res.data.bookmarkId);
          this.isBookmarkedId.post = res.data.bookmarkId;
        })
        .catch(err => console.log(err));
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
    //　サーバー側からのエラーを定義
    setAxiosErrorData: function(err) {
      const axiosErrorRes = err.response.data;
      let axiosErrorMessageArray = [];

      if (axiosErrorRes.errors) {
        const axiosvalidationErrorRes = axiosErrorRes.errors;

        Object.keys(axiosvalidationErrorRes).map(dataField => {
          axiosErrorMessageArray.push(axiosvalidationErrorRes[dataField]);
        });
      } else {
        axiosErrorMessageArray.push(
          "回答が送信されませんでした。再度送信してください。"
        );
      }
      this.axiosErrorMessages = axiosErrorMessageArray.flat();
      console.log(this.axiosErrorMessages);
      this.isDialogOpen.errorDialog = true;
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
            console.log(err.response.data.errors);
            this.setAxiosErrorData(err);
            console.log(err);
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
          const postBookmarkIdArray = [];
          postBookmarkIdArray.push(id);
          this.isBookmarkedId.post = postBookmarkIdArray;
          console.log(this.isBookmarkedId.post);
        })
        .catch(err => console.log(err));
    },
    // 質問投稿に対するお気に入りの削除
    removePostBookmark: function(id) {
      axios
        .post("api/post_bookmark/destory/" + id)
        .then(res => {
          const postBookmarkIdArray = [];
          this.isBookmarkedId.post = postBookmarkIdArray;
          console.log(this.isBookmarkedId.post);
        })
        .catch(err => console.log(err));
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
        .catch(err => console.log(err));
    },
    // 回答に対するお気に入りの解除
    removeAnswerBookmark: function(id) {
      axios
        .post("api/answer_bookmark/destory/" + id)
        .then(res => {
          console.log(res.data.bookmarksId);
          this.isBookmarkedId.answer = res.data.bookmarksId;
        })
        .catch(err => console.log(err));
    },
    //　ダイアログを閉じる
    closeDialog(dialogName) {
      this.isDialogOpen[dialogName] = false;
    },
    saveBestAnswerData: function() {
      const id = this.reviewCheckbox;
      axios
        .post("api/best_answer/post/" + id)
        .then(res => {
          this.isVisible.reviewSubmitBtn = false;
          this.isVisible.editReviewBtn = true;
          console.log(res.data);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style scoped>
p {
  margin: 0;
}

i {
  font-size: 24px;
}

.wrap {
  padding-bottom: 56px;
}

.card {
  width: 95%;
  margin: 8px auto 0;
  /* padding:8px 16px; */
}

.textWrap {
  margin: 16px 0 0;
}
/* 質問に対するスタイル */
.iconImage {
  width: 50px;
  margin-right: 16px;
  height: 50px;
  border-radius: 75px;
}
.iconImage img {
  width: 50px;
  height: 50px;
  border-radius: 75px;
  object-fit: cover;
}

.postImgWrap {
  position: relative;
}

.categoryChip {
  position: absolute;
  top: 0;
  right: 8px;
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
.answerImgFlex {
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.answeIcoImg {
  width: 50px;
  margin-right: 16px;
  height: 50px;
  border-radius: 75px;
}

.answeIcoImg img {
  width: 50px;
  height: 50px;
  border-radius: 75px;
  object-fit: cover;
}
</style>
