@extends('layouts.dashboard')

@section('style')
    {{-- ToDo: put these in one file --}}
    <link rel="stylesheet" href="{{ url('css/contacts.css')}}" />
@endsection

@section('content')
    <router-view></router-view>
@endsection

@section('vue-templates')
    @include('vue.home')
    @include('vue.contacts')
    @include('vue.contactrow')
@endsection

@section('scripts')
    <script>
        var myRootUrl = "{{ env('MY_ROOT_URL') }}";
    </script>

    {{-- Don't forget to change these to .min.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/0.7.10/vue-router.js"></script>

    <script src="{{ url('js/vue/mixins/contactsMixin.js') }}"></script>
    <script src="{{ url('js/vue/components/home.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/contactRow.vue.js')}}"></script>
    <script src="{{ url('js/vue/components/contacts.vue.js')}}"></script>
    <script src="{{ url('js/vue/routing.vue.js')}}"></script>
@endsection
