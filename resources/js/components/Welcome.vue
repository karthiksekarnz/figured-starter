<template>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                LaraBlog
            </div>

            <div class="links"></div>
        </div>
    </div>
</template>

<script>
    import { TokenService } from "../services/token.service";

    export default {
        name: "Welcome",
        computed: {
            isLoggedIn() {
                return !! TokenService.getAccessToken()
            }
        },
        mounted() {
            if (this.isLoggedIn) {
                this.$router.push({ name: 'PostsList'});
            }
        }
    }
</script>

<style scoped>
    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
