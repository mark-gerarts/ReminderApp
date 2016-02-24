var Contacts = Vue.extend({
    template: '#dashboard-contacts',

    mixins: [contactsMixin], //Contains all http functions for contacts

    components: {
        'contact-row': contactRow //The component to display a contact table row
    },

    ready: function() {
        if(this.sharedState.contacts.length == 0) {
            this.getContacts();
        }
    },

    data: function() {
        return {
            sharedState: store.state, //Shared state contains all the contacts
            newContact: {}, //The viewmodel of a new contact, filled through the form
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
