<script type="x/template" id="register-template">
    <h1 class="center">Sign up</h1>
    <p v-if="errorMessage.length > 0" class="warning-message">@{{ errorMessage }}</p>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form @submit.prevent="register" class="flat-form">
                <label for="name"><span class="number">1</span>Name</label>
                <span class="error-message" v-if="validationErrors.name">
                    <strong>@{{ validationErrors.name }}</strong>
                </span>
                <input type="text" name="name" id="name" v-model="formData.name">

                <label for="email"><span class="number">2</span>E-mail Address</label>
                <span class="error-message" v-if="validationErrors.email">
                    <strong>@{{ validationErrors.email }}</strong>
                </span>
                <input type="email" name="email" id="email" v-model="formData.email">

                <label for="password"><span class="number">3</span>Password</label>
                <span class="error-message" v-if="validationErrors.password">
                    <strong>@{{ validationErrors.password }}</strong>
                </span>
                <input type="password" name="password" id="password" v-model="formData.password">

                <label for="password_confirmation"><span class="number">4</span>Confirm Password</label>
                <span class="error-message" v-if="validationErrors.password_confirmation">
                    <strong>@{{ validationErrors.password_confirmation }}</strong>
                </span>
                <input type="password" name="password_confirmation" id="password_confirmation" v-model="formData.password_confirmation">

                <button type="submit" class="btn btn-submit">Register</button>
                <p class="addendum">
                    Already have an account? <a v-link="{ path: '/login' }" class="register-link"><strong>Sign in here.</strong></a>
                </p>
            </form>
        </div>
    </div>
</script>
