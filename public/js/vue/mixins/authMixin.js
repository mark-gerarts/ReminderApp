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
        authRegister: function(data) {
            this.submitting = true;

            this.$http.post('api/register', data).then(function(response) {
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
                if(error.data.email[0] == "The email has already been taken.")
                {
                    this.errorMessage = "The email has already been taken.";
                }
                this._openErrorWindow(error.data);
            }).finally(function() {
                this.submitting = false;
            });
        },
        getUserInfo: function() {
            this.fetchingUser = true;

            this.$http.get('api/user').then(function(response) {
                var data = JSON.parse(localStorage.getItem('remindme_storage'));
                data.user = response.data;
                localStorage.setItem('remindme_storage', JSON.stringify(data));
                authStore.setUser(response.data);
                router.go('/home');
            }, function(error) {
                console.log(error)
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                this._openErrorWindow(error.data);
            }).finally(function() {
                this.fetchingUser = false;
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
