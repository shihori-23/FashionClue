<template>
    <div>
        <h3>画像を選択</h3>
        <input type="file" name="image" accept="image/*" @change="setImage" />
        <br />
        <div
            v-if="imgSrc != ''"
            style="width: 200px; height:200px; border: 1px solid gray; display: inline-block;"
        >
            <vue-cropper
                ref="cropper"
                :guides="true"
                :view-mode="2"
                drag-mode="crop"
                :auto-crop-area="0.5"
                :min-container-width="200"
                :min-container-height="200"
                :background="true"
                :rotatable="false"
                :src="imgSrc"
                :img-style="{ width: '200px', height: '200px' }"
                :aspect-ratio="yoko / tate"
            >
                :img-styleで読み込んだ画像の大きさを指定
                :aspect-ratioで比率を指定
            </vue-cropper>
            <br />

            <button @click="cropImage" v-if="imgSrc != ''">
                トリミングする
            </button>
        </div>
    </div>
</template>

//
<script>
import VueCropper from "vue-cropperjs"; //ダウンロードしたコンポーネントのインポート
import "cropperjs/dist/cropper.css";

export default {
    components: {
        VueCropper
    },
    data() {
        return {
            imgSrc: "", //トリミング前の画像のソース
            filename: "" //画像の名前
        };
    },
    methods: {
        setImage(e) {
            const file = e.target.files[0];
            this.filename = file.name;
            if (!file.type.includes("image/")) {
                //選択されたものが画像ではなかった場合の処理
                alert("Please select an image file");
                return;
            }
            if (typeof FileReader === "function") {
                const reader = new FileReader();
                reader.onload = event => {
                    this.imgSrc = event.target.result;
                    this.$refs.cropper.replace(event.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                alert("Sorry, FileReader API not supported");
            }
        }
    }
};
</script>
