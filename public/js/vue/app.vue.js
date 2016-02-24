var store = { //Object to share data across several components
    state: {
        contacts: []
    },
    getIndexOf: function(contact) {
        var outputIndex = -1;
        this.state.contacts.some(function(_contact, index) {
            if(contact.id == _contact.id) {
                outputIndex = index;
                return true;
            }
        });
        return outputIndex;
    },
    setContacts: function(contacts) {
        this.state.contacts = contacts;
    },
    removeContact: function(contact) {
        var index = this.getIndexOf(contact);
        if(index > -1) {
            this.state.contacts.splice(index, 1);
        }
    },
    addContact: function(contact) {
        this.state.contacts.push(contact);
    },
    updateContact: function(contact) {
        var index = this.getIndexOf(contact);
        if(index > -1) {
            var newContact = this.state.contacts[index];
            newContact.name = contact.name;
            newContact.number = contact.number;
            newContact.id = contact.id;
        }
    }
};

var App = Vue.extend({});
var router = new VueRouter();

router.map({
    '/': {
        component: Home
    },
    '/contacts': {
        component: Contacts
    },
    '*': {
        component: Home
    }
});

window.onload = function() {
    router.start(App, "#app"); //Start the app

    Vue.http.options.root = myRootUrl; //Set root
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header

}
