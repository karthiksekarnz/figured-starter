<template>
    <div class="container">
        <div class="text-center p-5" v-if="loading">
            <b-spinner variant="primary" type="grow"></b-spinner>
        </div>
        <div v-else>
            <router-link :to="{ name: 'PostCreate'}" class="btn btn-primary" v-if="isAdmin">Create Post</router-link>
            <div v-if="posts">
                <ul>
                    <li class="post" v-for="post in posts">
                        <router-link :to="{ name: 'Post', params: {slug: post.slug}}">
                            <h4>{{ post.title }}</h4>
                            <div class="pt-1">
                                Read More
                            </div>
                        </router-link>
                    </li>
                </ul>
                <b-pagination v-model="page.current_page" :total-rows="page.total" :per-page="page.per_page" @change="changePage($event)"></b-pagination>
            </div>

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
                page: {},
                loading: false,
                posts: []
            }
        },
        mounted() {
            this.loading = true;

            ApiService.get(API_ENDPOINTS.posts)
                .then(response => {
                    this.loading = false;
                    this.page = response.data;
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
        },
        methods: {
            changePage(page) {
                this.loading = true;

                ApiService.get(API_ENDPOINTS.posts+'?page='+page)
                    .then(response => {
                        this.loading = false;
                        this.page = response.data;
                        this.posts = response.data.data;
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            }
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
