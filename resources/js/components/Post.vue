
<script>
    import ApiService from "../services/api.service";
    import API_ENDPOINTS from "../helpers/api.endpoints";
    import { mapGetters } from 'vuex';

    export default {
        name: "Post",
        data() {
            return {
                post: {},
                title: "",
                content: "",
                options: {},
                loading: false,
                saving: false
            }
        },

        mounted() {
            this.loading = true;

            if (!this.user) {
                this.$router.push({ name: "Welcome"});
            }

            let slug = this.$route.params.slug;

            ApiService.get(API_ENDPOINTS.post.replace(':slug', slug))
                .then((response) => {
                    let post = response.data.data;
                    this.content = post.content;
                    this.title = post.title;
                    this.post = post;

                    this.loading = false;

                })
                .catch(error => {
                    this.loading = false;
                });
        },

        computed: {
            ...mapGetters({
                user: 'user/get',
                isAdmin: 'user/isAdmin'
            })
        },

        methods: {
            onEdit ({ quill, html, text}) {
                this.content = html;
            },

            onDelete() {
                this.loading = true;

                ApiService.delete(API_ENDPOINTS.singlePost.replace(':id', this.post._id))
                    .then(() => {
                        this.loading = false;
                        this.$router.push({ name: 'PostsList'});
                    })
                    .catch(error => {
                        this.loading = false
                    });
            },

            save() {
                this.saving = true;

                ApiService.put(API_ENDPOINTS.singlePost.replace(':id', this.post._id) , {
                    title: this.title,
                    content: this.content
                }).then(() => {
                    this.saving = false;
                })
                .catch(error => {
                    this.saving = false
                });
            }
        }
    }
</script>

<template>
    <div class="container">
        <div class="text-center p-5" v-if="loading || saving">
            <b-spinner variant="primary" type="grow" label="Spinning"></b-spinner>
        </div>

        <b-form @submit.prevent="save" v-else>
            <div v-if="isAdmin">
                <h5>Title</h5>
                <b-form-input placeholder="Enter post title" v-model="title" class="mt-2 mb-4"></b-form-input>
            </div>
            <h2 v-else>{{ title }}</h2>
            <quill-editor :content="content" :options="options" @change="onEdit($event)" v-if="isAdmin"></quill-editor>
            <div v-html="content" v-else></div>
            <nav class="navbar bottom-nav bg-dark fixed-bottom navbar-expand-md navbar-light" v-if="isAdmin">
                <div class="container px-0 py-2">
                    <div class="col-12 p-0 ">
                        <button type="button" class="btn btn-danger float-left mr-2" @click="onDelete($event)">Delete</button>

                        <router-link :to="{ name: 'PostsList'}" class="btn btn-light float-right">Close</router-link>
                        <button type="submit" class="btn btn-primary float-right mr-2">Save</button>
                    </div>
                </div>
            </nav>
        </b-form>

    </div>
</template>

<style lang="scss" scoped>
    .form-control {
        font-size: 1.5rem;
        color: #888888;

        &::placeholder {
            color: #888888;
        }
    }

    .bottom-nav {
        box-shadow: 2px 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
</style>

<style lang="scss">
    .medium-editor-element {
        margin: 0 !important;
        outline: none !important;

        &:focus {
            outline: none !important;
        }
    }
</style>
