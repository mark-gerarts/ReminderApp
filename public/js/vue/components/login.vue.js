var Login = Vue.extend({
    template: '#login-template',

    mixins: [authMixin],

    data: function() {
        return {
            formData: {
                email: '',
                password: ''
            },
            submitting: false
        }
    },

    methods: {
        signIn: function() {
            this.authSignIn(this.formData);
        }
    }
});
