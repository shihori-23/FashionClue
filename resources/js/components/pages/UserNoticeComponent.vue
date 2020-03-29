<template>
  <v-container>
    <v-list three-line>
      <v-subheader>通知</v-subheader>
      <p>{{hello}}</p>
      <v-list-item-group>
        <div v-for="(notice, i) in userNoticeData" :key="i" class="notice_container">
          <v-list-item
            :to="{
                  name: 'UserPostDetail',
                  params: { postId: notice.post_id }
          }"
          >
            <v-list-item-avatar size="40" v-if="notice.review_owner_image">
              <v-img :src="notice.review_owner_image"></v-img>
            </v-list-item-avatar>
            <v-list-item-avatar size="40" v-else-if="notice.answer_owner_image">
              <v-img :src="notice.answer_owner_image"></v-img>
            </v-list-item-avatar>
            <v-list-item-content v-if="notice.role == 0" :style="styleObject">
              <v-list-item-subtitle v-if="notice.answer_owner_id">
                {{ notice.answer_owner_name }}さんがあなたの質問に回答しました！
                <MomentJs :time="notice.created_at" />
              </v-list-item-subtitle>
              <v-list-item-subtitle v-else-if="notice.review_owner_id">
                {{ notice.review_owner_name }}さんがあなたの回答に対して評価を付けました！
                <MomentJs :time="notice.created_at" />
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-content v-else>
              <v-list-item-subtitle v-if="notice.answer_owner_id">
                {{ notice.answer_owner_name }}さんがあなたの質問に回答しました！
                <MomentJs :time="notice.created_at" />
              </v-list-item-subtitle>
              <v-list-item-subtitle v-else-if="notice.review_owner_id">
                {{ notice.review_owner_name }}さんがあなたの回答に対して評価を付けました！
                <MomentJs :time="notice.created_at" />
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </div>
      </v-list-item-group>
    </v-list>
  </v-container>
</template>
<script>
import MomentJs from "../items/MomentJs";
import Mixin from "../../mixin";

export default {
  components: {
    MomentJs
  },
  /**
   *
   * @param {Object} userNoticeData・・・・通知用データを管理
   * @param {Object} styleObject・・・・通知用データを管理
   *
   **/
  data() {
    return {
      userNoticeData: {},
      styleObject: {
        fontWeight: "bold"
      }
    };
  },
  mixins: [Mixin],
  created() {
    this.getNoticeData();
  },
  methods: {
    getNoticeData: function() {
      axios
        .get("api/get/notice")
        .then(res => {
          console.log(res.data);
          this.userNoticeData = res.data.userNoticeData;
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style scoped>
</style>