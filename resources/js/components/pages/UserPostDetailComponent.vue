<template>
  <div class="wrap">
    <v-container class="">
      <h1 class="subtitle-1">質問詳細画面</h1>
      <v-row>
        <v-col cols="12"> 
          <v-card class="mx-auto postCard card" max-width="344" outlined>
            <div class="d-flex align-center justify-flex-start postImgWrap">
              <div class="iconImage">
                <img :src="postUser.image"/>
              </div>
              <div>
                <p>{{ postUser.name }}</p>
                <span>{{　gender[postUser.gender]　}}</span>
                <span v-if="postUser.age">{{ postUser.age }}歳</span>
              </div>
              <div v-if="postUser.category" class="categoryChip">
                <v-chip class="ma-1" x-small>{{ postUser.category }}</v-chip>
              </div>
              <!-- <div>
                <v-chip v-for="(taste,index) in selectedTastes" :key=index class="ma-1" x-small>{{ taste }}</v-chip>
              </div> -->
            </div>
            <div class="textWrap">
              <p>{{ postContent.text }}</p>
            </div>
            <v-btn icon @click="answerOperationAtClick()">
              <i class="fas fa-comment"></i>
            </v-btn>
            <PostBookmarkComponent v-if="isBookmarkedId.post.includes(parseInt(postContent.id))" @remove-post-bookmark="removePostBookmark(postContent.id)" :post_id="parseInt(postContent.id)" :isBookmarked="true" />
            <PostBookmarkComponent v-else @add-post-bookmark="addPostBookmark(postContent.id)" :post_id="parseInt(postContent.id)" :isBookmarked="false"/>
            <span class="caption">{{ postContent.created_at }}</span>
          </v-card>
        </v-col>

        <v-col v-if="isVisible.postedAnswer" cols="12">
          <p>回答({{ postedAnswers.length }})</p>
          <v-card v-for="(answer,index) in postedAnswers" :key="index" class="postedAnswerCard card" max-width="344" outlined>
            <div>
              <div class="answerImgFlex">
                <div class="answeIcoImg">
                  <img :src="answer.image">
                </div>
                <p>{{ answer.name }}</p>
              </div>
              <div class="textWrap">
                <p>{{ answer.text }}</p>
                <AnswerBookmarkComponent v-if="isBookmarkedId.answer.includes(parseInt(answer.id))" @remove-answer-bookmark="removeAnswerBookmark(answer.id)" :answer_id="parseInt(answer.id)" :isBookmarked="true"/>
                <AnswerBookmarkComponent v-else @add-answer-bookmark="addAnswerBookmark(answer.id)" :answer_id="parseInt(answer.id)" :isBookmarked="false"/>
                <span class="caption">{{ answer.created_at }}</span>
              </div>
            </div>
          </v-card>
        </v-col>

        <v-card v-if="isVisible.answerInput" class="mx-auto answerCard card" max-width="344" outlined>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-col cols="12">
              <v-textarea
                label="回答の内容を入力してください"
                id="answerText"
                name="answer"
                v-model="answerContent.text"
                :readonly="isReadOnly.text"
                :rules="[validationRules.required]"
                counter="500"
                color="#81cac4"
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
                color="#81cac4"
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
            <input type="hidden" name="postId" id="postId" v-model="answerContent.postId">
            <v-btn @click="cancelOperationAtClick()" class="cansel_btn" text>キャンセル</v-btn>
            <v-btn @click="saveAnswerPostData" color="#81CAC4" class="submit_btn" text>回答</v-btn>
            </v-form>
        </v-card>
      </v-row>

    </v-container>
  </div>
</template>

<script>
import PostBookmarkComponent from "../items/PostBookmarkComponent"
import AnswerBookmarkComponent from "../items/AnswerBookmarkComponent"

