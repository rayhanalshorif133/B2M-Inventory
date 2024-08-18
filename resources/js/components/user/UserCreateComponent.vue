<template>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create a new User</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="required"
                                            >User Name</label
                                        >
                                        <input
                                            type="text"
                                            id="name"
                                            class="form-control"
                                            placeholder="Enter your name"
                                            v-model="name"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="optional"
                                            >Profile Image</label
                                        >
                                        <input
                                            type="file"
                                            id="name"
                                            class="form-control"
                                            placeholder="Enter your name"
                                            @change="uploadProfileImage"
                                            accept="image/*"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="required"
                                            >User Email</label
                                        >
                                        <input
                                            type="email"
                                            id="email"
                                            class="form-control"
                                            placeholder="Enter your email"
                                            v-model="email"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="required"
                                            >Password</label
                                        >
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            placeholder="Enter your password"
                                            v-model="password"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="confirm_password"
                                            class="required"
                                            >Confirm password</label
                                        >
                                        <input
                                            type="confirm_password"
                                            id="confirm_password"
                                            class="form-control"
                                            v-model="confirm_password"
                                            placeholder="Enter your confirm password"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select
                                            id="role"
                                            class="form-control custom-select"
                                            v-model="role"
                                            placeholder="Select role"
                                            required
                                        >
                                            <option selected disabled>
                                                Select role
                                            </option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button
                                    class="btn btn-primary btn-sm"
                                    @click="submitBtn"
                                    type="button"
                                >
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Budget</h3>
                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse"
                            >
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEstimatedBudget"
                                >Estimated budget</label
                            >
                            <input
                                type="number"
                                id="inputEstimatedBudget"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label for="inputSpentBudget"
                                >Total amount spent</label
                            >
                            <input
                                type="number"
                                id="inputSpentBudget"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label for="inputEstimatedDuration"
                                >Estimated project duration</label
                            >
                            <input
                                type="number"
                                id="inputEstimatedDuration"
                                class="form-control"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            image: null,
            email: "",
            role: "",
            password: "",
            image_type: "",
            confirm_password: "",
        };
    },
    methods: {
        togglePasswordVisibility() {
            this.isPasswordVisible = !this.isPasswordVisible;
        },
        uploadProfileImage(event) {
            const file = event.target.files[0];
            if(file.type == 'image/jpeg'){
                this.image_type = '.jpg';
            }else{
                this.image_type = '.png';
            }
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (e) => {
                this.image = e.target.result;
            };
        },
        submitBtn() {
            const checkValidity = this.checkValidity();

            if (checkValidity == true) {
                axios
                    .post("/user/create", {
                        name: this.name,
                        image: this.image,
                        email: this.email,
                        image_type: this.image_type,
                        role: this.role,
                        password: this.password,
                    })
                    .then(function (response) {
                        const data = response.data.data;
                        const message = response.data.message;

                        Toastr.fire({
                            icon: message,
                            title: data,
                        });

                        if (message == "success") {
                            setTimeout(() => {
                                window.location.href = "/user/list";
                            }, 1600);
                        }
                    });
            }
        },
        checkValidity() {
            if (!this.name || !this.email) {
                Toastr.fire({
                    icon: "warning",
                    title: "Please enter user name and email",
                });
                return false;
            }

            if (!this.role) {
                Toastr.fire({
                    icon: "warning",
                    title: "Please select a role!",
                });
                return false;
            }
            if (this.password && this.password != this.confirm_password) {
                this.confirm_password = "";
                Toastr.fire({
                    icon: "warning",
                    title: "Password is not match with confirmation password",
                });
                return false;
            }
            return true;
        },
    },
};
</script>

<style></style>
