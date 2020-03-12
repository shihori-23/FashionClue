<template>
    <div>
        <div class="container">
            <a class="btn-border" v-if="!originIsBookmarked" @click="addLike(post_id)">
                <v-icon>mdi-heart-outline</v-icon>
            </a>
            <a class="btn-border" v-else @click="removeLike(post_id)">
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
            originIsBookmarked: this.isBookmarked,
        };
    },
    methods: {
        addLike(id) {
        axios
            .post("api/post/like/" + id)
            .then(res => {
            console.log(res.data.isBookmarked);
            this.originIsBookmarked = true;
            })
            .catch(err => console.log(err));
        },

        removeLike(id) {
        axios
            .post("api/release/like/" + id)
            .then(res => {
            console.log(res.data.isBookmarked);
            this.originIsBookmarked = false;
            })
            .catch(err => console.log(err));
        }
    }
};
</script>
<style scoped>
a {
    text-decoration: none;
}
</style>
