var Login = Vue.extend({
    template: '#login-template',

    mixins: [authMixin],

    data: function() {
        return {
            formData: {
                email: '',
                password: ''
            }
        }
    },

    methods: {
        _openErrorWindow: function(msg) {
            var win = window.open("", "Title");
            win.document.body.innerHTML = msg;
        },
        signIn: function() {
            this.authSignIn(this.formData, function(response) {
                this.setToken(response.data)
            }, function(error) {
                this._openErrorWindow(error.data);
                console.log(error)
            });
        }
    }
});
