<script>
    import _ from 'lodash';
    import ApiService from "../services/api.service";
    import API_ENDPOINTS from "../helpers/api.endpoints";
    import { mapGetters, mapMutations } from 'vuex';
    import { TokenService } from "../services/token.service"

    export default {
        name: 'Navbar',
        data() {
            return {
                saving: false,
                loggingOut: false,
                loginForm: {
                    email: null,
                    password: null
                },
                errors: null,
                signupForm: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null
                }
            }
        },

        mounted() {
            this.$root.$on('bv::modal::hide', () => {
                this.errors = null
            });
        },

        computed: {
            ...mapGetters({
                user: 'user/get',
                isLoggedIn: 'user/isLoggedIn'
            })
        },

        methods: {
            ...mapMutations({
                setUser: 'user/set',
                setLoggedIn: 'user/setLoggedIn'
            }),

            login() {
                this.errors = null;
                this.saving = true;

                ApiService.post(API_ENDPOINTS.login, this.loginForm)
                    .then(response => {
                        this.saving = false;
                        this.$bvModal.hide('loginModal');

                        let payload = response.data;
                        TokenService.setAccessToken(payload.token.access_token);
                        this.errors = null;
                        this.setUser(payload.user);
                        this.setLoggedIn(true);

                        this.$router.push({name: 'PostsList'});
                    })
                    .catch(e => {
                        this.saving = false;
                        let error = e.response.data;
                        this.errors = error.errors;
                    });
            },

            signup() {
                this.errors = null;
                this.saving = true;

                ApiService.post(API_ENDPOINTS.signup, this.signupForm)
                    .then(response => {
                        this.$bvModal.hide('signupModal');
                        let payload = response.data;
                        TokenService.setAccessToken(payload.token.access_token);
                        this.errors = null;
                        this.setUser(payload.user);
                        this.setLoggedIn(true);

                        this.$router.push({name: 'PostsList'})
                    })
                    .catch(e => {
                        let error = e.response.data;
                        this.errors = error.errors;
                    });
            },

            logout() {
                this.loggingOut = true;

                ApiService.post(API_ENDPOINTS.logout, {})
                    .then(response => {
                        this.loggingOut = false;
                        this.reset();
                        this.$router.push({name: 'Welcome'})
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },

            reset() {
                TokenService.removeTokens();
                this.$router.push({ name: 'Welcome'});
                this.setUser(null);
                this.setLoggedIn(null);
            }
        }
    }
</script>
<template>
    <nav class="navbar top-navbar fixed-top navbar-expand-md navbar navbar-light">
        <div class="container">
            <div class="navbar-brand mr-3">
                <router-link :to="'/'"><img src="https://laravel.com/img/logomark.min.svg" /></router-link>
            </div>
            <div class="pull-right">
                <div v-if="isLoggedIn">
                    <router-link :to="{ name: 'PostsList'}" class="mr-5">Posts</router-link>
                    <span class="mr-2">{{ user.name }}</span>
                    <b-button class="btn btn-primary" v-if="loggingOut" disabled>Bye...</b-button>
                    <b-button class="btn btn-primary" @click="logout" v-else>Logout</b-button>
                </div>
                <div v-if="!isLoggedIn">
                    <b-button class="btn btn-primary" v-b-modal.loginModal :disabled="saving">Log In</b-button>
                    <b-button class="btn btn-primary" v-b-modal.signupModal :disabled="saving">Sign up</b-button>
                </div>


                <b-modal id="loginModal" title="Login" hide-footer>
                    <div v-if="errors" class="error-feedback">
                        <div v-for="error in errors">
                            {{ error[0] }}
                        </div>
                    </div>
                    <b-form @submit.prevent="login">
                        <div class="form-group">
                            <label>Email</label>
                            <b-form-input class="form-control" type="email" v-model="loginForm.email"></b-form-input>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <b-form-input class="form-control" type="password" v-model="loginForm.password"></b-form-input>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" v-if="saving" disabled>Logging in...</button>
                            <button class="btn btn-primary btn-block" type="submit" v-else>Login</button>
                        </div>
                    </b-form>
                </b-modal>

                <b-modal id="signupModal" title="Sign up" hide-footer>
                    <div v-if="errors" class="error-feedback">
                        <div v-for="error in errors">
                            {{ error[0] }}
                        </div>
                    </div>
                    <b-form @submit.prevent="signup">
                        <div class="form-group">
                            <label>Name</label>
                            <b-form-input class="form-control" type="text" v-model="signupForm.name"></b-form-input>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <b-form-input class="form-control" type="email" v-model="signupForm.email"></b-form-input>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <b-form-input v-model="signupForm.password" class="form-control" type="password"></b-form-input>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <b-form-input v-model="signupForm.password_confirmation" class="form-control" type="password"></b-form-input>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" disabled v-if="saving">Signing up...</button>
                            <button class="btn btn-primary btn-block" type="submit" v-else>Sign up</button>
                        </div>
                    </b-form>
                </b-modal>
            </div>
        </div>
    </nav>
</template>
<style scoped>
    .top-navbar {
        padding: 0 50px;
        height: 72px;
        background: #ffffff;
        color: #121212;
        box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.3);
    }
</style>
