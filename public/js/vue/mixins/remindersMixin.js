/*
 *
 *   Mixin to share reminder http functions across components.
 *
 */

var remindersMixin = {
    methods: {
        //Debugging function - should be deleted!!!
        _openErrorWindow: function(msg) {
            var win = window.open("", "Title");
            win.document.body.innerHTML = msg;
        },

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
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                this._openErrorWindow(error.data);
            }).finally(function() {
                this.isLoading.getUpcomingReminders = false;
            });
        },

        submitReminder: function(reminder) {
            this.isLoading.submitReminder = true;

            this.$http.post('api/reminders', JSON.stringify(reminder)).then(function(response) {
                //Success
                console.log(response);
                if(response.status == 200) {
                    reminder.id = response.data;
                    remindersStore.addReminder(reminder);
                    this.isContactSelected = false;
                    this.query = '';
                    this.newReminder = {
                        repeat_id: 1,
                    };                      // Reset the viewmodel. This only happens when the insert is successful,
                                            // thus the user doesn't have to re-enter values in case of an error.
                    authStore.incrementCredits(-1);
                } else {
                    //this.hasError.insertContact = true;
                }
            }, function(error) {
                //Error
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                this._openErrorWindow(error.data);
            }).finally(function() {
                this.isLoading.submitReminder = false;
            });
        },

        cancelReminder: function(reminder) {
            this.showConfirmationBox = false;
            this.isLoading.cancelReminder = true;

            this.$http.get('api/reminders/cancel/' + reminder.id).then(function(response) {
                //Success
                console.log(response);
                if(response.status == 200) {
                    remindersStore.removeReminder(reminder);
                    authStore.incrementCredits(1);
                } else {
                    //this.hasError.insertContact = true;
                }
            }, function(error) {
                //Error
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
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
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                console.log(error);
                var win = window.open("", "Title");
                win.document.body.innerHTML = error.data;
            }).finally(function() {
                this.isLoading.submitQuickReminder = false;
            });
        }
    }
};
