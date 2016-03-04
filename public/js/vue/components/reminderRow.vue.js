var reminderRow = Vue.extend({
    template: '#reminderrow',

    mixins: [remindersMixin],

    props: ['reminder', 'repeats'],

    data: function() {
        return {
            sharedState: contactsStore.state,
            showConfirmationBox: false,
            isLoading: {}

        }
    }
})
