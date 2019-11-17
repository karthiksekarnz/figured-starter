<template>
    <div class="min-h-screen d-flex flex-column" v-if="loaded">
        <navbar></navbar>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
    import { mapActions, mapMutations } from 'vuex';

    export default {
        name: "App",
        data() {
            return {
                loaded: false
            }
        },
        async mounted() {
            try {
                let response = await this.getUser();
                let user = response.data.user;
                this.setUser(user);
                this.setLoggedIn(true);

                this.loaded = true;
            } catch (e) {
                if (e.response && e.response.status === 401) {
                    localStorage.clear();
                    this.loaded = true;
                }
            }
        },
        methods: {
            ...mapActions({
                getUser: 'user/getAsync'
            }),

            ...mapMutations({
                setUser: 'user/set',
                setLoggedIn: 'user/setLoggedIn'
            }),
        }
    }
</script>

<style scoped>
    main {
        flex-grow: 2;
        padding: 100px 0;
    }

    .min-h-screen {
        min-height: 100vh;
    }
</style>
