var authMixin = {
    methods: {
        authSignIn: function(data, success, error) {
            this.$http.post('api/login', data).then(success, error);
        },
        setToken: function(token) {
            localStorage.setItem('jwt_token', token);
        }
    }
};
