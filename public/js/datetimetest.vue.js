var dateTimePicker = Vue.extend({
    template: '#datetimepicker-template',
    props: ['name'],
    ready: function() {
        this.activeMonth = this.generateMonth(this.currentDate.getFullYear(), this.currentDate.getMonth());
    },
    data: function() {
        return {
            labels: {
                days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
            },
            daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
            currentDate: new Date(),
            activeMonth: {
                year: '',
                month: 0,
                days: []
            }
        }
    },
    methods: {
        generateMonth: function(year, month) {
            var myDate = new Date(year, month);
            var startDay = myDate.getDay() - 1;
            var monthObj = {};
            monthObj.year = year;
            monthObj.month = month;
            monthObj.days = [];
            
            var tempDays = [];
            for(var i=0; i<this.daysInMonth[month]; i++) {
                if(i<startDay) {
                    tempDays.push('');
                } else {
                    tempDays.push(i - startDay + 1);
                }
            }
            
            for(var i=0; i<tempDays.length; i += 7) {
                monthObj.days.push(tempDays.slice(i, i+7));
            }
            
            return monthObj;
        },
        
        nextMonth: function() {
            
        },
        
        previousMonth: function() {
            
        }
    }
});

Vue.component('datetimepicker', dateTimePicker);

var vm = new Vue({
    el: '#app'
});