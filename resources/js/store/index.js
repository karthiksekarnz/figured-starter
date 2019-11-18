import Vue from 'vue';
import Vuex from 'vuex';
import UserStore from "./user";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        user: UserStore
    }
});

export default store;
