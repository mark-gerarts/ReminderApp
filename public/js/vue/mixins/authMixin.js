var authMixin = {
    methods: {
        _openErrorWindow: function(msg) {
            var win = window.open("", "Title");
            win.document.body.innerHTML = msg;
        },
        authSignIn: function(data) {
            this.$http.post('api/login', data).then(function(response) {
                authStore.setAuthenticationStatus(true);
                authStore.setUser(response.data.user);
                this.setToken(response.data.token);
                var data = {
                    token: response.data.token,
                    created_at: new Date(),
                    user: response.data.user
                };
                this.setLocalStorage(data);
                router.go('/home');
            }, function(error) {
                this._openErrorWindow(error.data);
            });
        },
        authLogOut: function() {
            localStorage.removeItem('remindme_storage');
            authStore.setAuthenticationStatus(false);
            authStore.setUser(null);
        },
        handleNotLoggedIn: function() {
            
        },
        setToken: function(token) {
            Vue.http.headers.common['Authorization'] = 'Bearer: ' + token;
        },
        setLocalStorage(data) {
            localStorage.setItem('remindme_storage', JSON.stringify(data));
        },
        getLocalStorage() {
            return JSON.parse(localStorage.getItem('remindme_storage'));
        }
    }
};
