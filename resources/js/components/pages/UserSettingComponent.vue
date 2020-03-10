<template>
  <div class="wrap">
    <v-container class="main_profile text-center">
      <h2 class="subtitle-1">プロフィール編集</h2>
      <div class="text-center">
        <v-dialog v-model="isDialogOpen.successDialog" width="400">
          <v-card>
            <v-card-title class="headline grey lighten-2" primary-title>プロフィールを保存しました</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="closeDialog('successDialog')">閉じる</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-dialog v-model="isDialogOpen.errorDialog" width="400">
          <v-card>
            <v-card-title class="headline grey lighten-2" primary-title>入力エラーです。再度確認の上、変更を保存してください</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="closeDialog('errorDialog')">閉じる</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </div>
      <v-form ref="form" v-model="valid" lazy-validation>
      <div class="image_container">
        <div class="image">
          <img :src="userProfile.image"/>
        </div>
        <label class="user_profile" for="user_profile">
          <v-icon color="#fff" class="add_btn">mdi-camera</v-icon>
          <input
            id="user_profile"
            multiple
            type="file"
            accept="image/*"
            name="image_url"
            @change="fileSelected"
          />
        </label>
      </div>
      <v-row justify="center">
        <v-col cols="11">
            <v-text-field
              label="アカウント名"
              id="name"
              counter="20"
              v-model="userProfile.name"
              color="#81cac4"
              :readonly="readonlyFlag.name"
              :rules="[rules.required, rules.nameCounter]"
              append-icon="mdi-pencil"
            ></v-text-field>
          </v-col>
          <v-col cols="11">
            <v-text-field
              label="email"
              id="email" 
              v-model="userProfile.email" 
              :readonly="readonlyFlag.email" 
              color="#81cac4" 
              append-icon="mdi-information-outline"
              ></v-text-field>
          </v-col>
          <v-radio-group v-model="userProfile.gender" label="性別" id="gender" color="#81cac4">
            <v-radio v-for="(item,index) in gender"
                :key="index"
                :label="item"
                :value="index"
            ></v-radio>
          </v-radio-group>
          <!-- <v-col cols="11">
            <v-select
            :items="items"
            label="性別"
            id="gender"
            color="#81cac4"
            v-model="userProfile.gender"
            ></v-select>
          </v-col> -->
          <v-col cols="11">
            <v-text-field
              label="年齢"
              id="age"
              type="number"
              min="0"
              v-model="userProfile.age"
              :readonly="readonlyFlag.age"
              color="#81cac4"
              append-icon="mdi-pencil"
            ></v-text-field>
          </v-col>
          <v-col cols="11">
            <v-textarea
              label="自己紹介"
              id="bio"
              name="input-7-4"
              v-model="userProfile.bio"
              :readonly="readonlyFlag.bio"
              :rules="[rules.bioCounter]"
              counter="200"
              color="#81cac4"
              rows="3"
              row-height="15"
              append-icon="mdi-pencil"
            ></v-textarea>
          </v-col>
        </v-row>
        <v-btn @click="saveUserProfileData" color="#81CAC4" class="submit_btn">変更を保存</v-btn>
        </v-form>
    </v-container>
    <v-container class="sub_profile">
      <v-col v-if="notEntered">
        <p>好みのテイストを３つまで選択して下さい</p>
        <v-chip-group
          v-model="selection"
          active-class="deep-purple accent-4 white--text"
          column
          multiple
          max=3
        >
          <v-chip v-for="taste in tastes" :key="taste.id" :value="taste.id">{{ taste.taste_name }}</v-chip>
        </v-chip-group>
        <v-btn @click="tasteSave" color="#81CAC4" class="submit_btn">変更を保存</v-btn>
      </v-col>
        <v-col v-if="!notEntered">
          <p>性別を登録して追加情報を登録しましょう</p>
        </v-col>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      //バリデーション系の定義　（未対応TypeError: Cannot read property 'length' of undefined　というエラーが出るけど動く）
      rules:  {
      required:value => !!value || "入力必須です。",
      nameCounter:value => value.length <= 20 || "アカウント名は20字以下で入力してください。",
      bioCounter: value => value.length <= 200 || "自己紹介は200字以下で入力してください。",
      },
      //真偽値の定義
      valid: true,
      isDialogOpen: {
        successDialog:false,
        errorDialog:false,
      },
      readonlyFlag:{
        name: false,
        email: true,
        bio: false,
        age: false,
      },
      notEntered:false,

      //データ型の定義  
      userProfile: {},
      fileInfo:"",
      gender: ['レディース', 'メンズ'],
      selection:[],
      tastes: [],
    };
  },
  created() {
  },
  mounted() {
      this.getUserProfileData();
  },
  watch: {
      selection: function(newVal, oldVal) {
      console.log(this.selection);
  },
  },
  methods: {
    //プロフィールの取得
    getUserProfileData: function() {
      axios
        .get("api/get/profile")
        .then(res => {
          this.userProfile = res.data.profile;
          this.tastes = res.data.tastes;
          this.notEntered = res.data.notEntered;
          console.log(res.data);
          console.log(this.userProfile,111);

          this.selectedTasteConvert(res);
        })
        .catch(err => console.log(err));
    },
    //　ダイアログを閉じる
    closeDialog(dialogName){
        this.isDialogOpen[dialogName] = false;
    },
    //　テイストタグのデータを配列に入れる処理
    selectedTasteConvert: function(res) {
        const selectedTasteArray = res.data.selectedTastes;
        const selectedtasteList = selectedTasteArray.map(function(row){
        return [ row["taste_id"] ]
        }).reduce(function(a,b){
          return a.concat(b);
        });
        this.selection = selectedtasteList;
        console.log(this.selection);  
    },
    //画像の処理
    //画像ファイルを設置
    fileSelected(event) {
        const file = event.target.files[0];
        const name = file.name;
        const size = file.size;
        const type = file.type;
        const errors = '';

      //上限サイズを3MB確認
      if (size > 3000000) {
        errors += 'ファイルの上限サイズ3MBを超えています\n'
      }
  
      //.jpg .gif .png . pdf のみ許可
      if (type != 'image/jpeg' && type != 'image/gif' && type != 'image/png' && type != 'application/pdf') {
        errors += '.jpg、.gif、.png、.pdfのいずれかのファイルのみ許可されています\n'
      }
  
      if (errors) {
        //errorsが存在する場合は内容をalert
        alert(errors)
        //valueを空にしてリセットする
        event.currentTarget.value = ''
      }
      this.fileInfo = event.target.files[0];
      this.userProfile.image = window.URL.createObjectURL(this.fileInfo);
    },
    //formのデータを定義
    setUserProfileData() {
      let formData = new FormData();

      Object.keys(this.userProfile).forEach(key=>{
          console.log(key,this.userProfile[key])
          formData.append(key, this.userProfile[key]);
      });
      formData.append("image", this.fileInfo);

      return formData;
    },
    //変更を保存
    saveUserProfileData: function() {
      //入力値のエラーを確認
      if (this.$refs.form.validate()) {

        const formData = this.setUserProfileData();
        console.log(this.userProfile.image);

        // let formData = new FormData();
        // formData.append("image", this.fileInfo);
        // formData.append("name", this.user.name);
        // formData.append("email", this.user.email);
        // this.user.bio
        //   ? formData.append("bio", this.user.bio)
        //   : formData.append("bio", "");
        // this.user.age
        //   ? formData.append("age", this.user.age)
        //   : formData.append("age", "");
        // this.user.gender
        //   ? formData.append("gender", this.user.gender)
        //   : formData.append("gender", "");
        
        var config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
        axios
          .post("api/edit/profile", formData, config)
          .then(res => {
            console.log(res.data.profile);
            const updatedUserProfile = res.data.profile;
            const updatedUserGender = parseInt(updatedUserProfile.gender);
            this.isDialogOpen.successDialog = true;
            // this.userProfile = updatedUserProfile;
            this.userProfile.gender = updatedUserGender;
            // 性別の判断
            if(updatedUserGender){
              this.userProfile.gender = this.gender[updatedUserGender];
            }
          })
          .catch(err => {
            this.isDialogOpen.errorDialog = true;
            console.log(err);
            }) 
      } else {
        console.log('エラーがあるよ！');
      }
    },
    //　テイスト情報を取得
    tasteSave: function() {
      axios
        .post("api/edit/tastes",{
          tastes_id: this.selection
        })
        .then(res => {
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
  }
};
</script>

<style scoped>
.v-subheader {
  font-size: 0.7rem;
}

.wrap {
  width: 100%;
  background-color:#fafafa;
  margin-bottom: 56px;
}

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

.image_container {
  position: relative;
}

.add_btn {
  position: absolute;
  top: 80px;
  right: 33%;
  background: #81cac4;
  padding: 4px;
  border-radius: 50%;
}

.add_btn:hover {
  opacity: 0.7;
}

.bio {
  background-color: #ddd;
  border-radius: 8px;
}

.input_area {
  width: 90%;
  display: flex;
}

.v-input__control {
  width: 50%;
}

.user_profile input {
  opacity: 0;
}

.submit_btn {
  color: #fff;
  font-weight: bold;
}

.sub_profile{
  width: 95%;
  margin:1em auto;
  background: #fafafa;
}
</style>