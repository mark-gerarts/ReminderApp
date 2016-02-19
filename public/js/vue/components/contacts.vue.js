var Contacts = Vue.extend({
    template: '#dashboard-contacts',

    mixins: [contactsMixin],

    ready: function() {
        this.getContacts.bind(this)();
    },

    data: function() {
        return {
            contacts: [], //List of all contacts, filled via getContacts()
            newContact: {}, //the viewmodel of a new contact, filled through the form
            isLoading: { //container object for all loading flags
                getContacts: false,
                insertContact: false
            },
            hasError: { //container object for all error flags
                getContacts: false,
                insertContact: false
            },
            validationErrors: {} //stores the received validation errors through insertContact()
        }
    }
})
