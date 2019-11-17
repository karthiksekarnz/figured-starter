import API_ENDPOINTS from '../helpers/api.endpoints';
import ApiService from '../services/api.service';

export default {
    namespaced: true,

    state: {
        user: null,
        loggedIn: null
    },

    mutations: {
        set(state, user) {
            state.user = user;
        },
        setLoggedIn(state, status) {
            state.loggedIn = status
        }
    },

    getters: {
        get: state => state.user,
        isLoggedIn: state => state.loggedIn
    },

    actions: {
        fetch: async () => ApiService.get(API_ENDPOINTS.currentUser),

        get({ dispatch, commit }) {
            return dispatch('fetch')
                .then(response => {
                    commit('set', response.data.data);
                });
        },

        async getAsync({ dispatch, commit }) {
            return dispatch('fetch');
        }
    }
}
