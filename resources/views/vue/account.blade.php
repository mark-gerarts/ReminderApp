<template id="dashboard-account">
    <div class="row">
        <div class="col-md-6">
            <h2>Account information</h2>
            <p>Reset password etc</p>
            <p>Remaining balance yada yada</p>
        </div>
    </div>
    <h2 id="buymore">Buy more reminders.</h2>
    <div class="row row-grid">
        <div class="col-md-4">
            <form class="pricing" method="post" action="{{url('/usercheckout')}}">
                <div class="pricing-header">
                    <span class="pricing-currency">&euro;</span>5
                </div>
                <ul>
                    <li>20 Reminders</li>
                    <li>&euro; 0,25/reminder</li>
                    <li>Smallest amount</li>
                    <li></li>
                </ul>
                <div class="pricing-button">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="payment_type" value="1" />
                    <input type="submit" value="Buy"/>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form class="pricing" method="post" action="{{url('/usercheckout')}}">
                <div class="pricing-header promo">
                    <span class="pricing-currency promo">&euro;</span>10
                </div>
                <ul>
                    <li>50 Reminders</li>
                    <li>&euro; 0,20/reminder</li>
                    <li class="promo">Most popular</li>
                    <li></li>
                </ul>
                <div class="pricing-button promo">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="payment_type" value="2" />
                    <input type="submit" value="Buy"/>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form class="pricing" method="post" action="{{url('/usercheckout')}}">
                <div class="pricing-header">
                    <span class="pricing-currency">&euro;</span>15
                </div>
                <ul>
                    <li>150 Reminders</li>
                    <li>&euro; 0,15/reminder</li>
                    <li>Best price</li>
                    <li></li>
                </ul>
                <div class="pricing-button">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="payment_type" value="3" />
                    <input type="submit" value="Buy"/>
                </div>
            </form>
        </div>
    </div>
</template>
