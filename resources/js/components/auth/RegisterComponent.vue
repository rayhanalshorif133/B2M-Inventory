<template>
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1 underline-none"><b>INVENTORY</b></a>
        </div>
        <div class="card-body">
            <p class="register-msg-box">Register as a new member</p>

            <form action="#" method="post">
                <div class="card card-outline p-3 card-info">
                    <h2 class="text-sm font-semibold">Company Info</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="company_name"
                                    placeholder="Name"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fa-solid fa-building"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <label
                                    for="logo-upload"
                                    class="btn logo-upload-btn"
                                >
                                    <span v-if="placeholder_logo_upload">{{
                                        placeholder_logo_upload.name
                                    }}</span>
                                    <span v-else>Upload Your Company Logo</span>
                                </label>
                                <input
                                    type="file"
                                    class="d-none form-control"
                                    id="logo-upload"
                                    @change="onLogoFileChange"
                                />
                                <div class="input-group-append cursor-pointer">
                                    <label
                                        class="input-group-text cursor-pointer"
                                        style="
                                            height: fit-content;
                                            padding: 10px;
                                        "
                                        for="logo-upload"
                                    >
                                        <span :class="uploadIcon"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input
                                    type="email"
                                    class="form-control"
                                    placeholder="Email"
                                    v-model="company_email"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fa-solid fa-envelope"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Address"
                                    v-model="company_address"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fa-solid fa-location-dot"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    v-model="company_phone"
                                    class="form-control"
                                    placeholder="Contact number"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa-solid fa-phone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <textarea
                            type="text"
                            v-model="company_other_info"
                            class="form-control"
                            placeholder="Others information"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa-solid fa-circle-info"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-outline p-3 card-green mt-2">
                    <h2 class="text-sm font-semibold">User Info</h2>
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control"
                            v-model="user_name"
                            placeholder="name"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="email"
                            class="form-control"
                            v-model="user_email"
                            placeholder="Email"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            :type="passwordFieldType"
                            class="form-control"
                            v-model="password"
                            placeholder="Password"
                        />
                        <div
                            class="input-group-append"
                            @click="togglePasswordVisibility"
                        >
                            <div class="input-group-text cursor-pointer">
                                <span :class="passwordIconClass"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            :type="passwordFieldType"
                            v-model="passwordConfirmation"
                            class="form-control"
                            placeholder="Confirm Password"
                            required
                        />
                        <div class="input-group-append">
                            <div
                                class="input-group-text cursor-pointer"
                                @click="togglePasswordVisibility"
                            >
                                <span :class="passwordIconClass"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- /.col -->
                    <div class="col-12">
                        <button
                            type="button"
                            @click="submitForm"
                            class="btn btn-primary btn-block"
                            :disabled="!isFormValid"
                        >
                            {{ registerBtnText }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-0 mx-auto text-center mt-2">
                Already signed in?
                <a href="/login" class="text-center">Login Now</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</template>

<script>
import { ref } from "vue";

export default {
    data() {
        return {
            company_name: "",
            company_logo: null,
            company_email: "",
            company_address: "",
            company_phone: "",
            company_other_info: "",
            user_name: "",
            user_email: "",
            password: "",
            passwordConfirmation: "",
            errorMessage: "",
            isPasswordVisible: false,
            placeholder_logo_upload: null,
            uploadIcon: "fa fa-upload",
            registerBtnText: "Register Now",
        };
    },
    computed: {
        isFormValid() {
            return this.password && this.password === this.passwordConfirmation;
        },
        passwordFieldType() {
            return this.isPasswordVisible ? "text" : "password";
        },
        passwordIconClass() {
            return this.isPasswordVisible
                ? "fa-solid fa-lock"
                : "fa-solid fa-unlock";
        },
    },
    methods: {
        togglePasswordVisibility() {
            this.isPasswordVisible = !this.isPasswordVisible;
        },
        onLogoFileChange(event) {
            const file = event.target.files[0];
            this.placeholder_logo_upload = file;
            this.uploadIcon = "fa-solid fa-check";
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (e) => {
                this.company_logo = e.target.result;
            };

            // Check FormData content
        },
        submitForm() {
            if (this.isFormValid) {
                if (!this.company_logo) {
                    Toastr.fire({
                        icon: "warning",
                        title: "Please select a company logo first!",
                    });
                    return;
                }

                if (!this.user_name || !this.user_email || !this.password) {
                    Toastr.fire({
                        icon: "warning",
                        title: "User information is required!",
                    });
                    return;
                }

                const data = {
                    user_info: {
                        name: this.user_name,
                        email: this.user_email,
                        password: this.password,
                    },
                    company_info: {
                        name: this.company_name,
                        email: this.company_email,
                        address: this.company_address,
                        phone: this.company_phone,
                        logo: this.company_logo,
                        other_info: this.company_other_info,
                    },
                };

                this.registerBtnText = "Processing ...";


                axios
                    .post("register", data)
                    .then((response) => {
                        const data = response.data.data;
                        const message = response.data.message;
                        Toastr.fire({
                            icon: message,
                            title: data,
                        });

                        if (message == "success") {
                            setTimeout(() => {
                                window.location.href = "/login";
                            }, 1600);
                        }
                    })
                    .catch((error) => {
                        Toastr.fire({
                            icon: "error",
                            title: "Something went wrong, please try again!",
                        });
                    });
            } else {
                Toastr.fire({
                    icon: "error",
                    title: "Passwords do not match.",
                });
            }
        },
    },
};
</script>
