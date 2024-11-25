<template>
    <div>
        <!-- Create Modal -->
        <div
            class="modal fade"
            id="addExpCategory"
            tabindex="-1"
            aria-labelledby="addExpCategoryLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpCategoryLabel">
                            Add new Expencse Category
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code" class="required">Name</label
                            ><input
                                class="form-control"
                                v-model="name"
                                placeholder="Enter Category Name"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="handleSubmit('create')"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Modal -->

        <div
            class="modal fade"
            id="updateExpCategory"
            tabindex="-1"
            aria-labelledby="updateExpCategoryLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateExpCategoryLabel">
                            Update Expencse Category
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code" class="required">Name</label
                            ><input
                                class="form-control"
                                :value="update_name"
                                @input="
                                    (e) => {
                                        handleUpdate(e, id);
                                    }
                                "
                                placeholder="Enter Category Name"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="closeModal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="handleSubmit('update')"
                            :isDisabled="isDisabled"
                        >
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, toRefs } from "vue";
export default {
    props: {
        update_name: {
            type: String,
            required: false,
        },
        id: {
            type: String,
            required: false,
        },
        closeModal: {
            type: Function,
            required: false,
        },
    },
    setup(props) {
        var name = ref();
        var updateName = ref("");
        var updateId = ref("");
        var isDisabled = ref(true);

        const handleSubmit = (type) => {
            if (type == "create") {
                axios
                    .post("/expense-income/category/create", {
                        name: name.value,
                    })
                    .then((response) => {
                        handleRequest(response);
                    });
            } else {
                if (updateId.value == "") {
                    return false;
                }

                axios
                    .put("/expense-income/category/update", {
                        name: updateName.value,
                        id: updateId.value,
                    })
                    .then((res) => {
                        handleRequest(res);
                    });
            }
        };

        const handleUpdate = (e, id) => {
            updateName.value = e.target.value;
            updateId.value = id;
        };

        const handleRequest = (response) => {
            const data = response.data.data;
            const message = response.data.message;
            Toastr.fire({
                icon: message,
                title: data,
            });

            if (message == "success") {
                setTimeout(() => {
                    window.location.reload();
                }, 1600);
            }
        };
        return { name, handleSubmit,isDisabled, updateName, handleUpdate };
    },
};
</script>

<style></style>
