var Account = Vue.extend({
    template: '#dashboard-account',

    data: function() {
        return {
            state: authStore.state
        };
    }
})
