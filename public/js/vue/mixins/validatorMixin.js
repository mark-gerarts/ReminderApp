/*
 *
 *   Mixin to share validation across components.
 *
 */

var validatorMixin = {
    methods: {
        // List of methods to validate all the needed stuff
        // Each returns true if the input is valid, or if there
        // is no input (for when it isn't required).
        _maxlength: function(data, max) {
            if(!data) { return true; }
            return data.length <= max;
        },
        _minlength: function(data, min) {
            if(!data) { return true; }
            return data.length >= min;
        },
        _required: function(data) {
            if(!data) {
                return false;
            } else if(data.toString().trim().length == 0) {
                return false;
            }
            return true;
        },
        _numeric: function(data) {
            if(!data) { return true; }
            return !isNaN(data);
        },

        // Validate function: parses the validationrules and executes
        // the associated validation methods.
        // 'customMessage' is formed the same way as in Laravel, e.g. "required|max:10"
        // Returns a string if an error is found
        _validate: function(data, rules, customMessage) {
            var self = this;
            var output;
            var rulesArray = rules.split('|');
            rulesArray.some(function(rule) {
                if(rule == "required") {
                    if(!self._required(data)) {
                        output = (customMessage) ? customMessage : "This field is required.";
                        return true;
                    }
                }
                if(rule == "numeric") {
                    if(!self._numeric(data)) {
                        output = (customMessage) ? customMessage : "This field is has to be numeric.";
                        return true;
                    }
                }
                if(rule.substr(0, 3) == "max") {
                    var maxLength = rule.split(':')[1];
                    if(!self._maxlength(data, maxLength)) {
                        output = (customMessage) ? customMessage : "This field can't be more than " + maxLength + " characters long.";
                        return true;
                    }
                }
                if(rule.substr(0, 3) == "min") {
                    var minLength = rule.split(':')[1];
                    if(!self._minlength(data, minLength)) {
                        output = (customMessage) ? customMessage : "This field has to be at least " + minLength + " characters long.";
                        return true;
                    }
                }
            });
            return output;
        },

        // Functions to be used in the components.

        // Checks for contact name & number.
        // Returns an object with validation errors for each property.
        validateContact: function(contact) {
            var output = {};
            var nameError = this._validate(contact.name, "required|max:255");
            var numberError = this._validate(contact.number, 'required|max:20|min:6');
            if(nameError) output.name = nameError;
            if(numberError) output.number = numberError;
            return output;
        },

        // Checks for reminder properties.
        // Returns an object with validation errors for each property.
        validateReminder: function(reminder) {
            var output = {};
            var repeatError = this._validate(reminder.repeat_id, "required|numeric");
            var messageError = this._validate(reminder.message, "required|max:255");
            var send_datetimeError = this._validate(reminder.send_datetime, "required|max:255");
            var contact_idError = this._validate(reminder.contact_id, "numeric");
            var recipientError = this._validate(reminder.recipient, "max:255");
            if(repeatError) output.repeat_id = repeatError;
            if(messageError) output.message = messageError;
            if(send_datetimeError) output.send_datetime = send_datetimeError;
            if(contact_idError) output.contact_id = contact_idError;
            if(recipientError) output.recipient = recipientError;
            if(!(reminder.contact_id || reminder.recipient)) {
                output.no_recipient = "This field is required.";
            }
            return output;
        },

        // Checks for  quick reminder properties.
        // Returns an object with validation errors for each property.
        validateQuickReminder: function(reminder) {
            var output = {};
            var messageError = this._validate(reminder.message, "required|max:255");
            var send_datetimeError = this._validate(reminder.send_datetime, "required|max:255");
            var recipientError = this._validate(reminder.recipient, "required|max:255");
            if(messageError) output.message = messageError;
            if(send_datetimeError) output.send_datetime = send_datetimeError;
            if(recipientError) output.recipient = recipientError;
            return output;
        },

        validateLogin: function(formdata) {
            var output = {};
            var emailError = this._validate(formdata.email, "required");
            var passwordError = this._validate(formdata.password, "required");
            if(emailError) output.email = emailError;
            if(passwordError) output.password = passwordError;
            return output;
        },

        validateSignup: function(formdata) {
            // ToDooooooooooooo
            var output = {};
            var emailError = this._validate(formdata.email, "required");
            var passwordError = this._validate(formdata.password, "required");
            if(emailError) output.email = emailError;
            if(passwordError) output.password = passwordError;
            return output;
        }
    }
};
