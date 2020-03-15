<template>
  <div class="wrap">
    <v-container　class="text-center">
      <h2 class="subtitle-1">質問投稿ページ</h2>

      <v-dialog v-model="isDialogOpen.errorDialog" width="400">
          <v-card>
            <v-card-title class="headline lighten-2" primary-title>エラー</v-card-title>
            <v-card-text><p v-for="(message,index) in axiosErrorMessages" :key="index">{{ axiosErrorMessages[index] }}</p></v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="closeDialog('errorDialog')">閉じる</v-btn>
            </v-card-actions>
          </v-card>
      </v-dialog>


      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row justify="center">
            <v-col cols="11">
              <v-textarea
                label="質問や相談を記入してください"
                id="question"
                name="question"
                v-model="postContent.text"
                :readonly="readOnly.question"
                :rules="[validationRules.required,validationRules.textCounter]"
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
              id="categories"
              color="#81cac4"
              v-model="postContent.category"
              ></v-select>
            </v-col>
            <v-col cols="11">
              <v-file-input
                chips
                counter
                accept="image/*"
                label="添付画像を選択してください"
                :rules="[validationRules.imageMax]"
                @change="selectImageFile"
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
  /**
  *
  * @param {Object} validationRules・・・・・・・バリデーションルールの設定
  * @param {Boolean} valid・・・・・・・バリデーションチェック用の真偽値
  * @param {Object} readOnly・・・各フォームが読み取り専用かどうかの状態を管理。
  * @param {Object} isDialogOpen・・・Dialogの表示非表示を管理。
  * @param {Object} postContent・・・質問投稿のデータを管理
  * @param {String} fileInfo・・・画像プレビュー用のURLを管理（現在不使用）
  * @param {Object} categories・・・質問投稿の際のカテゴリ選択タブ用のデータを管理（要：DBから取得するように変更）
  * @param {Array} axiosErrorMessages・・・DB側のバリデーションエラーを受け取る
  *
  **/
  data() {
    return {
      //　バリデーション系の定義
      validationRules: {
        required: value => !!value || "入力必須です。",
        textCounter:value => (value || '').length <= 500 || "質問は500字以下で入力してください。",
        imageMax: value => !value || value.size < 200000000 || '画像は2MB以下のものを選択してください!',
      },
      //真偽値の管理
      valid: true,
      readOnly:{
        question: false,
      },
      isDialogOpen:{
        errorDialog:false,
      }
      ,
      //データ型の定義
      postContent:{},
      fileInfo:"",
      categories:['トップス', 'アウター', 'ボトムス', 'スカート','ワンピース','シューズ' ,'ファッション小物'],
      axiosErrorMessages:[],
    };
  },

  created() {

  },
  methods: {
    selectImageFile(imageFile) {
        const postImageFile = imageFile;
        // const name = file.name;
        // const size = file.size;
        // const type = file.type;
        // const errors = 'type';

      //　画像の定義(プレビューは一旦保留)
      this.postContent.image = postImageFile;    
      // this.questionPost.image = window.URL.createObjectURL(this.fileInfo);
      // console.log(this.fileInfo);
    },
    setQuestionData: function() {
      let formData = new FormData();

      Object.keys(this.postContent).forEach(attributeName=>{
          console.log(attributeName,this.postContent[attributeName])
          formData.append(attributeName, this.postContent[attributeName]);
      });
      // formData.append("image", this.fileInfo);

      return formData;
    },
    //　サーバー側からのエラーを定義
    axiosErrorData: function(err) {
      const axiosErrorRes = err.response.data;
      let axiosErrorMessageArray = [];
  
      if (axiosErrorRes.errors) {
        const axiosvalidationErrorRes = axiosErrorRes.errors;

        if (axiosvalidationErrorRes.image){
          axiosErrorMessageArray.push(axiosvalidationErrorRes.image[0]);
        }
        if(axiosvalidationErrorRes.text) {
          const textErrors = axiosvalidationErrorRes.text;
          textErrors.forEach(errorMessage => {
            axiosErrorMessageArray.push(errorMessage);
          });
        }
      } else {
        axiosErrorMessageArray.push("回答が送信されませんでした。再度送信してください。");
      }
      this.axiosErrorMessages = axiosErrorMessageArray;
      console.log(this.axiosErrorMessages);
      this.isDialogOpen.errorDialog = true;
      },
    //　質問投稿をPost
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
            const transitionDestinationObj = {
            name: 'UserPostDetail',
            params: {
                postId: res.data.id
            }
        };
            this.$router.push(transitionDestinationObj);
          })
          .catch(err => {
            console.log(err.response.data);
            console.log(err.response.data.errors);
            this.axiosErrorData(err);
            }) 
      } else {
        this.axiosErrorMessages = "入力いただいた内容に再度確認の上、"
        console.log('エラーがあるよ！');
      }
    },
    //　ダイアログを閉じる
    closeDialog(dialogName){
        this.isDialogOpen[dialogName] = false;
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