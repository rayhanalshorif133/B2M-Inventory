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
                                            placeholder="Enter category name"
                                            v-model="category_name"
                                        />
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium">
                                    <span class="mr-5"
                                        >Subcategory Information</span
                                    >
                                    <button
                                        type="button"
                                        class="btn btn-navy btn-sm"
                                        @click="plusBtn"
                                    >
                                        <i class="fa-solid fa-plus"></i> Add New
                                    </button>
                                </h3>
                            </div>

                            <span
                                v-for="(item, index) in subCategories"
                                :key="index"
                            >
                                <div class="row" v-if="item.isVisible">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="name" class="required"
                                                >Sub Category Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter your name"
                                                @focusout="(e) => {item.name = e.target.value}"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div style="margin-top: 34px">
                                            <button
                                                class="btn btn-sm btn-danger"
                                                type="button"
                                                @click="() => {item.isVisible = false}"
                                            >
                                                <i
                                                    class="fa-solid fa-minus"
                                                ></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
import { ref } from "vue";
export default {
    setup() {
        var category_name = ref();
        var subCategories = ref([]);
        const plusBtn = () => {
            const data = {
                name: "",
                isVisible: true,
            };
            subCategories.value.push(data);
        };

        const submitBtn = () => {
            console.clear();

            const getSubCategories = subCategories.value.filter(item => item.isVisible);
            const data = {
                category_name: category_name.value,
                sub_categories: getSubCategories,
            };


            axios.post("/category/create", data).then((response) => {
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
        };


        return {
            category_name,
            plusBtn,
            submitBtn,
            subCategories,
        };
    },
};
</script>

<style></style>
