/*
 *
 *   Mixin to share validation across components.
 *
 */

var validatorMixin = {
    methods: {
        // List of methods to validate all the needed stuff
        // Each returns true if the input is valid
        _maxlength: function(data, max) {
            return data.length <= max;
        },
        _minlength: function(data, min) {
            return data.length >= min;
        },
        _required: function(data) {
            if(!data || data.length == 0) {
                return false;
            }
            return true;
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
            if(nameError) {
                output.name = nameError;
            }
            if(numberError) {
                output.number = numberError;
            }
            return output;
        }
    }
};
