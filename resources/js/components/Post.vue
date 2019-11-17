
<script>
    import ApiService from "../services/api.service";
    import API_ENDPOINTS from "../helpers/api.endpoints";

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

        methods: {
            onEdit (operation) {
                this.content = operation.api.origElements.innerHTML
            },

            save() {
                this.saving = true;

                ApiService.put(API_ENDPOINTS.editPost.replace(':id', this.post._id) , {
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
        <b-spinner variant="primary" type="grow" label="Spinning" v-if="loading || saving"></b-spinner>
        <b-form @submit.prevent="save" v-else>
            <h2>{{ title }}</h2>
            <medium-editor :options="options" v-on:edit="onEdit" :text="content" />
            <nav class="navbar bottom-nav bg-dark fixed-bottom navbar-expand-md navbar-light">
                <div class="container px-0 py-2">
                    <div class="col-12 p-0 ">
                        <router-link :to="{ name: 'PostsList'}" class="btn btn-light float-right">Cancel</router-link>
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
