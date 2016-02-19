//
// Vue setup for the dashboard homepage
//

Vue.http.options.root = myRootUrl;//'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/'; //Set root
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header


var vm = new Vue({
    el: '#app',

    ready: function() {
        this.getContacts();
        this.getUpcomingReminders();
    },

    data: {
        contacts: [],
        upcomingReminders: [],
        query: '',
        showSuggestions: false,
        selectedContact: {},
        newReminder: {
            recipient: null,
            contact_id: null,
            send_datetime: '', //ToDo: wanneer toegevoegd zorgt de substr-3 ervoor dat de minuten weggekapt worden
            message: '',
            repeat_id: 1 //list of repeats is not retrieved from the db because it is -very- unlikely to ever change
        }
    },

    methods: {
        getContacts: function() {
            //Reset flags
            //this.isLoading.getContacts = true;
            //this.hasError.getContacts = false;

            this.$http.get('api/contacts').then(function(response) {
                //Success
                if(response.status == 200) {
                    this.$set('contacts', response.data); //Binds the response object to the data object
                } else {
                    //this.hasError.getContacts = true;
                }
            }, function(error) {
                //Error
                console.log(error);
                //this.hasError.getContacts = true;
            }).finally(function() {
                //this.isLoading.getContacts = false;
                console.log('getContacts finished')
            });
        },

        selectContact: function(contact) {
            //ToDo: add check for either contact_id or a random number + check if correct etc
            this.selectedContact = contact;
            this.newReminder.contact_id = contact.id;
            this.query = contact.name + ' (' + contact.number + ')';
        },

        highlightContact: function() {
            console.log('highlighted!');
        },

        getUpcomingReminders() {
            this.$http.get('api/reminders/upcoming').then(function(response) {
                //Success
                if(response.status == 200) {
                    this.$set('upcomingReminders', response.data); //Binds the response object to the data object
                } else {
                    //error
                }
            }, function(error) {
                //Error
                console.log(error);
            }).finally(function() {
                console.log('getUpcomingReminders finished')
            });
        },

        submitReminder: function() {
            if(!this.newReminder.contact_id) {
                this.newReminder.recipient = this.query;
            }

            this.$http.post('api/reminders', JSON.stringify(this.newReminder)).then(function(response) {
                //Success
                console.log(response);
                if(response.status == 200) {
                    this.newReminder.id = response.data;
                    this.upcomingReminders.push(this.newReminder);
                    this.newReminder = {
                        repeat_id: 1,
                    };                      // Reset the viewmodel. This only happens when the insert is successful,
                                            // thus the user doesn't have to re-enter values in case of an error.
                    //this.validationErrors = {}; //Reset the validationerrors
                } else {
                    //this.hasError.insertContact = true;
                }
            }, function(error) {
                //Error
                console.log(error);
                if(error.status == 422) { //422 = validation errors
                    //this.$set('validationErrors', error.data); //Bind the data
                } else {
                    //this.hasError.insertContact = true;
                }
            }).finally(function() {
                //this.isLoading.insertContact = false;
            });
        }
    }

});

Vue.filter('exactFilterBy', function(array, needle, inKeyword, key) {
    return array.filter(function(item) {
        return item[key] == needle;
    })
});
