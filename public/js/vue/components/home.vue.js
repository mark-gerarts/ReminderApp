/*
 *
 *   Component for dashboard home page.
 *
 */

var Home = Vue.extend({
    template: '#dashboard-home',

    mixins: [contactsMixin, remindersMixin, validatorMixin],

    ready: function() {
        // Check if the stores are loaded, otherwise sent a request.
        if(!contactsStore.isLoaded) {
            this.getContacts();
            contactsStore.setLoadStatus(true);
        }
        if(!remindersStore.isLoaded) {
            this.getUpcomingReminders();
            remindersStore.setLoadStatus(true);
        }
    },

    components: {
        'reminder-row': reminderRow,
        'datetimepicker': dateTimePicker
    },

    data: function() {
        return {
            user: authStore.state.user,
            sharedState: contactsStore.state,
            remindersState: remindersStore.state,
            query: '',
            showSuggestions: false,
            selectedContact: {},
            highlightedContact: {},
            isContactSelected: false,
            selectedIndex: -1,
            newReminder: {
                recipient: null,
                contact_id: null,
                send_datetime: '', //ToDo: wanneer toegevoegd zorgt de substr-3 ervoor dat de minuten weggekapt worden
                message: '',
                repeat_id: 1 //list of repeats is not retrieved from the db because it is -very- unlikely to ever change
            },
            errors: {},
            isLoading: {
                getUpcomingReminders: false
            },
            validationErrors: {},
            isSubmittedOnce: false,
            repeats: [
                "Never",
                "Daily",
                "Weekly",
                "Monthly",
                "Yearly"
            ]
        };
    },

    computed: {
        // The contacts that fit the query.
        filteredContacts: function() {
            // Don't search contacts if the query is short.
            if(this.query.length < 2) {
                return [];
            }

            var self = this;
            //General function to check if a string is part of a bigger string.
            function contains(a, b) {
                return a.toLowerCase().indexOf(b.toLowerCase()) != -1;
            }
            return this.sharedState.contacts.filter(function(contact) {
                return contains(contact.name, self.query) || contains(contact.number, self.query);
            });
        }
    },

    methods: {
        // Handle selecting a contact
        selectContact: function(contact) {
            this.selectedContact = contact;
            this.newReminder.contact_id = contact.id;
            this.query = contact.name + ' (' + contact.number + ')';
            this.isContactSelected = true;
        },
        // Resets all involved vm's
        resetRecipient: function() {
            this.isContactSelected = false;
            this.selectedContact = {};
            this.highlightedContact =  {};
            this.newReminder.contact_id = null;
            this.query = '';
        },

        // Used for selecting with the up & down keys.
        highlightContact: function(input) {
            switch(input) {
                case 'down':
                    this.selectedIndex++;
                    break;
                case 'up':
                    this.selectedIndex--;
                    break;
                default:
                    this.selectedIndex = input;
                    break;
            }

            var length = this.filteredContacts.length;
            if(this.selectedIndex > length - 1) {
                this.selectedIndex = 0;
            }
            if(this.selectedIndex < 0) {
                this.selectedIndex = length - 1;
            }

            this.highlightedContact = this.filteredContacts[this.selectedIndex];
        },

        // Checks for validation errors, only if the form is already submitted once.
        validate: function() {
            if(this.isSubmittedOnce) {
                this.$set('validationErrors', this.validateReminder(this.newReminder));
            }
        },

        // Trims whitespace.
        trim: function() {
            for(var prop in this.newReminder) {
                if(this.newReminder[prop]) {
                    this.newReminder[prop] = this.newReminder[prop].toString().trim();
                }
            }
        },

        handleReminderSubmit() {
            if(this.user.reminder_credits == 0) {
                // ToDo;
                return;
            }
            if(!this.isContactSelected) {
                this.newReminder.recipient = this.query;
            }
            this.isSubmittedOnce = true;
            this.trim();
            this.validate();

            if(Object.keys(this.validationErrors).length == 0) {
                this.submitReminder(this.newReminder);
            } else {
                this.newReminder.recipient = null;
            }
        }
    }
});
