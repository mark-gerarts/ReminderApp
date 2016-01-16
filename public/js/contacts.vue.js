//
// Vue setup for the dashboard contacts page
//

Vue.http.options.root = 'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/'; //Set root
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header

//A reusable component for a contact table row
var contactRow = Vue.extend({ 
    template: '#contact-template', //Consists of a table row, template stored in contacts.blade.php
    props: {
        contact: {},
        editing: false //Flag to check if the contact is being edited
    },
    methods: {
        updateContact: function() {
            //Calls the parent's update method and cancels editing mode
            this.$parent.updateContact(this.contact);
            this.editing = false;
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
        contacts: [], //Lis tof all contacts, filled via getContacts()
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
            
            this.$http.get('api/contacts').then(function(response) {
                //Success
                if(response.status == 200) {
                    this.$set('contacts', response.data); //Binds the response object to the data object
                } else {
                    this.hasError.getContacts = true; 
                }
            }, function(error) {
                console.log(error);
                this.hasError.getContacts = true;
            }).finally(function() {
                this.isLoading.getContacts = false;
            })
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
                if(error.status == 422) { //422 = validation errors
                    this.$set('validationErrors', error.data);
                } else {
                    this.hasError.insertContact = true;
                }
                console.log(error);
            }).finally(function() {
                this.isLoading.insertContact = false;
            })
        },
        
        deleteContact: function(contact) {
            this.$http.delete('api/contacts/' + contact.id).then(function(response) {
                console.log(response);
                this.contacts.$remove(contact);
            }, function(error) {
                console.log(error);
            }).finally(function() {
                console.log('delete finished');
                return true; //ToDo: add check to see if successful
            })
        },
        
        updateContact: function(contact) {
            this.$http.put('api/contacts', JSON.stringify(contact)).then(function(response) {
                console.log(response);
            }, function(error) {
                console.log(error);
            }).finally(function() {
                console.log('update finished')
            })
        }
    }
});