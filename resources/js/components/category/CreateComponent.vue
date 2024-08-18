<template>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create a new Category</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <h3 class="text-lg font-medium">
                                    Category Information
                                </h3>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="required"
                                            >Name</label
                                        >
                                        <input
                                            type="text"
                                            id="name"
                                            class="form-control"
                                            placeholder="Enter your name"
                                            v-model="category_name"
                                        />
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium">
                                    Subcategory Information
                                </h3>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="name" class="required"
                                            >Sub Category Name</label
                                        >
                                        <input
                                            type="text"
                                            id="name"
                                            class="form-control"
                                            placeholder="Enter your name"
                                            v-model="subCatname"
                                            @focusout="insertsubCatName"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div style="margin-top: 34px">
                                        <button
                                            class="btn btn-sm btn-primary"
                                            type="button"
                                            @click="plusBtn"
                                        >
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <span
                                v-for="(item, index) in subCategories"
                                :key="index"
                            >
                                <AddNewSubCategoryComponent
                                    :subCategoryName="subCategoryName"
                                    :count="passCounter(index)"
                                />
                            </span>
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
        </div>
    </section>
</template>

<script>
import { ref, defineComponent } from "vue";
import AddNewSubCategoryComponent from "./AddNewSubCategoryComponent.vue";

export default defineComponent({
    components: {
        AddNewSubCategoryComponent,
    },
    data() {
        return {
            category_name: "",
            subCatname: "",
            image: null,
            subCategories: ref(0),
            input: ref(""),
            sub_category_bucket: [],
        };
    },
    methods: {
        plusBtn() {
            this.subCategories++;
        },
        submitBtn() {
            axios
                .post("/category/create", {
                    category_name: this.category_name,
                    sub_category: this.sub_category_bucket,
                })
                .then((response) => {
                    const data = response.data.data;
                    const message = response.data.message;
                    Toastr.fire({
                        icon: message,
                        title: data,
                    });

                    if (message == "success") {
                        setTimeout(() => {
                            window.location.href = "/category/list";
                        }, 1600);
                    }
                });
        },
        subCategoryName(e) {
            const subName = e.target.value;
            this.sub_category_bucket.push(subName);
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

        insertsubCatName() {
            this.sub_category_bucket.push(this.subCatname);
        },

        passCounter(index) {
            return "subCategory_id-" + index;
        },
    },
});
</script>

<style></style>
