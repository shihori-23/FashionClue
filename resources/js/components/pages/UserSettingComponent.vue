<template>
    <div class="wrap">
        <v-container class="main_profile text-center">
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
                                color="#996666"
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
                                color="#996666"
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
                        <img :src="previewImage" />
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
                            color="#996666"
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
                            color="#996666"
                            append-icon="mdi-information-outline"
                        ></v-text-field>
                    </v-col>
                    <v-radio-group
                        v-model="userProfile.gender"
                        row
                        label="性別"
                        id="genderRadio"
                        color="#996666"
                    >
                        <v-radio
                            v-for="(item, name, index) in gender"
                            name="gender"
                            :key="index"
                            :label="item"
                            :value="parseInt(name)"
                            color="#996666"
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
                            color="#996666"
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
                            color="#996666"
                            rows="3"
                            row-height="15"
                            append-icon="mdi-pencil"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-btn
                    @click="saveUserProfileData"
                    outlined
                    color="#996666"
                    class="submit_btn"
                    >変更を保存</v-btn
                >
            </v-form>
        </v-container>
        <v-container class="sub_profile text-center">
            <v-col v-if="filledUserGender">
                <p>好みのテイストを３つまで選択して下さい</p>
                <v-chip-group
                    v-model="selectedTastes"
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
                    color="#996666"
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

import mixins from '../../mixin';
import {mapState, mapMutations,mapActions} from 'vuex';

export default {
    components: {
        // VueCropper
    },
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
         * @param {Object} selectedTastes・・・選択済のテイストを管理
         * @param {Array} tastes・・・テイストのデータを管理
         * @param {String} previewImage・・・プレビュー画像表示
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
            previewImage: "",
            gender: {
                1: "レディース",
                2: "メンズ"
            },
            selectedTastes: [],
            tastes: [],
            axiosErrorMessages: []
        };
    },
    created() {},
    mounted() {
        this.getUserProfileData();
    },
    watch: {
        selectedTastes: function(newVal, oldVal) {
            console.log(this.selectedTastes);
        }
    },
    mixins:[mixins],
    computed:{
        ...mapState({
            userProfile: (state)=>state.userProfileData.userProfile
        })
    },
    methods: {
        ...mapMutations({
            setUserProfile: 'userProfileData/setUserProfile'
        }),
        //プロフィールの取得
        async getUserProfileData() {
            const _this = this;
            const responseData = await axios.get("api/profile/get")
            const userProfileData = responseData.data;

            this.setUserProfile(userProfileData)
            this.previewImage = userProfileData.userProfile.image

            if(userProfileData.selectedTastes.length > 0){
                _this.selectedTasteConvert(userProfileData.selectedTastes);
            }
        },

        //　テイストタグのデータを配列に入れる処理
        selectedTasteConvert(data) {
            this.selectedTastes = data.map(row=>[row["taste_id"]])
                .reduce((a, b) =>a.concat(b));
        },
        //画像の処理
        //画像ファイルを設置
        fileSelected(event) {
            const selectedImageFile = event.target.files[0];
            const imageFileSize = selectedImageFile.size;
            const imageFileType = selectedImageFile.type;

            const validateImage = {
                invalidMsg:"",
                checkFileType(){
                    const limitedFileSize = 3000000;
                    const isOverlimitedSize = imageFileSize > limitedFileSize;

                    if(isOverlimitedSize){
                        validateImageFile.invalidMsg += `ファイルの上限サイズ${limitedFileSize/1000000}MBを超えています\n`;
                        return false
                    }

                    return true;
                },
                checkFileSize(){
                    const permitFileType = ["image/jpeg", "image/gif", "image/gif"];
                    const invalidFileType = !permitFileType.includes(imageFileType)

                    if(invalidFileType){
                        validateImageFile.invalidMsg +=".jpg、.gif、.png、.pdfのいずれかのファイルのみ許可されています\n";
                        return false;
                    }

                    return true;
                }
            };

            const isInvalidImageFile = !validateImage.checkFileType() || !validateImage.checkFileType();

            if (isInvalidImageFile) {
                alert(validateImage.invalidMsg);
                return false;
            }

            this.userProfile.image = selectedImageFile;
            this.previewImage = window.URL.createObjectURL(selectedImageFile);
        },
        //formのデータを定義
        setUserProfileData() {
            let formData = new FormData();

            Object.keys(this.userProfile).forEach(key => {
                if (this.userProfile[key]) {
                    formData.append(key, this.userProfile[key]);
                }
            });

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
            this.isDialogOpen.errorDialog = true;
        },
        //変更を保存
        saveUserProfileData: function() {
            //入力値のエラーを確認
            if (this.$refs.form.validate()) {
                const formData = this.setUserProfileData();

                const config = {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                };

                axios.post("api/profile/edit", formData, config).then(res => {
                    const updatedUserProfile = res.data.userProfile;
                    this.isDialogOpen.successDialog = true;
                }).catch(err => {
                    this.setAxiosErrorData(err);
                    console.log(err.response.data);
                });
            } else {
                console.log("エラーがあるよ！");
            }
        },
        //　テイスト情報を取得
        saveUserTaste: function() {
            axios.post("api/tastes/edit", {
                    tastes_id: this.selectedTastes
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
