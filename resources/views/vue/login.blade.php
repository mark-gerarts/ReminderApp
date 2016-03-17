<script type="x/template" id="login-template">
    <h1 class="center">Sign in</h1>
    <p v-if="errorMessage.length > 0" class="warning-message">@{{ errorMessage }}</p>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form class="flat-form" @submit.prevent="signIn">
                <label for="email">E-mail Address</label>
                <span class="error-message" v-if="validationErrors.email">
                    <strong>@{{ validationErrors.email }}</strong>
                </span>
                <input type="email"
                    name="email"
                    id="email"
                    @input="validate"
                    v-model="formData.email"
                >

                <label for="password">Password</label>
                <span class="error-message" v-if="validationErrors.password">
                    <strong>@{{ validationErrors.password }}</strong>
                </span>
                <input type="password"
                    name="password"
                    id="password"
                    @input="validate"
                    v-model="formData.password"
                >

                <button type="submit" class="btn btn-submit">
                    <span v-show="!submitting">Log in</span>
                    <span v-else>
                        <i class="fa fa-spinner fa-pulse"></i>
                    </span>
                </button>
                <p class="addendum">
                    <a href="{{ url('/password/reset')}}">Forgot your password?</a>
                </p>
                <p class="addendum">
                    Not a user yet? <a v-link="{ path: '/register' }" class="register-link"><strong>Register here.</strong></a>
                </p>
            </form>
        </div>
    </div>
</script>
