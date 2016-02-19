//
// Vue setup for the dashboard homepage
//

Vue.http.options.root = myRootUrl;//'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/'; //Set root
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header


var vm = new Vue({
    el: '#app',

    ready: function() {
        console.log('Vue ready!');
    },

    data: {
        newReminder: {
            recipient: null,
            send_datetime: '', //ToDo: wanneer toegevoegd zorgt de substr-3 ervoor dat de minuten weggekapt worden
            message: ''
        }
    },

    methods: {
        submitReminder: function() {

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
