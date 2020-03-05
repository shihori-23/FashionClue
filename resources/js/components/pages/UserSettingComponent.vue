<template>
  <div class="wrap">
    <v-container class="text-center">
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
            @blur="forcusout('name')"
            v-model="user.name"
            color="#81cac4"
            :readonly="readonly_name"
            append-icon="mdi-pencil"
            @click:append="change('name')"
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
          <!-- <v-text-field
            label="性別"
            id="gender"
            v-model="gender"
            :readonly="readonly_gender"
            color="#81cac4"
            append-outer-icon="mdi-pencil"
            @click:append-outer="change('gender')"
          ></v-text-field> -->
        </v-col>
        <v-col cols="11">
          <v-text-field
            label="age"
            id="age"
            v-model="user.age"
            :readonly="readonly_age"
            color="#81cac4"
            append-icon="mdi-pencil"
            @click:append="change('age')"
          ></v-text-field>
        </v-col>
        <v-col cols="11">
          <v-textarea
            label="BIO"
            id="bio"
            name="input-7-4"
            v-model="user.bio"
            :readonly="readonly_bio"
            color="#81cac4"
            append-icon="mdi-pencil"
            @click:append="change('bio')"
          ></v-textarea>
        </v-col>
      </v-row>
      <v-btn @click="save" color="#81CAC4" class="submit_btn">変更を保存</v-btn>
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
      readonly_name: true,
      readonly_email: true,
      readonly_bio: true,
      readonly_age: true,
    };
  },
  created() {
    this.getProfile();
  },

  methods: {
    //プロフィールの取得
    getProfile: function() {
      axios
        .get("api/get/profile")
        .then(res => {
          this.user = res.data.profile;
          // 性別の判断
          if(res.data.profile.gender == 0){
              this.user.gender = this.items[0];
              console.log("レディース");
          } else if (res.data.profile.gender == 1){
              this.user.gender = this.items[1];
              console.log("メンズ");
          }
          console.log(res.data.profile);
          console.log(res.data.profile.gender);
        })
        .catch(err => console.log(err));
    },
    //鉛筆マークを押したらReadOnlyが外れて、フォーカス
    change: function(kind) {
      if (kind == "name") {
        this.readonly_name = false;
      } else if (kind == "email") {
        this.readonly_email = false;
      } else if (kind == "bio") {
        this.readonly_bio = false;
      } else if (kind == "gender") {
        this.readonly_gender = false;
      } else if (kind == "age") {
        this.readonly_age = false;
      } 
      document.getElementById(kind).focus();
    },
    //フォーカス外れたらリードオンリーにする。
    forcusout: function(kind) {
      if (kind == "name") {
        this.readonly_name = true;
      } else if (kind == "email") {
        this.readonly_email = true;
      } else if (kind == "bio") {
        this.readonly_bio = true;
      } else if (kind == "gender") {
        this.readonly_gender = true;
      } else if (kind == "age") {
        this.readonly_age = true;
      }
    },
    //画像の処理
    //画像ファイルを設置
    fileSelected(event) {
      this.fileInfo = event.target.files[0];
      this.user.image_url = window.URL.createObjectURL(this.fileInfo);
    },
    //変更を保存
    //めんどくさい三項演算子の部分はnullの文字列入っちゃう対策
    //appendはinput fileで画像を送信するときに使う。
    save: function() {
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
        .then(res => {;
          this.dialog = true;
          this.user = res.data.profile;
          this.user.image = res.data.profile.image;
          console.log(res.data.profile.image);
          // 性別の判断
          if(res.data.profile.gender == 0){
              this.user.gender = this.items[0];
          } else if (res.data.profile.gender == 1){
              this.user.gender = this.items[1];
          }
        })
        .catch(err => console.log(err));
    }
  }
};
</script>


<style scoped>
.v-subheader {
  font-size: 0.7rem;
}

.wrap {
  margin-bottom: 56px;
}

.image {
  width: 150px;
  margin: 8px auto;
  height: 150px;
  border-radius: 75px;
  position: relative;
}

.image img {
  width: 150px;
  height: 150px;
  border-radius: 75px;
  object-fit: cover;
}

.image_container {
  position: relative;
}

.add_btn {
  position: absolute;
  top: 112px;
  right: 30%;
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

/* .user_profile span {
  display: block;
  color: #fff;
  font-weight: bold;
  font-size: 16px;
  font-family: “游ゴシック”, “Yu Gothic”;
  background: #81cac4;
  padding: 8px 0;
  border-radius: 16px;
  max-width: 168px;
  margin: auto;
  text-align: center;
  transition: 0.3s;
  cursor: pointer;
}
.user_profile span:hover {
  opacity: 0.7;
} */

.user_profile input {
  opacity: 0;
}

.submit_btn {
  color: #fff;
  font-weight: bold;
}
</style>