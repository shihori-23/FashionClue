<template>
  <div class="wrap">
    <v-container class="">
      <h1 class="subtitle-1">質問詳細画面</h1>
      <v-row>
        <v-card class="mx-auto post_card" max-width="344" outlined>
          <div class="d-flex align-center justify-space-between">
            <div class="iconImage">
              <img :src="questionPostUser.image"/>
            </div>
            <div>
            <p>{{ questionPostUser.name }}</p>
            <span>{{　gender[questionPostUser.gender]　}}</span>
            <span>{{ questionPostUser.age }}歳</span>
            </div>
          </div>
          <div class="">
            <p>{{ questionPost.text }}</p>
          </div>
          <v-btn icon @click="answerTabelFlag = true">
            <i class="fas fa-comment"></i>
          </v-btn>
        </v-card>

        <v-card v-if="postedAnswersFlag" class="mx-auto post_card" max-width="344" outlined>
          <p>コメントが既にあります</p>
        </v-card>

        <v-card v-if="answerTabelFlag" class="mx-auto answer_card" max-width="344" outlined>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-col cols="11">
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

            <v-col cols="11">
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

            <v-col cols="11">
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
            <v-btn @click="saveAnswerPostData" color="#81CAC4" class="submit_btn">回答</v-btn>
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
          const postedAnswers = res.data.postedAnswers;
          if (postedAnswers.length > 0) {
            this.postedAnswersFlag = true;
          }

          this.selectedTasteConvert(res);
        })
        .catch(err => console.log(err));
    },
    //　テイストタグのデータを配列に入れる処理
    selectedTasteConvert: function(res) {
        const selectedTasteArray = res.data.selectedTastes;
        const selectedtasteList = selectedTasteArray.map(function(row){
        return [ row["taste_id"] ]
        }).reduce(function(a,b){
          return a.concat(b);
        });
        this.selectedTastes = selectedtasteList;
        console.log(this.selectedTastes);  
    },
    // コメント（回答）系のmethods
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

    setAnswerData: function() {
      let formData = new FormData();

      Object.keys(this.answerPost).forEach(key=>{
          console.log(key,this.answerPost[key])
          formData.append(key, this.answerPost[key]);
      });
      formData.append("image", this.fileInfo);
      formData.append("image", this.fileInfo);

      return formData;
    },
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
/* 質問に対するスタイル */
.post_card{
  width: 95%;
  margin: 0 auto;
}
.iconImage {
  width: 80px;
  margin: 8px auto;
  height: 120px;
  border-radius: 75px;
  position: relative;
}
.iconImage img {
  width: 80px;
  height: 80px;
  border-radius: 75px;
  object-fit: cover;
}

/* 回答投稿に対するスタイル */
.answer_card{
  width: 95%;
  margin: 24  px auto 0;
}
</style>