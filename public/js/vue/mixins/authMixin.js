var authMixin = {
    methods: {
        _openErrorWindow: function(msg) {
            var win = window.open("", "Title");
            win.document.body.innerHTML = msg;
        },
        authSignIn: function(data) {
            this.submitting = true;

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
                console.log(error)
                if(error.data.error == "invalid_credentials")
                {
                    this.errorMessage = "Invalid credentials";
                }
                //this._openErrorWindow(error.data);
            }).finally(function() {
                this.submitting = false;
            });
        },
        authLogOut: function() {
            localStorage.removeItem('remindme_storage');
            authStore.setAuthenticationStatus(false);
            authStore.setUser(null);
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
