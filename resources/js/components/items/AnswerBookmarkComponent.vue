<template>
    <div>
        <button
            class="btn-border bookmarkIcon"
            v-if="!isBookmarked"
            @click="BookmarkOperationAtClick"
        >
            <!-- <span class="lnr lnr-heart"></span> -->
            <v-icon color="#c0c0c0">mdi-heart</v-icon>
        </button>
        <button
            class="btn-border bookmarkIcon"
            v-else
            @click="removeBookmarkOperationAtClick"
        >
            <!-- <span class="lnr lnr-heart isBookmarkedIcon"></span> -->
            <v-icon color="#ed4956">mdi-heart</v-icon>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        answer_id: Number,
        isBookmarked: Boolean
    },
    data() {
        return {};
    },
    methods: {
        BookmarkOperationAtClick() {
            this.$emit("add-answer-bookmark");
        },
        removeBookmarkOperationAtClick() {
            this.$emit("remove-answer-bookmark");
        }
    }
};
</script>
<style scoped>
.bookmarkIcon {
    font-size: 24px;
    color: #808080;
    padding: 8px 6px 12px 12px;
}
</style>
