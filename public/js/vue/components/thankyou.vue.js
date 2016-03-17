/*
 *
 *   Component for when the payment is complete.
 *   Basically just a loading page.
 *
 */

var Thankyou = Vue.extend({
    template: "<p class='center'><i class='fa fa-spinner fa-pulse'></i></p>",

    mixins: [authMixin],

    ready: function() {
        this.getUserInfo();
    }
});
