var contactsMixin = {
    methods: {
        getContacts: function() {
            this.$http.get('api/contacts').then(function(response) {
                //Success
                if(response.status == 200) {
                    this.$set('contacts', response.data); //Binds the response object to the data object
                } else {
                    this.hasError.getContacts = true;
                }
            }, function(error) {
                //Error
                //For debugging, PLEASE delete me for production
                var win = window.open("", "Title");
                win.document.body.innerHTML = error.data;

                //console.log(error);
                this.hasError.getContacts = true;
            }).finally(function() {
                this.isLoading.getContacts = false;
            });
        },
    }
}
