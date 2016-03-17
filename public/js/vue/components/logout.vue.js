/*
 *
 *   Component to handle logout.
 *
 */

var Logout = Vue.extend({
    mixins: [authMixin],

    ready: function() {
        this.authLogOut();
        window.location.href= myRootUrl;
    }
})
