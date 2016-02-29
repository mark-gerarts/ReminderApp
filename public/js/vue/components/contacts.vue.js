/*
 *
 *   Component & route for the contacts page.
 *
 */

var Contacts = Vue.extend({
    template: '#dashboard-contacts',

    mixins: [contactsMixin, validatorMixin], // Loads the necessary mixins.

    // Child components used.
    components: {
        'contact-row': contactRow //The component to display a contact table row.
    },

    ready: function() {
        // Only perform a new server request if the page is loaded for the first time.
        if(this.sharedState.contacts.length == 0) {
            // getContacts() fills the shared state with all contacts.
            this.getContacts();
        }
    },

    data: function() {
        return {
            sharedState: contactsStore.state, // Shared state contains all the contacts.
            newContact: { //The viewmodel of a new contact, filled through the form.
                name: '',
                number: ''
            },
            isLoading: { // Container object for all loading flags.
                getContacts: false,
                insertContact: false
            },
            errors: { // Container object for all error flags.
                getContacts: false,
                insertContact: false
            },
            validationErrors: {}, // Stores the validation errors.
            isSubmittedOnce: false // Bool to check is the form is submitted or not - to set validation errors.
        }
    },

    methods: {
        // Validation function - is called upon submitting and upon input change.
        // Validates according to the rules set in validatorMixin.
        validate: function() {
            if(this.isSubmittedOnce) {
                this.$set('validationErrors', this.validateContact(this.newContact));
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
    }
});
