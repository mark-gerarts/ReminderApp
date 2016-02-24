//A component for a contact table row
var contactRow = Vue.extend({
    template: '#contact-template', //Consists of a table row, template stored in contacts.blade.php

    mixins: [contactsMixin],

    props: {
        contact: {}
    },

    data: function() { //Initialise data models
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
            }
        }
    },

    methods: {
        startEditing: function() {
            this.editing = true;
            this.updatedContact.name = this.contact.name;
            this.updatedContact.number = this.contact.number;
            this.updatedContact.id = this.contact.id;
        },
        cancelEditing: function() {
            this.editing = false;
        },
        handleUpdate: function() {
            this.updateContact(this.updatedContact);
        }
    }
});
