/*
 *
 *   Mixin to share contact http functions across components.
 *
 */

var contactsMixin = {
    methods: {
        //Debugging function - should be deleted!!!
        _openErrorWindow: function(msg) {
            var win = window.open("", "Title");
            win.document.body.innerHTML = msg;
        },

        getContacts: function() {
            // Set flags
            this.isLoading.getContacts = true;
            this.errors.insertContact = false;

            this.$http.get('api/contacts').then(function(response) {
                // Success
                if(response.status == 200) {
                    // Contacts are saved to the shared store.
                    contactsStore.setContacts(response.data);
                } else {
                    this.errors.getContacts = true;
                }
            }, function(error) {
                // Error
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                this._openErrorWindow(error.data);
                this.errors.getContacts = true;
            }).finally(function() {
                this.isLoading.getContacts = false;
            });
        },

        insertContact: function() {
            // Set flags
            this.isLoading.insertContact = true;
            this.errors.insertContact =false;

            this.$http.post('api/contacts', JSON.stringify(this.newContact)).then(function(response) {
                //Success
                if(response.status == 200) {
                    this.newContact.id = response.data; // Add the new id to the user
                    contactsStore.addContact(this.newContact);
                    this.newContact = {}; // Reset the viewmodel. This only happens when the insert is successful,
                                          // thus the user doesn't have to re-enter values in case of an error.
                } else {
                    this.errors.insertContact = true;
                }
            }, function(error) {
                //Error
                console.log(error)
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                this._openErrorWindow(error.data);
                this.errors.insertContact = true;
            }).finally(function() {
                this.isLoading.insertContact = false;
            });
        },

        updateContact: function(contact) {
            // set flags
            this.isLoading.updateContact = true;
            this.errors.updateContact = false;

            this.$http.put('api/contacts', JSON.stringify(contact)).then(function(response) {
                // Success
                if(response.status == 200) {
                    contactsStore.updateContact(contact);
                } else {
                    this.errors.updateContact = true;
                }
            }, function(error) {
                // Error
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                this._openErrorWindow(error.data);
                this.errors.updateContact = true;
            }).finally(function() {
                this.isLoading.updateContact = false;
            });
        },

        deleteContact: function(contact) {
            // Set flags
            this.isLoading.deleteContact = true;
            this.errors.deleteContact = false;

            this.$http.delete('api/contacts/' + this.contact.id).then(function(response) {
                //Success
                console.log(response)
                if(response.status == 200 && response.data) {
                    contactsStore.removeContact(contact);
                } else {
                    this.errors.deleteContact = true;
                }
            }, function(error) {
                // Error
                if(error.status == 401) {
                    this.$dispatch('not-logged-in');
                }
                this._openErrorWindow(error.data);
                this.errors.deleteContact = true;
            }).finally(function() {
                this.isLoading.deleteContact = false;
            });
        }
    }
};
