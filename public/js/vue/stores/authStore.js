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
