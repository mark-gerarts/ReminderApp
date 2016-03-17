/*
 *
 *   Shared state to share data across several components.
 *   Essentially a plain JS object with getters and setters.
 *   More info: http://vuejs.org/guide/application.html#State_Management.
 *
 *   Authstore: cotains userdata and authentication status.
 */

var authStore = {
    state: {
        user: null,
        authenticated: false
    },

    setUser: function(user) {
        this.state.user = user;
    },

    incrementCredits: function (amount) {
        this.state.user.reminder_credits += amount;
    },

    setAuthenticationStatus: function(bool) {
        this.state.authenticated = bool;
    },

    getAuthenticationStatus: function() {
        return this.state.authenticated;
    }
}
