<template id="login-template">
    <h1 class="center">Sign in</h1>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form class="flat-form" @submit.prevent="signIn">
                <label for="email">E-mail Address</label>
                <input type="email" name="email" id="email" v-model="formData.email">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" v-model="formData.password">

                <button type="submit" class="btn btn-submit">
                    Log in
                </button>
                <p class="addendum">
                    <a href="{{ url('/password/reset')}}">Forgot your password?</a>
                </p>
                <p class="addendum">
                    Not a user yet? <a href="{{ url('/register') }}" class="register-link"><strong>Register here.</strong></a>
                </p>
            </form>
        </div>
    </div>
</template>
