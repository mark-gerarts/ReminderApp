//A component for a contact table row
var contactRow = Vue.extend({
    template: '#contact-template', //Consists of a table row, template stored in contacts.blade.php

    mixins: [contactsMixin],

    props: {
        contact: {} //Binds the contact in v-for
    },

    data: function() { //Initialise data models 
        return {
            editing: false,
            isLoading: {
                delete: false,
                update: false //ToDo: add loading indicator in html
            },
            errors: {
                delete: false,
                update: false
            },
            validationErrors: {}
        }
    },
});
//Vue.component('contact-row', contactRow); //Register the component
