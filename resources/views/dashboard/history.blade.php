@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ url('css/datetimetest.css') }}">
@endsection

@section('content')
<div class="container" id="app">
    <div class="row">
       <div class="col-md-3">
           <h1>Testing area</h1>
           <datetimepicker name="datetime"></datetimepicker>
        </div>
    </div>
</div>

<template id="datetimepicker-template"><!-- todo: move to <script> bc IE //-->
    <div class="datetimepicker-group-wrapper">
        <input type="text" name="@{{name}}">
        <div class="datetimepicker-wrapper">
            <div class="datetimepicker">
                <table class="datetime-table">
                    <thead>
                        <tr>
                            <th @click="previousMonth">
                                <i class="fa fa-caret-left"></i>
                            </th>
                            <th colspan="5">
                                @{{ labels.months[activeMonth.month] }} @{{ activeMonth.year }}
                            </th>
                            <th @click="nextMonth">
                                <i class="fa fa-caret-right"></i>
                            </th>
                        </tr>
                        <tr>
                            <th v-for="dayLabel in labels.days">@{{ dayLabel }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="week in activeMonth.days">
                            <td v-for="dayNumber in week" track-by="$index" :class="dayNumber ? 'table-day' : ''">@{{ dayNumber }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
    
</template>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src="{{ url('js/datetimetest.vue.js')}}"></script>
@endsection