<template>
    <div>
        <button
            class="btn-border bookmarkIcon"
            v-if="!isBookmarked"
            @click.prevent="BookmarkOperationAtClick"
        >
            <!-- <span class="lnr lnr-heart"></span> -->
            <v-icon color="#c0c0c0">mdi-heart</v-icon>
        </button>
        <button
            class="btn-border bookmarkIcon"
            v-else
            @click.prevent="removeBookmarkOperationAtClick"
        >
            <!-- <span class="lnr lnr-heart isBookmarkedIcon"></span> -->
            <v-icon color="#ed4956">mdi-heart</v-icon>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        post_id: Number,
        isBookmarked: Boolean
    },
    data() {
        return {
            originIsBookmarked: this.isBookmarked
        };
    },
    methods: {
        BookmarkOperationAtClick() {
            this.$emit("add-post-bookmark");
        },
        removeBookmarkOperationAtClick() {
            this.$emit("remove-post-bookmark");
        }
    }
};
</script>
<style scoped>
.bookmarkIcon {
    font-size: 24px;
    padding: 6px 6px 12px 12px;
}

.btn-border {
    font-size: 24px;
}
</style>
