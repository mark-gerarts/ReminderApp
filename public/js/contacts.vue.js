//
// Vue setup for the dashboard contacts page
//test

Vue.http.options.root = myRootUrl;//'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/'; //Set root
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header

//A component for a contact table row
var contactRow = Vue.extend({
    template: '#contact-template', //Consists of a table row, template stored in contacts.blade.php
    props: {
        contact: {} //Binds the contact in v-for
    },
    data: function() { //Data models initialiseren
        return {
            editing: false,
            isLoading: {
                delete: false,
                update: false //ToDo: add loading indicator in html
            },
            hasError: {
                delete: false,
                update: false
            },
            validationErrors: {}
        }
    },
    methods: { //Methods voor elke component
        updateContact: function() {
            //Reset flags
            this.isLoading.delete = true;
            this.hasError.delete = false;

            this.$http.put('api/contacts', JSON.stringify(this.contact)).then(function(response) {
                if(response.status != 200) {
                    this.hasError.update = true;
                } else {
                    this.editing = false;
                }
            }, function(error) {
                if(error.status == 422) {
                    this.$set('validationErrors', error.data);
                } else {
                    this.hasError.update = true;
                }
                console.log(error);
            }).finally(function() {
                this.isLoading.delete = false;
            })
        },
        deleteContact: function(contact) {
            //Reset flags
            this.isLoading.delete = true;
            this.hasError.delete = false;

            this.$http.delete('api/contacts/' + this.contact.id).then(function(response) {
                //Success
                console.log(response)
                if(response.status == 200 && response.data) {
                    this.$remove();
                } else {
                    this.hasError.delete = true;
                }
            }, function(error) {
                //Error
                console.log(error);
                this.hasError.delete = true;
            }).finally(function() {
                this.isLoading.delete = false;
            });
        }
    }
});

Vue.component('contact-row', contactRow); //Register the component


var vm = new Vue({
    el: '#app',

    ready: function() {
        this.getContacts(); //Load the contacts when the page is loaded
    },

    data: {
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
    },

    methods: {
        getContacts: function() {
            //Reset flags
            this.isLoading.getContacts = true;
            this.hasError.getContacts = false;

            this.$http.get('api/contacts', null, {headers: { "Authorization": "Bearer "}}).then(function(response) {
                //Success
                if(response.status == 200) {
                    this.$set('contacts', response.data); //Binds the response object to the data object
                } else {
                    this.hasError.getContacts = true;
                }
            }, function(error) {
                //Error
                //For debugging, PLEASE delete me for production
                var win = window.open("", "Title");
                win.document.body.innerHTML = error.data;

                //console.log(error);
                this.hasError.getContacts = true;
            }).finally(function() {
                this.isLoading.getContacts = false;
            });
        },

        insertContact: function() {
            //Reset flags
            this.isLoading.insertContact = true;
            this.hasError.insertContact =false;

            this.$http.post('api/contacts', JSON.stringify(this.newContact)).then(function(response) {
                //Success
                if(response.status == 200) {
                    this.newContact.id = response.data;
                    this.contacts.push(this.newContact);
                    this.newContact = {}; // Reset the viewmodel. This only happens when the insert is successful,
                                          // thus the user doesn't have to re-enter values in case of an error.
                    this.validationErrors = {}; //Reset the validationerrors
                } else {
                    this.hasError.insertContact = true;
                }
            }, function(error) {
                //Error
                if(error.status == 422) { //422 = validation errors
                    this.$set('validationErrors', error.data); //Bind the data
                } else {
                    this.hasError.insertContact = true;
                }
                console.log(error);
            }).finally(function() {
                this.isLoading.insertContact = false;
            });
        }
    }
});
