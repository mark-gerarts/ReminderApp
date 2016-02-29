/*
 *
 *   Main application logic.
 *   Contains:  - VueRoute
 *              - Shared state
 *              - initialisation
 *  This will probably be split up some more later.
 */

// Shared state to share data across several components.
// Essentially a plain JS object with getters and setters.
// More info: http://vuejs.org/guide/application.html#State_Management.
var contactsStore = {
    // The shared state.
    state: {
        contacts: []
    },

    // List of methods to manipulate the state.

    // Gets the index of the given contact.
    // Returns the index if the contact is found,
    // and -1 otherwise.
    getIndexOf: function(contact) {
        var outputIndex = -1;
        // Array.prototype.some(..) because some is breakable.
        this.state.contacts.some(function(_contact, index) {
            if(contact.id == _contact.id) {
                outputIndex = index;
                return true;
            }
        });
        return outputIndex;
    },
    // Initialises or overrides the contacts.
    // This is used in the http.getAllContacts function.
    setContacts: function(contacts) {
        this.state.contacts = contacts;
    },
    // Removes the given contact.
    removeContact: function(contact) {
        var index = this.getIndexOf(contact);
        // Check if the given contact exists in the shared state.
        if(index > -1) {
            this.state.contacts.splice(index, 1);
        }
    },
    // Adds a new contact.
    addContact: function(contact) {
        this.state.contacts.push(contact);
    },
    // Updates a given contact.
    updateContact: function(contact) {
        var index = this.getIndexOf(contact);
        // Check if the contact exists.
        if(index > -1) {
            // Set the new values.
            var newContact = this.state.contacts[index];
            newContact.name = contact.name;
            newContact.number = contact.number;
            newContact.id = contact.id;
        }
    }
};

// Shared state to share data across several components.
// Though this is used to keep the reminders in memory.
var remindersStore = {
    state: {
        upcomingReminders: []
    },
    setUpcomingReminders: function(upcomingReminders) {
        this.state.upcomingReminders= upcomingReminders;
    },
    addReminder: function(reminder) {
        this.state.upcomingReminders.push(reminder);
    }
}
// Initialise the VueRouter.
// VueRoute requires a base component (App).
var App = Vue.extend({});
var router = new VueRouter();

// Map all the routes by pointing to the associated component.
router.map({
    '/': {
        component: Home
    },
    '/contacts': {
        component: Contacts
    },
    // '*' == default fallback route.
    // Points to 'Home' for now, might add a 404 later.
    '*': {
        component: Home
    }
});

window.onload = function() {
    // Some configurations.
    Vue.http.options.root = myRootUrl; //Set root
    Vue.http.headers.common['X-CSRF-TOKEN'] = csrf_token; //csrf token from global var is put in the header
    Vue.http.headers.common['Authorization'] = 'Bearer: ' + jwt_token;

    // Start the app.
    router.start(App, "#app");
}
