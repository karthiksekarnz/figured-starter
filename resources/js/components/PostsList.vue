<template>
    <div class="container">
        <div class="text-center p-5" v-if="loading">
            <b-spinner variant="primary" type="grow"></b-spinner>
        </div>
        <div v-else>
            <router-link :to="{ name: 'PostCreate'}" class="btn btn-primary" v-if="isAdmin">Create Post</router-link>
            <ul v-if="posts">
                <li class="post" v-for="post in posts">
                    <router-link :to="{ name: 'Post', params: {slug: post.slug}}">
                        <h3>{{ post.title }}</h3>
                        <div class="pt-1">
                            Read More
                        </div>
                    </router-link>
                </li>
            </ul>
            <div v-if="posts.length === 0" class="text-center p-5">
                <h5>No posts yet.</h5>
                <router-link :to="{ name: 'PostCreate'}" class="btn btn-primary">Create Post</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
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
        },
        computed: {
            ...mapGetters({
                isAdmin: 'user/isAdmin'
            })
        }
    }
</script>

<style lang="scss" scoped>
    ul {
        padding: 0;
        margin-top: 20px;

        a {
            color: #888888;
            text-decoration: none;
        }

        li {
            padding: 10px;

            &:hover {
                background: #f9f9f9;
            }

            list-style: none;
        }
    }

</style>
