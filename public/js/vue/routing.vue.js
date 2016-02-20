var store = {
    state: {
        contacts: [],
        message:'hello'
    },
    setContacts: function(contacts) {
        this.state.contacts = contacts;
    },
    removeContact: function(contactToDelete) {
        var indexToDelete = -1;
        this.state.contacts.some(function(contact, index) {
            if(contact.id == contactToDelete.id) {
                indexToDelete = index;
                return true;
            }
        })
        if(indexToDelete > 0) {
            this.state.contacts.splice(indexToDelete, 1);
        }
    },
    addContact: function(contact) {
        this.state.contacts.push(contact);
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

router.start(App, "#app")

Vue.http.options.root = myRootUrl; //Set root
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header
