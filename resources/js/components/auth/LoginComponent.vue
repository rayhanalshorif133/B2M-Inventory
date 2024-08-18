<template>
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1 underline-none"><b>INVENTORY</b></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="#" method="POST">
                <div class="input-group mb-3">
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        v-model="email"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        v-model="password"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" />
                            <label for="remember"> Remember Me </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button
                            type="button"
                            @click="submitLogin"
                            class="btn btn-primary btn-block"
                            style="width: fit-content"
                            :disabled="isLoginBtn"
                        >
                            {{ loginBtnText }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="/forgot-password">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="/register" class="text-center"
                    >Register a new membership</a
                >
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</template>

<script>
export default {
    data() {
        return {
            email: "test@b2m-tech.com",
            password: "password",
            loginBtnText: "Log in",
            isLoginBtn: false,
        };
    },
    methods: {
        submitLogin() {
            this.loginBtnText = "Processing...";
            this.isLoginBtn = true;
            axios
                .post("login", {
                    email: this.email,
                    password: this.password,
                })
                .then(function (response) {
                    const data = response.data.data;
                    const message = response.data.message;
                    sessionStorage.setItem('msg', message);
                    Toastr.fire({
                        icon: message,
                        title: data,
                    });
                    if (message == "success") {
                        window.location.href = "/home";
                    }
                });

             setTimeout(()=>{
                const getMsg = sessionStorage.getItem('msg');
                if(getMsg == 'error'){
                    this.loginBtnText = "Login";
                    this.isLoginBtn = false;
                }
             },1000);
        },
    },
};
</script>
