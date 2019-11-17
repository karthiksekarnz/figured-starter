window.Vue = require('vue');

import Navbar from './Navbar.vue'
import Editor from 'vue2-medium-editor'

Vue.component('navbar', Navbar);
Vue.component('medium-editor', Editor);
