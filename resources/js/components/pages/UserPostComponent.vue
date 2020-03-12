<template>
  <div class="wrap">
    <v-container　class="text-center">
      <h2 class="subtitle-1">質問投稿ページ</h2>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row justify="center">
            <v-col cols="11">
              <v-textarea
                label="質問や相談を記入してください"
                id="question"
                name="input-7-4"
                v-model="questionPost.text"
                :readonly="readonlyFlag.question"
                :rules="[rules.required]"
                counter="500"
                color="#81cac4"
                rows="3"
                row-height="15"
              ></v-textarea>
            </v-col>
            <v-col cols="11">
              <v-select
              :items="categories"
              label="カテゴリ"
              id="gender"
              color="#81cac4"
              v-model="questionPost.category"
              ></v-select>
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
          </v-row>
            <v-btn @click="saveQuestionPostData" color="#81CAC4" class="submit_btn">変更を保存</v-btn>
      </v-form>
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
      },
      
      //データ型の定義
      questionPost:{},
      fileInfo:"",
      categories:['トップス', 'アウター', 'ボトムス', 'スカート','ワンピース','シューズ' ,'ファッション小物'],
    };
  },

  created() {

  },
  methods: {
    fileSelected(event) {
        const file = event;
        // const name = file.name;
        // const size = file.size;
        // const type = file.type;
        // const errors = 'type';

      //　画像の定義(プレビューは一旦保留)
      this.fileInfo = event;    
      // this.questionPost.image = window.URL.createObjectURL(this.fileInfo);
      console.log(this.fileInfo);
    },
    setQuestionData: function() {
      let formData = new FormData();

      Object.keys(this.questionPost).forEach(key=>{
          console.log(key,this.questionPost[key])
          formData.append(key, this.questionPost[key]);
      });
      formData.append("image", this.fileInfo);

      return formData;
    },
    saveQuestionPostData: function() {
      if (this.$refs.form.validate()){
        const formData = this.setQuestionData();
    

      var config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
      axios
          .post("api/post/question", formData, config)
          .then(res => {
            console.log(res.data.id);
            this.$router.push({ name: 'UserPostDetail', params: { postId: res.data.id }})
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
.image {
  width: 120px;
  margin: 8px auto;
  height: 120px;
  border-radius: 75px;
  position: relative;
}

.image img {
  width: 120px;
  height: 120px;
  border-radius: 75px;
  object-fit: cover;
}
</style>