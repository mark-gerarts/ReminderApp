/*
 *
 *   Component to display a contact as a table row.
 *
 */

var contactRow = Vue.extend({
    template: '#contact-template', // Consists of a table row, template stored in contacts.blade.php.

    mixins: [contactsMixin, validatorMixin], // The mixins that need to be loaded.

    props: ['contact'], // The contact object is passed via this prop in v-for.

    data: function() { // Initialise flags, vms, etc.
        return {
            editing: false,
            isLoading: {
                deleteContact: false,
                updateContact: false
            },
            errors: {
                deleteContact: false,
                updateContact: false
            },
            validationErrors: {},
            updatedContact: {
                name: '',
                number: ''
            },
            isSubmittedOnce: false,
            showConfirmationBox: false
        }
    },

    methods: {
        // Called when a user starts editing a contact.
        startEditing: function() {
            this.editing = true;
            // make updatedContact equal to the selected contact.
            this.updatedContact.name = this.contact.name;
            this.updatedContact.number = this.contact.number;
            this.updatedContact.id = this.contact.id;
        },
        // Called when a user cancels editing.
        // Resets all used variables.
        cancelEditing: function() {
            this.editing = false;
            this.isSubmittedOnce = false;
            this.validationErrors = {};
        },
        // Called on input - validates according to the rules set in validatorMixin.
        validate: function() {
            // Check if the form is submitted once. This is to prevent errors from showing
            // before the user had a chance to fill out everything.
            if(this.isSubmittedOnce) {
                this.$set('validationErrors', this.validateContact(this.updatedContact));
            }
        },
        // Called on update.
        handleUpdate: function() {
            this.isSubmittedOnce = true;
            this.validate();
            // Only submits when there are no validation errors.
            // The input is checked server side as well.
            if(Object.keys(this.validationErrors).length == 0) {
                this.updateContact(this.updatedContact);
                this.cancelEditing();
            }
        }
    }
});
