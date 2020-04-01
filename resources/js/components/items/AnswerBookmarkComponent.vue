<template>
    <div>
        <div class="container">
            <a class="btn-border" v-if="!isBookmarked" @click="BookmarkOperationAtClick">
                <v-icon>mdi-heart-outline</v-icon>
            </a>
            <a class="btn-border" v-else @click="removeBookmarkOperationAtClick">
                <v-icon color="#fbadff">mdi-heart</v-icon>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        answer_id: Number,
        isBookmarked: Boolean
    },
    data() {
        return {
        
        };
    },
    methods: {
        BookmarkOperationAtClick(){
            this.$emit('add-answer-bookmark');
        },
        removeBookmarkOperationAtClick(){
            this.$emit('remove-answer-bookmark');
        },
    }
};
</script>
<style scoped>
a {
    text-decoration: none;
}
</style>
