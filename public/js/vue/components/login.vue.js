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
        // Called on insert.
        handleInsert: function() {
            this.isSubmittedOnce = true;
            this.validate();
            // Only submits when there are no validation errors.
            // The input is checked server side as well.
            if(Object.keys(this.validationErrors).length == 0) {
                this.insertContact(this.newContact);
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
    }
});
