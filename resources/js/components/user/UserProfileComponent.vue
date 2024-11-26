<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="mx-auto profile-container">
                    <div class="card" :class="BGCard">
                        <div class="card-header relative">
                            <h3 class="card-title mt-2">About Me</h3>
                            <div
                                class="absolute"
                                style="top: 5rem; right: 10px"
                            >
                                <button
                                    v-if="!isActiveEdit"
                                    class="btn btn-success btn-sm float-right btn-tool"
                                    type="button"
              0                      @click="handleEditProfileBtn('edit')"
                                >
                                    Edit Profile
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>

                        <div v-if="!isActiveEdit" class="card-body">
                            <div class="text-center">
                                <img
                                    class="profile-user-img img-fluid img-circle"
                                    :src="user.image_url"
                                    alt="User profile picture"
                                />
                            </div>
                            <h3 class="profile-username text-center">
                                {{ user.name }}
                            </h3>
                            <p class="text-muted text-center text-capitalize">
                                <span class="badge badge-success">{{
                                    user.roles
                                }}</span>
                            </p>
                            <p class="text-muted text-center">
                                <i class="fa-solid fa-envelope mr-1"> </i
                                >{{ user.email }}
                            </p>
                            <hr />
                            <strong>
                                <i class="fa-solid fa-circle-info mr-1"></i>
                                Company Info</strong
                            >
                            <div class="company-info">
                                <!-- Company Name -->
                                <strong>
                                    <i class="fa-solid fa-building mr-1"></i>
                                    Name
                                </strong>
                                <p class="text-muted">
                                    {{ user.company.name }}
                                </p>

                                <!-- Company Logo -->
                                <strong>
                                    <i class="fa-solid fa-image mr-1"></i>
                                    Company Logo
                                </strong>
                                <p>
                                    <img
                                        :src="user.company.logo"
                                        alt="Company Logo"
                                        class="company-logo"
                                    />
                                </p>

                                <!-- Company Email -->
                                <strong>
                                    <i class="fa-solid fa-envelope mr-1"></i>
                                    Email
                                </strong>
                                <p class="text-muted">
                                    {{ user.company.email }}
                                </p>

                                <!-- Company Address -->
                                <strong>
                                    <i
                                        class="fa-solid fa-map-marker-alt mr-1"
                                    ></i>
                                    Address
                                </strong>
                                <p class="text-muted">
                                    {{ user.company.address }}
                                </p>

                                <!-- Company Phone -->
                                <strong>
                                    <i class="fa-solid fa-phone mr-1"></i>
                                    Phone
                                </strong>
                                <p class="text-muted">
                                    {{ user.company.phone }}
                                </p>

                                <!-- Other Info -->
                                <strong>
                                    <i class="fa-solid fa-info-circle mr-1"></i>
                                    Other Info
                                </strong>
                                <p class="text-muted">
                                    {{ user.company.other_info }}
                                </p>
                            </div>
                        </div>
                        <div v-else class="card-body">
                            <div class="text-left">
                                <label class="required"
                                    >Update Profile Image</label
                                >
                                <input
                                    type="file"
                                    @change="
                                        (e) => {
                                            onChangeImage(e, 'user-image');
                                        }
                                    "
                                    class="form-control"
                                    accept="image/*"
                                />
                                <p
                                    class="mt-2 text-muted"
                                    v-if="profileImagePreview"
                                >
                                    Preview:
                                </p>
                                <img
                                    v-if="profileImagePreview"
                                    :src="profileImagePreview"
                                    alt="Profile Image Preview"
                                    class="image-preview"
                                />
                            </div>

                            <div class="text-left">
                                <label class="required">User Name</label>
                                <input
                                    type="text"
                                    v-model="update_user_info.user_name"
                                    class="form-control"
                                />
                            </div>
                            <div class="text-left">
                                <label class="required">User Role</label>
                                <select
                                    v-model="update_user_info.user_role"
                                    class="form-control"
                                >
                                    <option
                                        v-for="(role, index) in roles"
                                        :key="index"
                                        :value="role.id"
                                    >
                                        {{ role.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="text-left mt-3">
                                <!-- Email -->
                                <label class="required">Email</label>
                                <input
                                    type="email"
                                    v-model="update_user_info.user_email"
                                    class="form-control"
                                />
                            </div>
                            <hr />
                            <strong>
                                <i class="fa-solid fa-circle-info mr-1"></i>
                                Company Info</strong
                            >
                            <div class="company-info">
                                <div class="text-left mt-3">
                                    <label class="required">Name</label>
                                    <input
                                        type="text"
                                        v-model="update_user_info.company.name"
                                        class="form-control"
                                    />
                                </div>

                                <!-- Company Logo -->
                                <div class="text-left">
                                    <!-- Company Logo -->
                                    <label class="optional">Logo</label>
                                    <input
                                        type="file"
                                        @change="
                                            (e) => {
                                                onChangeImage(
                                                    e,
                                                    'company-logo'
                                                );
                                            }
                                        "
                                        class="form-control"
                                        accept="image/*"
                                    />
                                    <p
                                        class="mt-2 text-muted"
                                        v-if="logoPreview"
                                    >
                                        Preview:
                                    </p>
                                    <img
                                        v-if="logoPreview"
                                        :src="logoPreview"
                                        alt="Company Logo Preview"
                                        class="image-preview"
                                    />
                                </div>

                                <!-- Company Email -->
                                <div class="text-left mt-3">
                                    <label class="optional">Email</label>
                                    <input
                                        type="email"
                                        v-model="update_user_info.company.email"
                                        class="form-control"
                                    />
                                </div>

                                <!-- Company Address -->
                                <div class="text-left mt-3">
                                    <label class="optional">Address</label>
                                    <input
                                        type="text"
                                        v-model="
                                            update_user_info.company.address
                                        "
                                        class="form-control"
                                    />
                                </div>

                                <!-- Company Phone -->
                                <div class="text-left mt-3">
                                    <label class="optional">phone</label>
                                    <input
                                        type="text"
                                        v-model="update_user_info.company.phone"
                                        class="form-control"
                                    />
                                </div>
                                <div class="text-left mt-3">
                                    <label class="optional"
                                        >Other Information</label
                                    >
                                    <textarea
                                        v-model="
                                            update_user_info.company.other_info
                                        "
                                        class="form-control"
                                        rows="3"
                                    ></textarea>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-navy btn-sm mt-5 mx-1"
                                        type="button"
                                        @click="handleEditProfileBtn('check')"
                                        v-if="isActiveEdit"
                                    >
                                        Submit <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button
                                        class="btn btn-danger btn-sm mt-5 mx-1"
                                        type="button"
                                        @click="handleEditProfileBtn('cancel')"
                                        v-if="isActiveEdit"
                                    >
                                        Cancel <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import { onMounted, ref } from "vue";
export default {
    setup() {
        var user = ref({
            name: "",
            email: "",
            roles: "",
            image_url: "",
            company: "",
        });
        var BGCard = ref("card-navy");
        var isActiveEdit = ref(false);
        var logoPreview = ref();
        var profileImagePreview = ref();
        var update_user_info = ref({
            user_name: "",
            user_role: "",
            user_email: "",
            user_image: "",
            company: "",
        });
        var roles = ref();

        const fetchAuthData = () => {
            axios.get("/user/fetch-auth").then((response) => {
                const data = response.data.data;
                user.value.name = data.name;
                user.value.email = data.email;
                user.value.image_url = data.image;
                user.value.roles = data.roles && data.roles[0].name;
                update_user_info.value.user_role =
                    data.roles && data.roles[0].id;
                user.value.company = data.company;
                update_user_info.value.company = data.company;
                update_user_info.value.user_name = data.name;
                update_user_info.value.user_email = data.email;
            });
        };

        const handleEditProfileBtn = (type) => {
            console.clear();
            isActiveEdit.value = !isActiveEdit.value;
            if (type == "edit") {
                BGCard.value = "card-success";
                fetchRoles();
            } else {
                BGCard.value = "card-navy";
                axios.put('/user/profile', update_user_info.value)
                    .then((response) => {
                        window.handleResponseRequest(response);
                    });
            }
        };

        const fetchRoles = () => {
            axios.get("/user/fetch-roles").then((response) => {
                roles.value = response.data.data;
            });
        };

        const onChangeImage = (event, type) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (type == "company-logo") {
                        logoPreview.value = e.target.result; // Set the preview URL
                        update_user_info.value.company.logo = e.target.result;
                    } else {
                        profileImagePreview.value = e.target.result;
                        update_user_info.value.user_image = e.target.result;
                    }
                };
                reader.readAsDataURL(file); // Convert file to base64
            }
        };

        onMounted(() => {
            fetchAuthData();
        });
        return {
            user,
            handleEditProfileBtn,
            BGCard,
            isActiveEdit,
            onChangeImage,
            logoPreview,
            profileImagePreview,
            update_user_info,
            roles,
        };
    },
};
</script>

<style></style>
