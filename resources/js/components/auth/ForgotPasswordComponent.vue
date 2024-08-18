<template>
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1 underline-none"><b>Forgot Password</b></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Enter your email address</p>

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
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button
                            type="button"
                            @click="submitEmail"
                            class="btn btn-primary btn-block"
                        >
                            Continue
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
            email: "asd@gmail.com",
        };
    },
    methods: {
        submitEmail() {
            if (!this.email) {
                Toastr.fire({
                    icon: "error",
                    title: "Please enter your email address",
                });
            }

            axios
                .post("forgot-password", { email: this.email })
                .then(function (response) {
                    const data = response.data.data;
                    const message = response.data.message;
                    console.log(data,message)
                    Toastr.fire({
                        icon: message,
                        title: data,
                    });
                });
        },
    },
};
</script>

<style></style>
