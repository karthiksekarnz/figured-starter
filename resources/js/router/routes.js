import Welcome from '../components/Welcome.vue'
import PostsList from '../components/PostsList.vue'
import Post from '../components/Post.vue'
import PostCreate from "../components/PostCreate.vue";

const routes = [
    {
        path: '/',
        name: 'Welcome',
        component: Welcome
    },
    {
        path: '/posts',
        name: 'PostsList',
        component: PostsList
    },
    {
        path: '/p/:slug',
        name: 'Post',
        component: Post
    },

    {
        path: '/post/create',
        name: 'PostCreate',
        component: PostCreate
    },

    {
        path: '*',
        redirect: {
            name: 'Welcome',
        },
    },
];

export default routes
