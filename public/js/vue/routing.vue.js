var store = {
    state: {
        contacts: [],
        message:'hello'
    },
    setContacts: function(contacts) {
        this.state.contacts = contacts;
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
    }
});

router.start(App, "#app")

Vue.http.options.root = myRootUrl; //Set root
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header