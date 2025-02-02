<template>
    <div
        class="modal fade"
        id="addNewSupplierModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNewSupplierModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="addNewSupplierModalLabel">
                        Add New Supplier
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name" class="required">Name</label>
                                <input
                                    type="text"
                                    id="name"
                                    class="form-control"
                                    placeholder="Enter your name"
                                    value=""
                                    v-model="name"
                                />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contact" class="required"
                                    >Contact</label
                                >
                                <input
                                    type="text"
                                    id="contact"
                                    @input="contact.handler"
                                    class="form-control"
                                    placeholder="Enter your contact"
                                    v-model="contact.input"
                                    :class="contact.className"
                                />
                                <small
                                    class="text-danger fw-bolder"
                                    v-if="contact.status"
                                    >Invalid Number</small
                                >
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    class="form-control"
                                    @input="email.handler"
                                    :class="email.className"
                                    placeholder="Enter your email address"
                                    v-model="email.input"
                                />
                                <small
                                    class="text-danger fw-bolder"
                                    v-if="email.status"
                                    >Invalid Email</small
                                >
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input
                                    type="text"
                                    id="address"
                                    class="form-control"
                                    placeholder="Enter your address"
                                    v-model="address"
                                />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="others_info">Others Info</label>
                                <textarea
                                    type="text"
                                    id="others_info"
                                    class="form-control"
                                    placeholder="Enter your address"
                                    rows="2"
                                    v-model="others_info"
                                ></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-sm btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        @click="handleSubmit"
                        type="button"
                        class="btn btn-sm btn-primary"
                        data-dismiss="modal"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
const props = defineProps({
    fetchSuppliers: {
        type: Function,
    },
});

var name = ref("");
var email = ref({
    handler: function () {
        const isValidEmail = window.checkEmail(email.value.input);
        if (isValidEmail == false) {
            email.value.status = true;
            email.value.className = "form-control-red";
        } else {
            email.value.status = false;
            email.value.className = "";
        }
    },
    status: false,
    className: "",
    input: "",
});
var address = ref("");
var others_info = ref("");

var contact = ref({
    handler: function () {
        const isValidNumber = window.checkBDPhoneNumber(contact.value.input);
        if (isValidNumber == false) {
            contact.value.status = true;
            contact.value.className = "form-control-red";
        } else {
            contact.value.status = false;
            contact.value.className = "";
        }
    },
    status: false,
    className: "",
    input: "",
});

// Call the method
onMounted(() => {
    props.fetchSuppliers();
});

const handleSubmit = () => {
    const data = {
        name: name.value,
        contact: contact.value.input,
        email: email.value.input,
        address: address.value,
        others_info: others_info.value,
    };

    axios.post("/supplier/create", data).then((response) => {
        const data = response.data.data;
        const message = response.data.message;
        Toastr.fire({
            icon: message,
            title: data,
        });
        props.fetchSuppliers();
        name.value = "";
        contact.value.input = "";
        email.value.input = "";
        address.value = "";
        others_info.value = "";
    });
};
</script>

<style></style>
