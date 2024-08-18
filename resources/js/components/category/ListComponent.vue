<template>
    <div class="row px-5">
        <div class="col-md-12">
            <div
                class="timeline"
                v-for="(category_item, index) in category_list"
                :key="index"
            >
                <div class="time-label">
                    <span class="bg-navy w-100 d-flex justify-content-between">
                        <div class="pl-3 d-flex-centerd h-30px">
                            <span
                                :class="{
                                    'd-none': isMainBtnVisible(
                                        category_item.id
                                    ),
                                }"
                                >{{ category_item.name }}</span
                            >
                            <span
                                :class="{
                                    'd-none': !isMainBtnVisible(
                                        category_item.id
                                    ),
                                }"
                            >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="
                                        mainCategoryInput[category_item.id]
                                    "
                                />
                            </span>
                        </div>
                        <div class="btn-group mx-2">
                            <span
                                @click="
                                    categoryEditBtnMain(
                                        category_item.id,
                                        category_item.name
                                    )
                                "
                            >
                                <span
                                    class="btn btn-sm btn-info h-30px"
                                    :class="{
                                        'd-none': isMainBtnVisible(
                                            category_item.id
                                        ),
                                    }"
                                >
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Edit
                                </span>
                                <span
                                    class="btn btn-sm btn-purple h-30px"
                                    :class="{
                                        'd-none': !isMainBtnVisible(
                                            category_item.id
                                        ),
                                    }"
                                    ><i class="fa-solid fa-check"></i>
                                    Update</span
                                >
                            </span>
                            <span class="btn btn-danger btn-sm" @click="categoryDeleteBtn(category_item.id, 'parent')">
                                Delete <i class="fa-solid fa-trash"></i>
                            </span>
                        </div>
                    </span>
                </div>

                <div
                    v-for="(item, index) in category_item.subCategories"
                    :key="index"
                >
                    <i class="fas fa-tag bg-navy"></i>
                    <div class="timeline-item d-flex justify-content-between">
                        <h3 class="timeline-header text-navy">
                            <span
                                :class="{
                                    'd-none': isVisibleInputField(item.id),
                                }"
                            >
                                {{ item.name }}</span
                            >
                            <span
                                :class="{
                                    'd-none': !isVisibleInputField(item.id),
                                }"
                            >
                                <input
                                    type="text"
                                    v-model="editInputField[item.id]"
                                    class="form-control"
                                />
                            </span>
                        </h3>
                        <div class="btn-group mx-2 d-flex-centerd">
                            <span @click="category_editBtn(item.id, item.name)">
                                <span
                                    class="btn btn-sm btn-teal h-30px"
                                    :class="{
                                        'd-none': isBtnVisible(item.id),
                                    }"
                                >
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Edit
                                </span>
                                <span
                                    class="btn btn-sm btn-success h-30px"
                                    :class="{
                                        'd-none': !isBtnVisible(item.id),
                                    }"
                                    ><i class="fa-solid fa-check"></i>
                                    Update</span
                                >
                            </span>
                            <span
                                @click="categoryDeleteBtn(item.id, 'child')"
                                class="btn btn-brown btn-sm h-30px"
                            >
                                Delete <i class="fa-solid fa-trash"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="cursor-pointer addNewSubCategoryBtn">
                    <i class="fas fa-plus add-new-sub-btn-bg-success"></i>
                    <div class="timeline-item-add-new d-flex">
                        <h3
                            class="timeline-header col-2 text-white add-new-sub-btn-bg-success"
                            @click="toggleAccordion(category_item.id)"
                        >
                            Add New Item
                        </h3>
                        <div
                            class="mx-5 col-8 d-flex"
                            :class="{ 'd-none': !isVisible(category_item.id) }"
                        >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Enter new Sub Category Name"
                                v-model="sub_new_category[category_item.id]"
                            />
                            <button
                                type="button"
                                class="btn btn-sm btn-success ml-2"
                                @click="subNewCategorySubmit(category_item.id)"
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
    name: "Timeline",
    setup() {
        var sub_new_category = ref([]);
        var editInputField = ref([]);
        var mainCategoryInput = ref([]);

        const categories = ref([]);

        onMounted(() => {
            fetchCategory();
        });

        const fetchCategory = () => {
            axios.get("/category/fetch").then((response) => {
                categories.value = response.data.data;
            });
        };

        const visibleItems = ref({});

        const toggleAccordion = (id) => {
            visibleItems.value[id] = !visibleItems.value[id];
        };
        const isVisible = (id) => {
            return visibleItems.value[id] || false;
        };

        const subNewCategorySubmit = (category_id) => {
            axios
                .put(`/category/add-new-sub/${category_id}`, {
                    name: sub_new_category.value[category_id],
                })
                .then(function (response) {
                    const status = response.data.status;
                    if (status == true) {
                        sub_new_category.value[category_id] = "";
                        fetchCategory();
                        Toastr.fire({
                            icon: "success",
                            title: "New Subcategory added successfully",
                        });
                    }
                });
        };

        const editBtnItems = ref({});
        const btnItems = ref({});
        // category_editBtn
        const category_editBtn = (category_id, category_name) => {
            editBtnItems.value[category_id] = !editBtnItems.value[category_id];
            btnItems.value[category_id] = !btnItems.value[category_id];

            if (editBtnItems.value[category_id]) {
                editInputField.value[category_id] = category_name;
            } else {
                const GET_INPUT_VALUE = editInputField.value[category_id];
                updateCategory(category_id, GET_INPUT_VALUE);
            }
        };

        const isVisibleInputField = (category_id) => {
            return editBtnItems.value[category_id] || false;
        };

        const isBtnVisible = (category_id) => {
            return btnItems.value[category_id] || false;
        };

        const categoryDeleteBtn = (category_id, type) => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/category/delete/${category_id}?type=${type}`)
                        .then((response) => {
                            if (response.data.status == true) {
                                fetchCategory();
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success",
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Something went wrong",
                                    icon: "error",
                                });
                            }
                        });
                } else {
                    Swal.fire({
                        title: "Cancelled",
                        text: "Your file is safe :)",
                        icon: "error",
                    });
                }
            });
        };

        const editBtnItemsMain = ref({});
        const categoryEditBtnMain = (category_id, category_name) => {
            editBtnItemsMain.value[category_id] =
                !editBtnItemsMain.value[category_id];
            if (editBtnItemsMain.value[category_id]) {
                mainCategoryInput.value[category_id] = category_name;
            } else {
                const GET_INPUT_VALUE = mainCategoryInput.value[category_id];
                updateCategory(category_id, GET_INPUT_VALUE);
            }
        };

        const isMainBtnVisible = (category_id) => {
            return editBtnItemsMain.value[category_id] || false;
        };

        const updateCategory = (category_id, value) => {
            axios
                .put(`/category/update/${category_id}`, {
                    name: value,
                })
                .then((response) => {
                    fetchCategory();
                    Toastr.fire({
                        icon: "success",
                        title: "Successfully updated category",
                    });
                });
        };

        return {
            category_list: categories, // Use default category list
            toggleAccordion,
            isVisible,
            sub_new_category,
            subNewCategorySubmit,
            category_editBtn,
            isVisibleInputField,
            editInputField,
            isBtnVisible,
            categoryDeleteBtn,
            categoryEditBtnMain,
            isMainBtnVisible,
            mainCategoryInput,
        };
    },
};
</script>

<style scoped>
.d-none {
    display: none;
}
</style>
