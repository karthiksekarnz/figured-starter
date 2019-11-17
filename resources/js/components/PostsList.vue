<template>
    <div class="container">
        <div class="text-center p-5" v-if="loading">
            <b-spinner variant="primary" type="grow"></b-spinner>
        </div>

        <ul v-if="!loading && posts">
            <li v-for="post in posts">
                <router-link :to="{ name: 'Post', params: {slug: post.slug}}">{{ post.title }}</router-link>
            </li>
        </ul>

        <div v-if="!loading && posts.length === 0" class="text-center p-5">
            <h5>No posts yet.</h5>
            <router-link :to="{ name: 'PostCreate'}" class="btn btn-primary">Create Post</router-link>
        </div>
    </div>
</template>

<script>
    import ApiService from "../services/api.service";
    import API_ENDPOINTS from "../helpers/api.endpoints";

    export default {
        name: "PostsList",
        data() {
            return {
                loading: false,
                posts: []
            }
        },
        mounted() {
            this.loading = true;

            ApiService.get(API_ENDPOINTS.posts)
                .then(response => {
                    this.loading = false;
                    this.posts = response.data.data;
                })
                .catch(error => {
                    this.loading = false;
                });
        }
    }
</script>

<style scoped>

</style>
