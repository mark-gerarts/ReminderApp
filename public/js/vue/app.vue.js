/*
 *
 *   Main application logic.
 *   Contains:  - VueRoute
 *              - initialisation
 *
 */

// Initialise the VueRouter.
// VueRoute requires a base component (App).
var App = Vue.extend({
    mixins: [authMixin],

    ready: function() {
        // When the page is loaded, this will first check whether the token in localstorage
        // is 'fresh'. If the time since the token creation date is smaller than the token ttl,
        // the token is most likely still valid, and the user is 'assumed' to be authenticated.
        // This saves an initial authentication request.
        // Should the token be invalid, then the first request that returns a 401 will result
        // in a complete logout and a redirect to the login page.
        // If the time since the stored token's creation date is greater than the ttl, then
        // this means the token is expired. The user will be redirected to the login page
        // immediately.
        var data = this.getLocalStorage();
        if(data) {
            var now = new Date();
            var creationDate = new Date(data.created_at);
            if((now - creationDate) < 3600000) {
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

    // When a request returns a 401, the 'not-logged-in'-event is fired. This event bubbles to this
    // element, and is handled here.
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
    // Checks if the route needs authentication. If so, redirect to /login if the
    // user is not logged in.
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
