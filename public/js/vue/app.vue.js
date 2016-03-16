/*
 *
 *   Main application logic.
 *   Contains:  - VueRoute
 *              - initialisation
 *  This will probably be split up some more later.
 */

// Initialise the VueRouter.
// VueRoute requires a base component (App).
var App = Vue.extend({
    mixins: [authMixin],

    ready: function() {
        var data = this.getLocalStorage();
        if(data) {
            var now = new Date();
            var creationDate = new Date(data.created_at);
            if((now - creationDate) < 3600000) { //3600000
                this.setToken(data.token);
                authStore.setAuthenticationStatus(true);
                authStore.setUser(data.user);
                return;
            }
        }
    },

    data: function() {
        return {
            state: authStore.state
        }
    },

    events: {
        'not-logged-in': function() {
            this.authLogOut();
            router.go('/login');
        }
    }
});

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
    '/thankyou': {
        component: Thankyou,
        auth: true
    },
    '/login': {
        component: Login,
        auth: false
    },
    '/register': {
        component: Register,
        auth: false
    },
    '/logout': {
        component: Logout,
        auth: false
    },
    // '*' == default fallback route.
    // Points to 'Home' for now, might add a 404 later.
    '*': {
        component: Home
    }
});

router.beforeEach(function (transition) {
    if (transition.to.auth && !authStore.getAuthenticationStatus()) {
        transition.redirect('/login');
    } else {
        transition.next();
    }
});

window.onload = function() {
    // Some configurations.
    Vue.http.options.root = myRootUrl; //Set root
    Vue.http.headers.common['X-CSRF-TOKEN'] = csrf_token; //csrf token from global var is put in the header

    // Start the app.
    router.start(App, "#app");
}
