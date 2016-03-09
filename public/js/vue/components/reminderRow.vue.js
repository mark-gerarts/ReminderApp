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
    },

    filters: {
        exactFilterBy: function(array, needle, inKeyword, key) {
            return array.filter(function(item) {
                return item[key] == needle;
            });
        }
    }
})
