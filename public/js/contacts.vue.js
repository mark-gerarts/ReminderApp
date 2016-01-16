Vue.http.options.root = 'http://localhost:8080/www/webontwikkelaar/eindwerk/ReminderApp/public/';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf_token').innerHTML;

var contactRow = Vue.extend({
    template: '#contact-template',
    props: {
        contact: {},
        editing: false
    },
    methods: {
        updateContact: function() {
            console.log('updating');
            this.$parent.updateContact(this.contact);
            this.editing = false;
        }
    }
});

Vue.component('contact-row', contactRow)


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
        editing: false
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
            this.$http.delete('api/contacts/' + contact.id).then(function(response) {
                console.log(response);
                this.contacts.$remove(contact);
            }, function(error) {
                console.log(error);
            }).finally(function() {
                console.log('delete finished');
                return true; //ToDo: add check to see if successful
            })
        },
        
        updateContact: function(contact) {
            this.$http.put('api/contacts', JSON.stringify(contact)).then(function(response) {
                console.log(response);
            }, function(error) {
                console.log(error);
            }).finally(function() {
                console.log('update finished')
            })
        }
    }
});