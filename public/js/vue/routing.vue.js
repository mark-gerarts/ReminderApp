//Vue.http.options.root = myRootUrl;//'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/'; //Set root
//Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').value; //csrf token is extracted from the page & put in the header


var App = Vue.extend({

});

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
