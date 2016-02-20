var Contacts = Vue.extend({
    template: '#dashboard-contacts',

    mixins: [contactsMixin],

    components: {
        'contact-row': contactRow
    },

    ready: function() {
        this.getContacts();
    },

    data: function() {
        return {
            sharedState: store.state,
            //contacts: store.state.contacts, //List of all contacts, filled via getContacts()
            newContact: {}, //the viewmodel of a new contact, filled through the form
            isLoading: { //container object for all loading flags
                getContacts: false,
                insertContact: false
            },
            errors: { //container object for all error flags
                getContacts: false,
                insertContact: false
            },
            validationErrors: {} //stores the received validation errors through insertContact()
        }
    }
});
