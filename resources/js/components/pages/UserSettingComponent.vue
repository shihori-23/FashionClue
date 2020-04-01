<template>
    <div class="wrap">
        <v-container class="main_profile text-center">
            <h2 class="subtitle-1">プロフィール編集</h2>
            <div class="text-center">
                <v-dialog v-model="isDialogOpen.successDialog" width="400">
                    <v-card>
                        <v-card-title
                            class="headline lighten-2 text--secondary"
                            color="#3f3f3f"
                            primary-title
                            >Success</v-card-title
                        >
                        <v-card-text
                            >プロフィールの編集が完了しました！</v-card-text
                        >
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="#bc8f8f"
                                text
                                @click="closeDialog('successDialog')"
                                >閉じる</v-btn
                            >
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="isDialogOpen.errorDialog" width="400">
                    <v-card>
                        <v-card-title
                            class="headline lighten-2 text--secondary"
                            primary-title
                            >Error</v-card-title
                        >
                        <v-card-text>
                            <p
                                v-for="(message, index) in axiosErrorMessages"
                                :key="index"
                                class="errorMessage"
                            >
                                ・{{ axiosErrorMessages[index] }}
                            </p>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="#bc8f8f"
                                text
                                @click="closeDialog('errorDialog')"
                                >閉じる</v-btn
                            >
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
            <v-form ref="form" v-model="valid" lazy-validation>
                <div class="image_container">
                    <div class="image">
                        <img :src="fileInfo" />
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
                            color="#bc8f8f"
                            :readonly="readOnly.name"
                            :rules="[
                                validationRules.required,
                                validationRules.nameCounter
                            ]"
                            append-icon="mdi-pencil"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="11">
                        <v-text-field
                            label="email"
                            id="email"
                            v-model="userProfile.email"
                            :readonly="readOnly.email"
                            color="#bc8f8f"
                            append-icon="mdi-information-outline"
                        ></v-text-field>
                    </v-col>
                    <v-radio-group
                        v-model="userProfile.gender"
                        row
                        label="性別"
                        id="genderRadio"
                        color="#81cac4"
                    >
                        <v-radio
                            v-for="(item, index) in gender"
                            name="gender"
                            :key="index"
                            :label="item"
                            :value="index"
                            color="#bc8f8f"
                        ></v-radio>
                    </v-radio-group>
                    <v-col cols="11">
                        <v-text-field
                            label="年齢"
                            id="age"
                            type="number"
                            min="0"
                            v-model="userProfile.age"
                            :readonly="readOnly.age"
                            color="#bc8f8f"
                            append-icon="mdi-pencil"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="11">
                        <v-textarea
                            label="自己紹介"
                            id="bio"
                            name="bio"
                            v-model="userProfile.bio"
                            :readonly="readOnly.bio"
                            :rules="[validationRules.bioCounter]"
                            counter="200"
                            color="#bc8f8f"
                            rows="3"
                            row-height="15"
                            append-icon="mdi-pencil"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-btn
                    @click="saveUserProfileData"
                    outlined
                    color="#bc8f8f"
                    class="submit_btn"
                    >変更を保存</v-btn
                >
            </v-form>
        </v-container>
        <v-container class="sub_profile text-center">
            <v-col v-if="filledUserGender">
                <p>好みのテイストを３つまで選択して下さい</p>
                <v-chip-group
                    v-model="selection"
                    active-class="red accent-3 white--text"
                    column
                    multiple
                    dark
                    max="3"
                    class="tasteChips"
                >
                    <v-chip
                        v-for="taste in tastes"
                        :key="taste.id"
                        :value="taste.id"
                        >{{ taste.taste_name }}</v-chip
                    >
                </v-chip-group>
                <v-btn
                    @click="saveUserTaste"
                    outlined
                    color="#bc8f8f"
                    class="submit_btn"
                    >保存</v-btn
                >
            </v-col>
            <v-col v-else>
                <p>性別を登録して追加情報を登録しましょう</p>
            </v-col>
        </v-container>
    </div>
</template>

<script>
// import { VueCropper } from "vue-cropper";

