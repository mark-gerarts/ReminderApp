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
                            <th><i class="fa fa-caret-left"></i></th>
                            <th colspan="5">January 2016</th>
                            <th><i class="fa fa-caret-right"></i></th>
                        </tr>
                        <tr>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                            <th>Sun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td>20</td>
                            <td>21</td>
                            <td>22</td>
                            <td>23</td>
                            <td>24</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>27</td>
                            <td>28</td>
                            <td>29</td>
                            <td>30</td>
                            <td>31</td>
                            <td></td>
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