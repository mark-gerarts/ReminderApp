/*
 *
 *   Simple Vue code for the quick reminder form.
 *
 */

 Vue.http.options.root = myRootUrl; //Set root
 Vue.http.headers.common['X-CSRF-TOKEN'] = csrf_token; //csrf token from global var is put in the header

var vm = new Vue({
    el: '#vue-form',

    mixins: [validatorMixin],

    data: {
        newReminder: {
            recipient: '',
            send_datetime: '',
            message: ''
        },
        validationErrors: {},
        errors: {},
        isLoading: false,
        isSubmittedOnce: false
    },

    methods: {
        validate: function() {
            if(this.isSubmittedOnce) {
                this.$set('validationErrors', this.validateQuickReminder(this.newReminder));
            }
        },
        trim: function() {
            for(var prop in this.newReminder) {
                if(this.newReminder[prop]) {
                    this.newReminder[prop] = this.newReminder[prop].toString().trim();
                }
            }
        },
        submitReminder: function() {
            this.isSubmittedOnce = true;
            this.trim();
            this.validate();

            if(Object.keys(this.validationErrors).length == 0) {
                //this.insertContact(this.newContact);
                console.log('submitting')
            }
        }
    }
});
