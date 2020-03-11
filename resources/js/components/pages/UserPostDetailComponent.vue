<template>
  <div class="wrap">
    <v-container class="">
      <h1 class="subtitle-1">質問詳細画面</h1>
      <v-row>
        <v-col cols="12"> 
          <v-card class="mx-auto postCard card" max-width="344" outlined>
            <div class="d-flex align-center justify-flex-start postImgWrap">
              <div class="iconImage">
                <img :src="questionPostUser.image"/>
              </div>
              <div>
              <p>{{ questionPostUser.name }}</p>
              <span>{{　gender[questionPostUser.gender]　}}</span>
              <span>{{ questionPostUser.age }}歳</span>
              </div>
              <div class="categoryChip">
                <v-chip class="ma-1" x-small>{{ questionPost.category }}</v-chip>
              </div>
              <!-- <div>
                <v-chip v-for="(taste,index) in selectedTastes" :key=index class="ma-1" x-small>{{ taste }}</v-chip>
              </div> -->
            </div>
            <div class="textWrap">
              <p>{{ questionPost.text }}</p>
            </div>
            <v-btn icon @click="answerIconClick()">
              <i class="fas fa-comment"></i>
            </v-btn>
            <span class="caption">{{ questionPost.created_at }}</span>
          </v-card>
        </v-col>

        <v-col v-if="postedAnswersFlag" cols="12">
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
                <span class="caption">{{ answer.created_at }}</span>
              </div>
            </div>
          </v-card>
        </v-col>


        <v-card v-if="answerTabelFlag" class="mx-auto answerCard card" max-width="344" outlined>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-col cols="12">
              <v-textarea
                label="回答の内容を入力してください"
                id="answerText"
                name="answer"
                v-model="answerPost.text"
                :readonly="readonlyFlag.text"
                :rules="[rules.required]"
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
                v-model="answerPost.url"
                :readonly="readonlyFlag.url"
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
                :rules="[rules.imageMax]"
                @change="fileSelected"
              ></v-file-input>
            </v-col>
            <input type="hidden" name="postId" id="postId" v-model="answerPost.postId">
            <v-btn @click="cancelBtnClick()" class="cansel_btn" text>キャンセル</v-btn>
            <v-btn @click="saveAnswerPostData" color="#81CAC4" class="submit_btn" text>回答</v-btn>
            </v-form>
        </v-card>
      </v-row>

    </v-container>
  </div>
</template>

<script>

export default {
  components: {

  },
  data() {
    return {
      //　バリデーション系の定義
      rules: {
        required: value => !!value || "入力必須です。",
        imageMax: value => !value || value.size < 200000000 || '画像は2MB以下のものを選択してください!',
      },

      valid: true,
      readonlyFlag:{
        question: false,
        text: false,
        url: false,
      },
      answerTabelFlag: false,
      postedAnswersFlag: false,
      
      //データ型の定義
      questionPost:{},
      questionPostUser:{},
      postedAnswers:{},
      selectedTastes:[],
      gender: ['女性', '男性'],
      answerPost:{
        postId:this.$route.params.postId,
      },
      fileInfo:"",
    };
  },

  created() {

  },
  mounted() {
    this.getPostData();
  },
  methods: {
    //質問内容の取得
    getPostData: function() {
      axios
        .get("api/get/question/" + this.$route.params.postId)
        .then(res => {
          console.log(res.data);
          this.questionPost = res.data.posts;
          this.questionPostUser = res.data.postUser;
          this.questionPostUser.gender = parseInt(res.data.postUser.gender);
          const postedAnswersData = res.data.postedAnswers;
          this.postedAnswers = postedAnswersData

          if (postedAnswersData.length > 0) {
            this.postedAnswersFlag = true;
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
    // コメント（回答）系のmethods
    //　「回答する」アイコンを押したときの処理
    answerIconClick: function (){
        this.answerTabelFlag = true;
        this.postedAnswersFlag = false;
    },
    cancelBtnClick: function(){
        this.answerTabelFlag = false;
        if (this.postedAnswers.length > 0) {
          this.postedAnswersFlag = true;
        }
    },
    //　画像ファイルの定義
    fileSelected(event) {
        const file = event;
        const name = file.name;
        const size = file.size;
        const type = file.type;
        const errors = 'type';

      //　画像の定義(プレビュー表示一旦保留)
      this.fileInfo = event;
      console.log(this.fileInfo);
    },
    //　回答の入力データを定義
    setAnswerData: function() {
      let formData = new FormData();

      Object.keys(this.answerPost).forEach(key=>{
          console.log(key,this.answerPost[key])
          formData.append(key, this.answerPost[key]);
      });
      formData.append("image", this.fileInfo);

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
            this.answerTabelFlag = false;
          })
          .catch(err => {
            // this.isDialogOpen.errorDialog = true;
            console.log(err);
            }) 
      } else {
        console.log('エラーがあるよ！');
      }

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

  .categoryChip{
    position: relative;
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