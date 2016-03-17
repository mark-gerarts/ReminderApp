/*
 *
 *   Component to display a single reminder as a table row.
 *
 */
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
        // This filter is used to get contacts by their ID. Otherwise an ID of 1 would
        // return 1, 11, 12, ..
        exactFilterBy: function(array, needle, inKeyword, key) {
            return array.filter(function(item) {
                return item[key] == needle;
            });
        }
    }
})
