var Home = Vue.extend({
    template: '#dashboard-home',

    mixins: [contactsMixin, remindersMixin, validatorMixin],

    ready: function() {
        if(this.sharedState.contacts.length == 0) {
            this.getContacts();
        }
        if(this.remindersState.upcomingReminders.length == 0) {
            this.getUpcomingReminders();
        }
    },

    components: {
        'reminder-row': reminderRow
    },

    data: function() {
        return {
            user: uservm,
            sharedState: contactsStore.state,
            remindersState: remindersStore.state,
            query: '',
            showSuggestions: false,
            selectedContact: {},
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
            this.newReminder.contact_id = contact.id;
            this.query = contact.name + ' (' + contact.number + ')';
        },

        highlightContact: function(direction) {
            var length = this.filteredContacts.length;
            switch(direction) {
                case 'down':
                    this.selectedIndex++;
                    break;
                case 'up':
                    this.selectedIndex--;
                    break;
            }
            if(this.selectedIndex > length - 1) {
                this.selectedIndex = 0;
            }
            if(this.selectedIndex < 0) {
                this.selectedIndex = length - 1;
            }

            this.selectedContact = this.filteredContacts[this.selectedIndex];
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
    },

    filters: {
        exactFilterBy: function(array, needle, inKeyword, key) {
            return array.filter(function(item) {
                return item[key] == needle;
            });
        }
    }
});
