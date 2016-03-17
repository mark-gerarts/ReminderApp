/*
 *
 *   Shared state to share data across several components.
 *   Essentially a plain JS object with getters and setters.
 *   More info: http://vuejs.org/guide/application.html#State_Management.
 *
 *   RemindersStore: contains a list of reminders, along with some CRUD functions.
 */

var remindersStore = {
    state: {
        upcomingReminders: []
    },

    isLoaded: false,

    setLoadStatus: function(status) {
        this.isLoaded = status;
    },

    getIndexOf: function(reminder) {
        var outputIndex = -1;
        // Array.prototype.some(..) because some is breakable.
        this.state.upcomingReminders.some(function(_reminder, index) {
            if(reminder.id == _reminder.id) {
                outputIndex = index;
                return true;
            }
        });
        return outputIndex;
    },
    setUpcomingReminders: function(upcomingReminders) {
        this.state.upcomingReminders= upcomingReminders;
    },
    addReminder: function(reminder) {
        this.state.upcomingReminders.push(reminder);
    },
    updateDeletedContactIds: function(contact) {
        this.state.upcomingReminders.forEach(function(reminder) {
            if(reminder.contact_id == contact.id) {
                reminder.recipient = contact.number;
                reminder.contact_id = null;
            }
        });
    },
    removeReminder: function(reminder) {
        var index = this.getIndexOf(reminder);
        // Check if the given reminder exists in the shared state.
        if(index > -1) {
            this.state.upcomingReminders.splice(index, 1);
        }
    }
};
