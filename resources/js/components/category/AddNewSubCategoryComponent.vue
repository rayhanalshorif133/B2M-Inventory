<template>
    <div :class="rowClass">
        <div class="col-md-11">
            <div class="form-group">
                <label for="name" class="required">Sub Category Name</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Enter your name"
                    :id="count"
                    @focusout="subCategoryName"
                />
            </div>
        </div>
        <div class="col-md-1">
            <div style="margin-top: 34px">
                <button
                    class="btn btn-sm btn-danger"
                    type="button"
                    id="removeBtn"
                    @click="removebtn()"
                >
                    <i class="fa-solid fa-minus"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
export default {
    name: "AddNewSubCategoryComponent",
    data() {
        return {
            rowClass: "row",
        };
    },
    props: {
        count: {
            type: Number,
            required: true,
        },
        subCategoryName: {
            type: Function,
            required: true,
        },
    },
    methods: {
        removebtn() {
            this.rowClass = "row d-none";
        },
    },
};
</script>
