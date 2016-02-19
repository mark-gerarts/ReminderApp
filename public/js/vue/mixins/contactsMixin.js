var contactsMixin = {
    methods: {
        getContacts: function() {
            console.log('getting contacts...')
            this.$http.get('api/contacts').then(function(response) {
                //Success
                if(response.status == 200) {
                    store.setContacts(response.data);
                    //this.$set('contacts', response.data); //Binds the response object to the data object
                } else {
                    this.errors.getContacts = true;
                }
            }, function(error) {
                //Error
                //For debugging, PLEASE delete me for production
                var win = window.open("", "Title");
                win.document.body.innerHTML = error.data;

                //console.log(error);
                this.errors.getContacts = true;
            }).finally(function() {
                this.isLoading.getContacts = false;
            });
        },

        updateContact: function() {
            //Reset flags
            this.isLoading.delete = true;
            this.errors.delete = false;

            this.$http.put('api/contacts', JSON.stringify(this.contact)).then(function(response) {
                if(response.status != 200) {
                    this.errors.update = true;
                } else {
                    this.editing = false;
                }
            }, function(error) {
                if(error.status == 422) {
                    this.$set('validationErrors', error.data);
                } else {
                    this.errors.update = true;
                }
                console.log(error);
            }).finally(function() {
                this.isLoading.delete = false;
            })
        },

        deleteContact: function(contact) {
            //Reset flags
            this.isLoading.delete = true;
            this.errors.delete = false;

            this.$http.delete('api/contacts/' + this.contact.id).then(function(response) {
                //Success
                console.log(response)
                if(response.status == 200 && response.data) {
                    this.$remove();
                } else {
                    this.errors.delete = true;
                }
            }, function(error) {
                //Error
                console.log(error);
                this.errors.delete = true;
            }).finally(function() {
                this.isLoading.delete = false;
            });
        }
    }
};
