Vue.http.options.root = 'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').innerHTML;

var vm = new Vue({
    el: '#app',
    
    ready: function() {
        this.getContacts();
    },
    
    data: {
        contacts: [],
        newContact: {
            name: '',
            number: ''
        },
        item: {}
    },
    
    methods: {
        getContacts: function() {
            this.$http.get('api/contacts').then(function(response) {
                this.$set('contacts', response.data);
            }, function(error) {
                console.log(error);
            }).finally(function() {
                //Finally?
                console.log('done');
            })
        },
        
        insertContact: function() {
            this.$http.post('api/contacts', JSON.stringify(this.newContact)).then(function(response) {
                console.log(response);
                if(response.status == 200) {
                    this.newContact.id = response.data;
                    this.contacts.push(this.newContact);
                    this.newContact = {};
                }
            }, function(error) {
                console.log(error);
            }).finally(function() {
                console.log('insert finished')
            })
        },
        
        deleteContact: function(contact) {
            console.log(contact.id);
        }
    }
});