var contactsMixin = {
    methods: {
        //Debugging function
        _openErrorWindow: function(msg) {
            var win = window.open("", "Title");
            win.document.body.innerHTML = msg;
        },

        getContacts: function() {
            this.$http.get('api/contacts').then(function(response) {
                //Success
                if(response.status == 200) {
                    store.setContacts(response.data);
                } else {
                    this.errors.getContacts = true;
                }
            }, function(error) {
                //Error
                this._openErrorWindow(error.data);
                this.errors.getContacts = true;
            }).finally(function() {
                this.isLoading.getContacts = false;
            });
        },

        insertContact: function() {
            //Reset flags
            this.isLoading.insertContact = true;
            this.errors.insertContact =false;

            this.$http.post('api/contacts', JSON.stringify(this.newContact)).then(function(response) {
                //Success
                if(response.status == 200) {
                    this.newContact.id = response.data;
                    store.addContact(this.newContact);
                    this.newContact = {}; // Reset the viewmodel. This only happens when the insert is successful,
                                          // thus the user doesn't have to re-enter values in case of an error.
                    this.validationErrors = {}; //Reset the validationerrors
                } else {
                    this.errors.insertContact = true;
                }
            }, function(error) {
                //Error

                if(error.status == 422) { //422 = validation errors
                    this.$set('validationErrors', error.data); //Bind the data
                } else {
                    this._openErrorWindow(error.data);
                    this.errors.insertContact = true;
                }
            }).finally(function() {
                this.isLoading.insertContact = false;
            });
        },

        updateContact: function(contact) {
            //Reset flags
            this.isLoading.updateContact = true;
            this.errors.updateContact = false;

            this.$http.put('api/contacts', JSON.stringify(contact)).then(function(response) {
                if(response.status == 200) {
                    store.updateContact(contact);
                } else {
                    this.errors.updateContact = true;
                }
            }, function(error) {
                if(error.status == 422) {
                    this.$set('validationErrors', error.data);
                } else {
                    this._openErrorWindow(error.data);
                    this.errors.updateContact = true;
                }
            }).finally(function() {
                this.isLoading.updateContact = true;
            });
        },

        deleteContact: function(contact) {
            //Reset flags
            this.isLoading.deleteContact = true;
            this.errors.deleteContact = false;

            this.$http.delete('api/contacts/' + this.contact.id).then(function(response) {
                //Success
                console.log(response)
                if(response.status == 200 && response.data) {
                    store.removeContact(contact);
                } else {
                    this.errors.deleteContact = true;
                }
            }, function(error) {
                this._openErrorWindow(error.data);
                this.errors.deleteContact = true;
            }).finally(function() {
                this.isLoading.deleteContact = false;
            });
        }
    }
};
