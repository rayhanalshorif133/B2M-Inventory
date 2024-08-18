<template>
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1 underline-none"><b>Reset Your Password</b></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Enter your new password</p>

            <form action="#" method="POST">
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
                <div class="input-group mb-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="Confirmation Password"
                        v-model="confirmation_password"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button
                            type="button"
                            @click="submitNewPassword"
                            class="btn btn-primary btn-block"
                        >
                            Submit
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->

            <p class="my-2">
                <a href="/login">Back to Login</a>
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
            email: "",
            password: "",
            confirmation_password: "",
        };
    },
    created() {
        this.getEmailFromUrl();
    },
    methods: {
        getEmailFromUrl() {
            const url = new URL(window.location.href);
            const email = url.searchParams.get("email");
            this.email = email;
        },
        submitNewPassword() {

            if(this.password !== this.confirmation_password){
                Toastr.fire({
                    icon: "error",
                    title: "Password and Confirmation Password are not match"
                })
                return false;
            }

            if (!this.password && !this.confirmation_password) {
                Toastr.fire({
                    icon: "error",
                    title: "Please enter password and confirmation password",
                });
                return false;
            }

            axios
                .post("reset-password", {
                    email: this.email,
                    password: this.password,
                })
                .then(function (response) {
                    const data = response.data.data;
                    const message = response.data.message;
                    Toastr.fire({
                        icon: message,
                        title: data,
                    });

                    if(message == 'success'){
                        setTimeout(function () {
                            window.location.href = '/login';
                        }, 1000);
                    }
                });
        },
    },
};
</script>

<style></style>
