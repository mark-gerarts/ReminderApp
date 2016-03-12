var authMixin = {
    methods: {
        _openErrorWindow: function(msg) {
            var win = window.open("", "Title");
            win.document.body.innerHTML = msg;
        },

        authSignIn: function(data) {
            this.$http.post('api/login', data).then(function(response) {
                console.log(response)
                authStore.setAuthenticationStatus(true);
                authStore.setUser(response.data.user);
                this.setToken(response.data.token);
                router.go('/home');
            }, function(error) {
                console.log('error')
                console.log(error);
                this._openErrorWindow(error.data);
            });
        },
        authLogOut: function() {
            localStorage.removeItem('jwt_token');
            localStorage.removeItem('jwt_created_at');
        },
        setToken: function(token) {
            localStorage.setItem('jwt_token', token);
            localStorage.setItem('jwt_created_at', new Date());
            Vue.http.headers.common['Authorization'] = 'Bearer: ' + token;
        }
    }
};
