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
                    <li>10 Reminders</li>
                    <li>&euro; 0,50/reminder</li>
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
            <form class="pricing">
                <div class="pricing-header promo">
                    <span class="pricing-currency promo">&euro;</span>18
                </div>
                <ul>
                    <li>40 Reminders</li>
                    <li>&euro; 0,45/reminder</li>
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
            <form class="pricing">
                <div class="pricing-header">
                    <span class="pricing-currency">&euro;</span>40
                </div>
                <ul>
                    <li>100 Reminders</li>
                    <li>&euro; 0,40/reminder</li>
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
