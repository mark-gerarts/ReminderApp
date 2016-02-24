var validatorMixin = {
    methods: {
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

        _validate: function(data, rules, customMessage) {
            var self = this;
            var output;
            var rulesArray = rules.split('|');
            rulesArray.some(function(rule) {
                if(rule == "required") {
                    if(!self._required(data)) {
                        output = (customMessage) ? customMessage : "This field is required.";
                    }
                }
                if(rule.substr(0, 3) == "max") {
                    var maxLength = rule.split(':')[1];
                    if(!self._maxlength(data, maxLength)) {
                        output = (customMessage) ? customMessage : "This field can't be more than " + maxLength + " characters long.";
                    }
                }
                if(rule.substr(0, 3) == "min") {
                    var minLength = rule.split(':')[1];
                    if(!self._minlength(data, minLength)) {
                        output = (customMessage) ? customMessage : "This field has to be at least " + minLength + " characters long.";
                    }
                }
            });
            return output;
        },

        validateContact: function(contact) {
            var output = {}
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
