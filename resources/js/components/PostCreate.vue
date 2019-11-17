
<script>
    import ApiService from "../services/api.service";
    import API_ENDPOINTS from "../helpers/api.endpoints";

    export default {
        name: "PostCreate",
        data() {
            return {
                title: "",
                content: "",
                options: {},
                saving: false
            }
        },
        methods: {
            onEdit (operation) {
                this.content = operation.api.origElements.innerHTML
            },

            save() {
                this.saving = true;

                ApiService.post(API_ENDPOINTS.createPost, {
                    title: this.title,
                    content: this.content
                }).then((response) => {
                    let post = response.data.post;
                    this.saving = false;
                    this.$router.push({ name: 'Post', params: { slug: post.slug}});
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
        <h2>Create Post</h2>
        <b-spinner variant="primary" type="grow" label="Spinning" v-if="saving"></b-spinner>
        <b-form @submit.prevent="save" v-else>
            <b-form-input placeholder="Enter post title" v-model="title" class="mt-2 mb-4"></b-form-input>

            <medium-editor :text="content" :options="options" v-on:edit="onEdit" />
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
    .medium-editor-container {
        padding: 0;

        .medium-editor-element {
            margin: 0 !important;
            outline: none !important;

            &:focus {
                outline: none !important;
            }
        }
    }
</style>
