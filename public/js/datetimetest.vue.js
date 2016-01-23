var dateTimePicker = Vue.extend({
    template: '#datetimepicker-template',
    props: ['name'],
    ready: function() {
        console.log(this.labels)
    },
    data: function() {
        return {
            labels: {
                days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
            },
            daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
            currentDate: new Date()
        }
    },
    methods: {
        generateMonth: function() {
            
        }
    }
});

Vue.component('datetimepicker', dateTimePicker);

var vm = new Vue({
    el: '#app'
});