/*
 *
 *   Component to display a datetime picker.
 *
 */

var dateTimePicker = Vue.extend({
    template: '#datetimepicker-template',

    // Name is the input name;
    // result is used to get data binding to the parent.
    props: ['name', 'result'],

    ready: function() {
        // Set the current month to this day's month, and initialise the result as the current datetime
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
        result: {
            // The getter is computed from the selectedValue data.
            get: function() {
                return this.selectedValues.year + '-'
                        + this.format(this.selectedValues.month) + '-'
                        + this.format(this.selectedValues.date) + ' '
                        + this.format(this.selectedValues.hour) + ':'
                        + this.format(this.selectedValues.minute);
            }, set: function(newValue) {
                // The setter is used when the user manually types a date & time.
                this.parseFromString(newValue);
            }
        }
    },
    methods: {
        // Get a datetime from a Y-m-d H:i:s string
        parseFromString: function(datetimestring) {
            datetimestring = datetimestring || '';
            var split = datetimestring.trim().split(' ');
            var date = split[0] || '';
            var time = split[1] || '';
            var dateSplit = date.split('-') || '';
            this.selectedValues.year = dateSplit[0] || this.currentDate.getFullYear();
            this.selectedValues.month = dateSplit[1] || this.currentDate.getMonth() + 1;
            this.selectedValues.date = dateSplit[2] || this.currentDate.getDate();
            var timeSplit = time.split(':') || '';
            this.selectedValues.hour = timeSplit[0] || this.currentDate.getHours();
            this.selectedValues.minute = timeSplit[1] || this.currentDate.getMinutes();

        },
        // Generate a month, to be used in the calendar.
        generateMonth: function(year, month) {
            var myDate = new Date(year, month);
            var startDay = myDate.getDay() - 1;
            // Make the week start on monday in stead of sunday
            startDay = (startDay == -1) ? 6 : startDay;
            var daysInMonth = this.daysInMonth[month];
            var monthObj = {};
            monthObj.year = year;
            monthObj.month = month;
            monthObj.days = [];

            // Check for leap year.
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

        // Transition to the next month.
        nextMonth: function() {
            var nextYear = this.activeMonth.year;
            var nextMonth = ++this.activeMonth.month%12;
            if(nextMonth == 0) {
                nextYear++;
            }
            this.activeMonth = this.generateMonth(nextYear, nextMonth);
        },

        // Transition to the previous month.
        previousMonth: function() {
            var prevYear = this.activeMonth.year;
            var prevMonth = (--this.activeMonth.month+12)%12;
            if(prevMonth == 11) {
                prevYear--;
            }
            this.activeMonth = this.generateMonth(prevYear, prevMonth);
        },

        // Handle day select.
        selectDay: function(dayNumber) {
            if(dayNumber) {
                this.selectedValues.year = this.activeMonth.year;
                this.selectedValues.month = this.activeMonth.month + 1;
                this.selectedValues.date = dayNumber;
            }
        },

        // Put 0's to the left of a number < 10;
        format: function(number) {
            if(number.toString().length < 2) { // .. change to < 10? todo?
                return '0' + number;
            }
            return number;
        },

        // Increment a number, between min and max,
        // used in the timepicker.
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