export default {
    components: {},
    data() {
        /**
         *
         * @param {Object} validationRules・・・・・・・バリデーションルールの設定
         * @param {Boolean} valid・・・・・・・バリデーションチェック用の真偽値
         * @param {Object} readOnly・・・各フォームが読み取り専用かどうかの状態を管理
         * @param {Object} isDialogOpen・・・Dialogの表示非表示を管理。
         * @param {Boolean} filledUserGender・・・性別の登録があるか管理
         * @param {Object} userProfile・・・ユーザーのプロフィールデータを管理
         * @param {Array} gender・・・性別データを管理
         * @param {Object} selection・・・選択済のテイストを管理
         * @param {Array} tastes・・・テイストのデータを管理
         * @param {String} fileInfo・・・画像プレビュー用のURLを管理
         * @param {Array} axiosErrorMessages・・・DB側のバリデーションエラーを受け取る
         *
         **/
        return {
            validationRules: {
                required: value => !!value || "入力必須です。",
                nameCounter: value =>
                    (value || "").length <= 20 ||
                    "アカウント名は20字以下で入力してください。",
                bioCounter: value =>
                    (value || "").length <= 200 ||
                    "自己紹介は200字以下で入力してください。"
            },
            //真偽値の定義
            valid: true,
            isDialogOpen: {
                successDialog: false,
                errorDialog: false
            },
            readOnly: {
                name: false,
                email: true,
                bio: false,
                age: false
            },
            filledUserGender: false,

            //データ型の定義
            userProfile: {},
            fileInfo: "",
            gender: ["レディース", "メンズ"],
            selection: [],
            tastes: [],
            axiosErrorMessages: []
        };
    },
    created() {},
    mounted() {
        this.getUserProfileData();
    },
    watch: {
        selection: function(newVal, oldVal) {
            console.log(this.selection);
        }
    },
    methods: {
        //プロフィールの取得
        getUserProfileData: function() {
            axios
                .get("api/profile/get")
                .then(res => {
                    this.userProfile = res.data.profile;
                    this.userProfile.gender = parseInt(res.data.profile.gender);
                    this.tastes = res.data.tastes;
                    this.filledUserGender = res.data.filledUserGender;
                    this.fileInfo = res.data.profile.image;
                    console.log(res.data);
                    console.log(this.userProfile, 111);

                    this.selectedTasteConvert(res);
                })
                .catch(err => console.log(err));
        },
        //　ダイアログを閉じる
        closeDialog(dialogName) {
            this.isDialogOpen[dialogName] = false;
        },
        //　テイストタグのデータを配列に入れる処理
        selectedTasteConvert: function(res) {
            const selectedTasteArray = res.data.selectedTastes;
            const selectedtasteList = selectedTasteArray
                .map(function(row) {
                    return [row["taste_id"]];
                })
                .reduce(function(a, b) {
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
            const errors = "";

            //上限サイズを3MB確認
            if (size > 3000000) {
                errors += "ファイルの上限サイズ3MBを超えています\n";
            }

            //.jpg .gif .png . pdf のみ許可
            if (
                type != "image/jpeg" &&
                type != "image/gif" &&
                type != "image/png" &&
                type != "application/pdf"
            ) {
                errors +=
                    ".jpg、.gif、.png、.pdfのいずれかのファイルのみ許可されています\n";
            }

            if (errors) {
                //errorsが存在する場合は内容をalert
                alert(errors);
                //valueを空にしてリセットする
                event.currentTarget.value = "";
            }
            this.userProfile.image = event.target.files[0];
            this.fileInfo = window.URL.createObjectURL(this.userProfile.image);
        },
        //formのデータを定義
        setUserProfileData() {
            let formData = new FormData();
            const genderRole = parseInt(this.userProfile.gender);

            Object.keys(this.userProfile).forEach(key => {
                if (this.userProfile[key]) {
                    console.log(key, this.userProfile[key]);
                    formData.append(key, this.userProfile[key]);
                }
            });
            formData.append("gender", genderRole);
            console.log(genderRole);
            return formData;
        },
        //　サーバー側からのエラーを定義
        setAxiosErrorData: function(err) {
            const axiosErrorRes = err.response.data;
            let axiosErrorMessageArray = [];

            if (axiosErrorRes.errors) {
                const axiosvalidationErrorRes = axiosErrorRes.errors;

                axiosErrorMessageArray = Object.keys(
                    axiosvalidationErrorRes
                ).map(dataField => {
                    return axiosvalidationErrorRes[dataField][0];
                });
            } else {
                axiosErrorMessageArray.push(
                    "回答が送信されませんでした。再度送信してください。"
                );
            }
            this.axiosErrorMessages = axiosErrorMessageArray;
            console.log(this.axiosErrorMessages);
            this.isDialogOpen.errorDialog = true;
        },
        //変更を保存
        saveUserProfileData: function() {
            //入力値のエラーを確認
            if (this.$refs.form.validate()) {
                const formData = this.setUserProfileData();
                console.log(this.userProfile.image);

                var config = {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                };
                axios
                    .post("api/profile/edit", formData, config)
                    .then(res => {
                        console.log(res.data.profile);
                        const updatedUserProfile = res.data.profile;
                        const updatedUserGender = parseInt(
                            updatedUserProfile.gender
                        );
                        this.isDialogOpen.successDialog = true;
                        // this.userProfile = updatedUserProfile;
                        this.userProfile.gender = updatedUserGender;
                    })
                    .catch(err => {
                        this.setAxiosErrorData(err);
                        console.log(err.response.data);
                    });
            } else {
                console.log("エラーがあるよ！");
            }
        },
        //　テイスト情報を取得
        saveUserTaste: function() {
            axios
                .post("api/tastes/edit", {
                    tastes_id: this.selection
                })
                .then(res => {
                    console.log(res.data);
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
    width: 100%;
    background-color: #fafafa;
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
    background: #bc8f8f;
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
    margin: 0 auto;
}

.sub_profile {
    width: 95%;
    margin: 1em auto;
    background: #fafafa;
}

.tasteChips {
    margin-bottom: 16px;
}

/* Dialog */
.errorMessage {
    margin-bottom: 0;
}
</style>
