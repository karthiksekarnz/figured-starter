/**
 * Token service is a storage service for authentication tokens
 */
const TokenService = {
    getAccessToken() {
        return localStorage.getItem('access_token');
    },
    setAccessToken(token) {
        localStorage.setItem('access_token', token);
    },
    removeTokens() {
        localStorage.removeItem('access_token');
    }
};

export { TokenService };
