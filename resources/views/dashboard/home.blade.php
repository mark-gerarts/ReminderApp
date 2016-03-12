<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ReminderApp Dashboard</title>

    <!-- Links loaded on all pages -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url('lib/grid12.css') }}">
    <link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ url('css/datetimepicker.css') }}">
    <!-- Page specific styles -->
    @yield('style')

</head>


<body id="app">
    <div class="wrapper">
        <div class="container-fluid navbar">
            <div class="container">
                <nav>
                    <div class="no-padding-left">
                        <a v-link="{ path: '/'}">Dashboard</a>
                        <i class="fa fa-caret-up fa-fw arrow"></i>
                    </div>
                    <div><a v-link="{ path: '/contacts' }">Contacts</a></div>
                    <div><a v-link="{ path: '/account' }">Account</a></div>
                </nav>
                <div class="user">Logged in as //ToDo. <a v-link="{ path: '/logout' }" class="log-out">Log out</a></div>
            </div>
        </div>
        <div class="container">
            <router-view></router-view>
        </div>
        <footer>
            &copy; 2015 RemindMe - <a href="{{ url('/')}}">Homepage</a>
        </footer>
    </div>

    @include('vue.home')
    @include('vue.contacts')
    @include('vue.contactrow')
    @include('vue.account')
    @include('vue.reminderrow')
    @include('vue.datetimepicker')
    @include('vue.login')
    @include('vue.register')

    <script>
        var myRootUrl = "{{ env('MY_ROOT_URL') }}";
        var csrf_token = "{{ csrf_token() }}";
    </script>

    {{-- Don't forget to change these to .min.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/0.7.10/vue-router.js"></script>

    <script src="{{ url('js/vue/mixins/authMixin.js') }}"></script>
    <script src="{{ url('js/vue/mixins/contactsMixin.js') }}"></script>
    <script src="{{ url('js/vue/mixins/remindersMixin.js') }}"></script>
    <script src="{{ url('js/vue/mixins/validatorMixin.js') }}"></script>
    <script src="{{ url('js/vue/stores/contactsStore.js')}}"></script>
    <script src="{{ url('js/vue/stores/remindersStore.js')}}"></script>
    <script src="{{ url('js/vue/stores/authStore.js')}}"></script>
    <script src="{{ url('js/vue/components/login.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/logout.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/register.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/reminderRow.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/datetimepicker.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/home.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/contactRow.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/contacts.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/account.vue.js')}}"></script>
    <script src="{{ url('js/vue/app.vue.js')}}"></script>
</body>
</html>
