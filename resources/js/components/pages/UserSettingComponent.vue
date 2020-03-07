<template>
  <div class="wrap">
    <v-container class="main_profile text-center">
      <h2 class="subtitle-1">プロフィール編集</h2>
      <div class="text-center">
        <v-dialog v-model="dialog" width="400">
          <v-card>
            <v-card-title class="headline grey lighten-2" primary-title>プロフィールを保存しました</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="dialog = false">閉じる</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </div>

      <div class="image_container">
        <div class="image">
          <img :src="user.image"/>
        </div>
        <label class="user_profile" for="user_profile">
          <!-- <v-btn color="#81cac4" fab small> -->
          <v-icon color="#fff" class="add_btn">mdi-camera</v-icon>
          <!-- </v-btn> -->
          <!-- <span>ファイルを選択</span> -->
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
            v-model="user.name"
            color="#81cac4"
            :readonly="readonly_name"
            append-icon="mdi-pencil"
          ></v-text-field>
        </v-col>
        <v-col cols="11">
          <v-text-field
            label="email"
            id="email" 
            v-model="user.email" 
            :readonly="readonly_email" 
            color="#81cac4" 
            append-icon="mdi-information-outline"
            ></v-text-field>
        </v-col>
        <v-col cols="11">
          <v-select
          :items="items"
          label="性別"
          id="gender"
          color="#81cac4"
          v-model="user.gender"
          ></v-select>
        </v-col>
        <v-col cols="11">
          <v-text-field
            label="age"
            id="age"
            v-model="user.age"
            :readonly="readonly_age"
            color="#81cac4"
            append-icon="mdi-pencil"
          ></v-text-field>
        </v-col>
        <v-col cols="11">
          <v-textarea
            label="自己紹介"
            id="bio"
            name="input-7-4"
            v-model="user.bio"
            :readonly="readonly_bio"
            color="#81cac4"
            rows="3"
            row-height="15"
            append-icon="mdi-pencil"
          ></v-textarea>
        </v-col>
      </v-row>
      <v-btn @click="saveUserProflile" color="#81CAC4" class="submit_btn">変更を保存</v-btn>
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
          <v-chip v-for="taste in tastes" :key="taste.id" :value="taste.tastes_name">{{ taste.taste_name }}</v-chip>
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
      rules: {
        required: value => !!value || "Required.",
        counter: value => value.length <= 20 || "Max 20 characters"
      },
      dialog: false,
      fileInfo: "",
      user: {},
      gender:"",
      items: ['レディース', 'メンズ'],
      readonly_name: false,
      readonly_email: true,
      readonly_bio: false,
      readonly_age: false,
      selection:"",
      tastes: [],
      notEntered:false,
    };
  },
  created() {
    this.getProfile();
  },
  watch: {
      selection: function(newVal, oldVal) {
      console.log(this.selection);
  },
  },
  methods: {
    //プロフィールの取得
    getProfile: function() {
      axios
        .get("api/get/profile")
        .then(res => {
          this.user = res.data.profile;
          this.tastes = res.data.tastes;
          this.notEntered = res.data.notEntered;
          console.log(res.data);

          // 性別の判断
          if(res.data.profile.gender == 0){
              this.user.gender = this.items[0];
              console.log("レディース");
          } else if (res.data.profile.gender == 1){
              this.user.gender = this.items[1];
              console.log("メンズ");
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
          this.selection = selectedtasteList;   
    },
    //画像の処理
    //画像ファイルを設置
    fileSelected(event) {
      this.fileInfo = event.target.files[0];
      this.user.image = window.URL.createObjectURL(this.fileInfo);
    },
    //変更を保存
    //めんどくさい三項演算子の部分はnullの文字列入っちゃう対策
    saveUserProflile: function() {
      let formData = new FormData();
      formData.append("image", this.fileInfo);
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      this.user.bio
        ? formData.append("bio", this.user.bio)
        : formData.append("bio", "");
      this.user.age
        ? formData.append("age", this.user.age)
        : formData.append("age", "");
      this.user.gender
        ? formData.append("gender", this.user.gender)
        : formData.append("gender", "");
      
      var config = {
        headers: {
          "content-type": "multipart/form-data"
        }
      };
      axios
        .post("api/edit/profile", formData, config)
        .then(res => {
          this.dialog = true;
          this.user = res.data.profile;

          console.log(res.data.profile.image);
          // 性別の判断
          if(res.data.profile.gender == 0){
              this.user.gender = this.items[0];
          } else if (res.data.profile.gender == 1){
              this.user.gender = this.items[1];
          }
        })
        .catch(err => console.log(err));
    },
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