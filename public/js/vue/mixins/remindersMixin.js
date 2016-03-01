/*
 *
 *   Mixin to share reminder http functions across components.
 *   Currently only used in the dashboard.home component.
 *
 */

var remindersMixin = {
    methods: {
        getUpcomingReminders() {
            this.isLoading.getUpcomingReminders = true;

            this.$http.get('api/reminders/upcoming').then(function(response) {
                //Success
                if(response.status == 200) {
                    remindersStore.setUpcomingReminders(response.data); //Binds the response object to the data object
                } else {
                    //error
                }
            }, function(error) {
                //Error
                console.log(error);
            }).finally(function() {
                this.isLoading.getUpcomingReminders = true;
            });
        },

        submitReminder: function(reminder) {
            this.isLoading.submitReminder = true;

            this.$http.post('api/reminders', JSON.stringify(reminder)).then(function(response) {
                //Success
                console.log(response);
                if(response.status == 200) {
                    reminder.id = response.data;
                    remindersStore.addReminder(reminder)
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
            }).finally(function() {
                this.isLoading.submitReminder = false;
            });
        },

        submitQuickReminder: function(reminder) {
            this.isLoading.submitQuickReminder = true;

            this.$http.post('api/quickreminders', JSON.stringify(reminder)).then(function(response) {
                //Success
                console.log(response);
                if(response.status == 200) {
                    reminder.id = response.data;
                    this.newQuickReminder = {
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
                var win = window.open("", "Title");
                win.document.body.innerHTML = error.data;
            }).finally(function() {
                this.isLoading.submitQuickReminder = false;
            });
        }
    }
};
