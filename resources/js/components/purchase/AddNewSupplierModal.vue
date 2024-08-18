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
                                    class="form-control"
                                    placeholder="Enter your contact"
                                    v-model="contact"
                                />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    class="form-control"
                                    placeholder="Enter your email address"
                                    v-model="email"
                                />
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
var contact = ref("");
var email = ref("");
var address = ref("");
var others_info = ref("");

// Call the method
onMounted(() => {
    props.fetchSuppliers();
});

const handleSubmit = () => {
    const data = {
        name: name.value,
        contact: contact.value,
        email: email.value,
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
        contact.value = "";
        email.value = "";
        address.value = "";
        others_info.value = "";
    });
};
</script>

<style></style>
