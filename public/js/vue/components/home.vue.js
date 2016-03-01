var Home = Vue.extend({
    template: '#dashboard-home',

    mixins: [contactsMixin, remindersMixin, validatorMixin],

    ready: function() {
        if(this.sharedState.contacts.length == 0) {
            this.getContacts();
        }
        this.getUpcomingReminders();
    },

    data: function() {
        return {
            sharedState: contactsStore.state,
            remindersState: remindersStore.state,
            query: '',
            showSuggestions: false,
            selectedContact: {},
            newReminder: {
                recipient: null,
                contact_id: null,
                send_datetime: '', //ToDo: wanneer toegevoegd zorgt de substr-3 ervoor dat de minuten weggekapt worden
                message: '',
                repeat_id: 1 //list of repeats is not retrieved from the db because it is -very- unlikely to ever change
            },
            errors: {},
            isLoading: {},
            validationErrors: {},
            isSubmittedOnce: false
        };
    },

    methods: {
        selectContact: function(contact) {
            //ToDo: add check for either contact_id or a random number + check if correct etc
            this.selectedContact = contact;
            this.newReminder.contact_id = contact.id;
            this.query = contact.name + ' (' + contact.number + ')';
        },

        highlightContact: function() {
            console.log('highlighted!');
        },

        validate: function() {
            if(!this.newReminder.contact_id) {
                this.newReminder.recipient = this.query;
            }
            if(this.isSubmittedOnce) {
                this.$set('validationErrors', this.validateReminder(this.newReminder));
            }
        },

        trim: function() {
            for(var prop in this.newReminder) {
                if(this.newReminder[prop]) {
                    this.newReminder[prop] = this.newReminder[prop].toString().trim();
                }
            }
        },

        handleReminderSubmit() {
            this.isSubmittedOnce = true;
            this.trim();
            this.validate();

            if(Object.keys(this.validationErrors).length == 0) {
                this.submitReminder(this.newReminder);
            }
        }
    }

});

Vue.filter('exactFilterBy', function(array, needle, inKeyword, key) {
    return array.filter(function(item) {
        return item[key] == needle;
    })
});