export default {
  components: {
    PostBookmarkComponent,
    AnswerBookmarkComponent,
  },
    /**
  *
  * @param {Object} validationRules・・・・・・・バリデーションルールの設定
  * @param {Boolean} valid・・・・・・・バリデーションチェック用の真偽値
  * @param {Object} isReadOnly・・・各フォームが読み取り専用かどうかの状態を管理
  * @param {Object} isVisible・・・各セクションの表示非表示の切り替えを管理
  * @param {Object} postContent・・・質問投稿のデータを管理
  * @param {Object} postUser・・・質問投稿をしたユーザーのデータを管理
  * @param {Object} postedAnswers・・・質問投稿に対するすでに回答されたデータを管理
  * @param {Array} selectedTastes・・・質問投稿者の登録したテイストデータを管理
  * @param {Array} gender・・・性別データを管理
  * @param {Object} answerPost・・・質問投稿に対する新たに回答する入力データを管理
  * @param {Array} isBookmarkId・・・ログインユーザーのお気に入り済のidを管理
  * @param {String} fileInfo・・・画像プレビュー用のURLを管理（現在不使用）
  *
  **/

  data() {
    return {
      //　バリデーション系の定義
      validationRules: {
        required: value => !!value || "入力必須です。",
        imageMax: value => !value || value.size < 200000000 || '画像は2MB以下のものを選択してください!',
      },

      valid: true,
      isReadOnly:{
        question: false,
        text: false,
        url: false,
      },
      isVisible: {
        answerInput:false,
        postedAnswers:false,
      },
      
      postContent:{},
      postUser:{},
      postedAnswers:{},
      selectedTastes:[],
      gender: ['女性', '男性'],
      answerContent:{
        postId:this.$route.params.postId,
      },
      isBookmarkedId:{
        post:[],
        answer:[],
      },
      // postIsBookmarkedId:[],
      // answerIsBookmarkedId:[],
      fileInfo:"",
    };
  },
  created() {
    this.getPostData();
    this.postIsBookmarkedCheck();
    this.answerIsBookmarkedCheck();
  },
  mounted() {
  },
  methods: {
    //質問内容の取得
    getPostData: function() {
      axios
        .get("api/get/question/" + this.$route.params.postId)
        .then(res => {
          console.log(res.data);
          const getData = res.data;
          this.postContent = getData.postContent;
          this.postUser = getData.postUser;
          this.postUser.gender = parseInt(getData.postUser.gender);
          const postedAnswersData = getData.postedAnswers;
          this.postedAnswers = postedAnswersData;

          if (postedAnswersData.length > 0) {
            this.isVisible.postedAnswer  = true;
            console.log(this.postedAnswers);
          }
          this.selectedTasteConvert(res);
        })
        .catch(err => console.log(err));
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
    //質問に対してお気に入りしているか確認
    postIsBookmarkedCheck: function(){
      axios
        .get("api/get/bookmark/" + this.$route.params.postId)
        .then(res => {
          console.log(res.data.bookmarkId);
          this.isBookmarkedId.post= res.data.bookmarkId;
        })
        .catch(err => console.log(err));
    },
    //回答に対してお気に入りしているか確認
    answerIsBookmarkedCheck: function(){
      axios
        .get("api/get/answer_bookmark/" + this.$route.params.postId)
        .then(res => {
          console.log(res.data.bookmarkId);
          this.isBookmarkedId.answer = res.data.bookmarkId;
        })
        .catch(err => console.log(err));
    },
    // コメント（回答）系のmethods
    //　「回答する」アイコンを押したときの処理
    answerOperationAtClick: function (){
        this.isVisible.answerInput = true;
        this.isVisible.postedAnswer = false;
    },
    cancelOperationAtClick: function(){
        this.isVisible.answerInput = false;
        if (this.postedAnswers.length > 0) {
          this.isVisible.postedAnswer = true;
        }
    },
    //　画像ファイルの定義
    fileSelected(imageFile) {
        const file = imageFile;
        const name = file.name;
        const size = file.size;
        const type = file.type;
        const errors = 'type';

      //　画像の定義(プレビュー表示一旦保留)
      this.answerContent.image = imageFile;
      console.log(this.answerContent.image);
    },
    //　回答の入力データを定義
    setAnswerData: function() {
      let formData = new FormData();

      Object.keys(this.answerContent).forEach(attributeName=>{
          console.log(attributeName,this.answerContent[attributeName])
          formData.append(attributeName, this.answerContent[attributeName]);
      });
      // formData.append("image", this.fileInfo);

      return formData;
    },
    // 回答のデータを送信
    saveAnswerPostData: function() {
      if (this.$refs.form.validate()){
        const formData = this.setAnswerData();
  
      var config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
      axios
          .post("api/post/answer", formData, config)
          .then(res => {
            console.log(res.data);
            this.isVisible.answerInput = false;
            this.isVisible.postedAnswer = true;
            this.postedAnswers  = res.data.postedAnswers;
          })
          .catch(err => {
            // this.isDialogOpen.errorDialog = true;
            console.log(err);
            }) 
      } else {
        console.log('エラーがあるよ！');
      }
    },
    //質問投稿に対するお気に入りの登録
    addPostBookmark: function(id){
      axios
        .post("api/post/post_bookmark/" + id)
        .then(res => {
          console.log(res.data.isBookmarked);
          const postBookmarkIdArray = [];
          postBookmarkIdArray.push(id);
          this.isBookmarkedId.post = postBookmarkIdArray;
          console.log(this.isBookmarkedId.post);
        })
        .catch(err => console.log(err));
    }, 
    //質問投稿に対するお気に入りの削除
    removePostBookmark: function(id){
      axios
        .post("api/destory/post_bookmark/" + id)
        .then(res => {
        const postBookmarkIdArray = [];
        this.isBookmarkedId.post = postBookmarkIdArray;
        console.log(this.isBookmarkedId.post);
        })
        .catch(err => console.log(err));
    },
    //回答に対するお気に入り登録
    addAnswerBookmark: function(id){
      axios
        .post("api/post/answer_bookmark/" + id)
        .then(res => {
          console.log(res.data.isBookmarked);
          const answerBookmarkIdArray = this.isBookmarkedId.answer;
          answerBookmarkIdArray.push(id);
          this.isBookmarkedId.answer = answerBookmarkIdArray;
          console.log(this.isBookmarkedId.answer);
        })
        .catch(err => console.log(err));
    },
    //回答に対するお気に入りの解除
    removeAnswerBookmark: function(id){
      axios
        .post("api/destory/answer_bookmark/" + id)
        .then(res => {
          console.log(res.data.bookmarksId);
          this.isBookmarkedId.answer = res.data.bookmarksId;

        })
        .catch(err => console.log(err));
    },
  }
};
</script>

<style scoped>
  p {
    margin: 0;
  }
  
  i {
    font-size:24px;
  }

  .card{
    width: 95%;
    margin: 8px auto 0;
    padding:8px 16px;
  }

  .textWrap{
    margin:16px 0 0;
  }
  /* 質問に対するスタイル */
  .iconImage {
    width: 50px;
    margin-right:16px;
    height: 50px;
    border-radius: 75px;
  }
  .iconImage img {
    width: 50px;
    height: 50px;
    border-radius: 75px;
    object-fit: cover;
  }

  .postImgWrap{
    position: relative;
  }

  .categoryChip{
    position: absolute;
    top: 0;
    right:8px;

  }

  /* 回答投稿に対するスタイル */


  /* 投稿済みの回答に対するスタイル */
  .answerImgFlex{
    display: flex;
    justify-content: flex-start;
    align-items: center;
  }

  .answeIcoImg {
    width: 50px;
    margin-right:16px;
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