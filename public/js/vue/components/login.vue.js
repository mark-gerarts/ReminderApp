/*
 *
 *   Component for the login page.
 *
 */

var Login = Vue.extend({
    template: '#login-template',

    mixins: [authMixin, validatorMixin],

    data: function() {
        return {
            formData: {
                email: '',
                password: ''
            },
            submitting: false,
            errorMessage: '',
            isSubmittedOnce: false,
            validationErrors: {}
        }
    },

    methods: {
        validate: function() {
            if(this.isSubmittedOnce) {
                this.$set('validationErrors', this.validateLogin(this.formData));
            }
        },
        signIn: function() {
            this.errorMessage = '';
            this.isSubmittedOnce = true;
            this.validate();

            if(Object.keys(this.validationErrors).length == 0) {
                this.authSignIn(this.formData);
            }
        }
    },

    route: {
        // Checks if the user is already logged in. If so, redirects to /home.
        activate: function(transition) {
            if(authStore.getAuthenticationStatus()) {
                router.go('/home')
            } else {
                transition.next();
            }
        }
    }
});
