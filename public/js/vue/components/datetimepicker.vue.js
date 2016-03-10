var dateTimePicker = Vue.extend({
    template: '#datetimepicker-template',

    props: ['name', 'result'],

    ready: function() {
        this.activeMonth = this.generateMonth(this.currentDate.getFullYear(), this.currentDate.getMonth());
        this.selectedValues.year = this.currentDate.getFullYear();
        this.selectedValues.month = this.currentDate.getMonth() + 1;
        this.selectedValues.date = this.currentDate.getDate();
        this.selectedValues.hour = this.format(this.currentDate.getHours());
        this.selectedValues.minute = this.format(this.currentDate.getMinutes());
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
                year: 0,
                month: 0,
                days: []
            },
            selectedValues: {
                year: '',
                month: '',
                date: '',
                hour: '',
                minute: '',
            },
            showTime: false,
            visible: false
        }
    },
    computed: {
        result: function() {
            return this.selectedValues.year + '-'
                    + this.format(this.selectedValues.month) + '-'
                    + this.format(this.selectedValues.date) + ' '
                    + this.format(this.selectedValues.hour) + ':'
                    + this.format(this.selectedValues.minute);
        }
    },
    methods: {
        generateMonth: function(year, month) {
            var myDate = new Date(year, month);
            var startDay = myDate.getDay() - 1;
            startDay = (startDay == -1) ? 6 : startDay;
            var daysInMonth = this.daysInMonth[month];
            var monthObj = {};
            monthObj.year = year;
            monthObj.month = month;
            monthObj.days = [];

            if(month == 1 && (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0))) {
                daysInMonth++;
            }

            var tempDays = [];
            for(var i=0; i<daysInMonth+startDay; i++) {
                if(i<startDay) {
                    tempDays.push('');
                } else {
                    tempDays.push(i - startDay + 1);
                }
            }
            while(tempDays.length%7 != 0) {
                tempDays.push('');
            }
            for(var i=0; i<tempDays.length; i += 7) {
                monthObj.days.push(tempDays.slice(i, i+7));
            }

            return monthObj;
        },

        nextMonth: function() {
            var nextYear = this.activeMonth.year;
            var nextMonth = ++this.activeMonth.month%12;
            if(nextMonth == 0) {
                nextYear++;
            }
            this.activeMonth = this.generateMonth(nextYear, nextMonth);
        },

        previousMonth: function() {
            var prevYear = this.activeMonth.year;
            var prevMonth = (--this.activeMonth.month+12)%12;
            if(prevMonth == 11) {
                prevYear--;
            }
            this.activeMonth = this.generateMonth(prevYear, prevMonth);
        },

        selectDay: function(dayNumber) {
            if(dayNumber) {
                this.selectedValues.year = this.activeMonth.year;
                this.selectedValues.month = this.activeMonth.month + 1;
                this.selectedValues.date = dayNumber;
            }
        },

        format: function(number) {
            if(number.toString().length < 2) {
                return '0' + number;
            }
            return number;
        },

        increment(myVar, min, max, increment) {
            increment = typeof increment !== 'undefined' ? increment : 1;
            myVar = parseInt(myVar) + increment;
            if(myVar > max) {
                myVar = min;
            } else if(myVar < min) {
                myVar = max;
            }
            return myVar;
        }
    }
});
