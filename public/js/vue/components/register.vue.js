var Register = Vue.extend({
    template: "#register-template",

    data: function() {
        return {
            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        }
    }
})
