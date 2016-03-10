var Home = Vue.extend({
    template: '#dashboard-home',

    mixins: [contactsMixin, remindersMixin, validatorMixin],

    ready: function() {
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
            user: uservm,
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
        filteredContacts: function() {
            if(this.query.length < 2) {
                return [];
            }

            var self = this;
            function contains(a, b) {
                return a.toLowerCase().indexOf(b.toLowerCase()) != -1;
            }
            return this.sharedState.contacts.filter(function(contact) {
                return contains(contact.name, self.query) || contains(contact.number, self.query);
            });
        }
    },

    methods: {
        selectContact: function(contact) {
            //ToDo: add check for either contact_id or a random number + check if correct etc
            this.selectedContact = contact;
            this.query = contact.name + ' (' + contact.number + ')';
            this.isContactSelected = true;
        },
        resetRecipient: function() {
            this.isContactSelected = false;
            this.selectedContact = {};
            this.highlightedContact =  {};
        },

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

        validate: function() {
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
            this.newReminder.recipient = (this.isContactSelected) ? this.selectedContact.id : this.query;
            this.trim();
            this.validate();

            if(Object.keys(this.validationErrors).length == 0) {
                this.submitReminder(this.newReminder);
            }
        }
    }
});
