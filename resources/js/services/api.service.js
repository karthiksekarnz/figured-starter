/**
 * API service which uses Axios to send http requests for the given resource
 */
import axios from 'axios'
import { TokenService } from './token.service'

const ApiService = {
    get(resource, config = {}) {
        return axios.get(resource, config)
    },

    post(resource, data) {
        return axios.post(resource, data)
    },

    put(resource, data) {
        return axios.put(resource, data)
    },

    delete(resource) {
        return axios.delete(resource)
    }
};

axios.interceptors.request.use((config) => {
    let token = TokenService.getAccessToken();
    if (token) {
        config.headers.Authorization = `Bearer ${TokenService.getAccessToken()}`;
    }

    return config;
}, (error) => {
    return Promise.reject(error);
});

export default ApiService
