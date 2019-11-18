import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import VueQuillEditor from 'vue-quill-editor'
import VueToast from 'vue-toast-notification';

Vue.use(BootstrapVue);
Vue.use(VueQuillEditor);
Vue.use(VueToast);

import App from './App.vue'
import router from './router'
import store from './store';

require('./bootstrap');
require('./components/bootstrap');

const app = new Vue({
    el: 'App',
    router,
    store,
    components: { App }
});
