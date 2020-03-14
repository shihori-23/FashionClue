<template>
    <div>
        <div class="container">
            <a class="btn-border" v-if="!isBookmarked" @click="BookmarkOperationAtClick">
            <!-- <a class="btn-border" v-if="!isBookmarked" @click="addBookmark(post_id)"> -->
                <v-icon>mdi-heart-outline</v-icon>
            </a>
            <a class="btn-border" v-else @click="removeBookmarkOperationAtClick">
            <!-- <a class="btn-border" v-else @click="removeBookmark(post_id)"> -->
                <v-icon color="#fbadff">mdi-heart</v-icon>
            </a>
        </div>
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
            // originIsBookmarked: this.isBookmarked,
        };
    },
    methods: {
        BookmarkOperationAtClick(){
            this.$emit('add-post-bookmark');
        },
        removeBookmarkOperationAtClick(){
            this.$emit('remove-post-bookmark');
        },
    //一旦残しておきます！
    //     addBookmark(id) {
    //     axios
    //         .post("api/post/post_bookmark/" + id)
    //         .then(res => {
    //         console.log(res.data.isBookmarked);
    //         this.originIsBookmarked = true;
    //         })
    //         .catch(err => console.log(err));
    //     },

    //     removeBookmark(id) {
    //     axios
    //         .post("api/destory/post_bookmark/" + id)
    //         .then(res => {
    //         console.log(res.data.isBookmarked);
    //         this.originIsBookmarked = false;
    //         })
    //         .catch(err => console.log(err));
    //     }
     //一旦残しておきます！
    }
};
</script>
<style scoped>
a {
    text-decoration: none;
}
</style>
