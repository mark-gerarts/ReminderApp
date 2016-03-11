/*
 *
 *   Main application logic.
 *   Contains:  - VueRoute
 *              - initialisation
 *  This will probably be split up some more later.
 */

// Initialise the VueRouter.
// VueRoute requires a base component (App).
var App = Vue.extend({});
var router = new VueRouter();

// Map all the routes by pointing to the associated component.
router.map({
    '/': {
        component: Home,
        auth: true
    },
    '/contacts': {
        component: Contacts,
        auth: true
    },
    '/account': {
        component: Account,
        auth: true
    },
    '/login': {
        component: Login,
        auth: false
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
