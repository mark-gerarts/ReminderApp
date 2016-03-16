var Register = Vue.extend({
    template: "#register-template",

    mixins: [authMixin, validatorMixin],

    data: function() {
        return {
            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
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
                this.$set('validationErrors', this.validateSignup(this.formData));
            }
        },
        register: function() {
            this.errorMessage = '';
            this.isSubmittedOnce = true;
            this.validate();

            if(Object.keys(this.validationErrors).length == 0) {
                this.authRegister(this.formData);
            }
        }
    },

    route: {
        activate: function(transition) {
            if(authStore.getAuthenticationStatus()) {
                router.go('/home')
            } else {
                transition.next();
            }
        }
    }
})
