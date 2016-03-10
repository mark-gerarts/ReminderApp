/*
 *
 *   Simple Vue code for the quick reminder form.
 *
 */

 Vue.http.options.root = myRootUrl; //Set root
 Vue.http.headers.common['X-CSRF-TOKEN'] = csrf_token; //csrf token from global var is put in the header

var vm = new Vue({
    el: '#vue-app',

    mixins: [validatorMixin, remindersMixin],

    components: {
        'datetimepicker': dateTimePicker
    },

    data: {
        newQuickReminder: {
            recipient: '',
            send_datetime: '',
            message: ''
        },
        validationErrors: {},
        errors: {},
        isLoading: false,
        isSubmittedOnce: false,
        reviewing: false
    },

    computed: {
        phoneRecipient: function() {
            if(this.newQuickReminder.recipient.length == 0) {
                return 'Recipient';
            } else {
                return this.newQuickReminder.recipient;
            }
        },
        phoneMessage: function() {
            if(this.newQuickReminder.message.length == 0) {
                return 'Your message here!';
            } else {
                return this.newQuickReminder.message;
            }
        },
        phoneDate: function() {
            if(this.newQuickReminder.send_datetime.length == 0) {
                return '2016-09-15 12:57';
            } else {
                return this.newQuickReminder.send_datetime;
            }
        },
    },

    methods: {
        validate: function() {
            if(this.isSubmittedOnce) {
                this.$set('validationErrors', this.validateQuickReminder(this.newQuickReminder));
            }
        },
        trim: function() {
            for(var prop in this.newQuickReminder) {
                if(this.newQuickReminder[prop]) {
                    this.newQuickReminder[prop] = this.newQuickReminder[prop].toString().trim();
                }
            }
        },
        handleSubmit: function() {
            this.isSubmittedOnce = true;
            this.trim();
            this.validate();

            if(Object.keys(this.validationErrors).length == 0) {
                this.reviewing = true;
                //this.submitQuickReminder(this.newQuickReminder);
            }
        }
    }
});
