//
// Vue setup for the dashboard homepage
//

Vue.http.options.root = 'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/'; //Set root
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
            contactId: null,
            datetime: '',
            message: '',
            repeatId: 0 //list of repeats is not retrieved from the db because it is -very- unlikely to ever change
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
            this.selectedContact = contact;
            this.query = contact.name + ' (' + contact.number + ')';
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
            console.log('submitting reminder..');
        }
    }
    
});

Vue.filter('exactFilterBy', function(array, needle, inKeyword, key) {
    return array.filter(function(item) {
        return item[key] == needle;
    })
});