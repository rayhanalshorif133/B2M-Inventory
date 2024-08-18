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
                        <div class="pl-3 pt-1">{{ category_item.name }}</div>
                        <div class="btn-group mx-2">
                            <span class="btn btn-info btn-sm">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </span>
                            <span class="btn btn-danger btn-sm">
                                Delete <i class="fa-solid fa-trash"></i>
                            </span>
                        </div>
                    </span>
                </div>

                <div
                    v-for="(item, index) in SET_SUB_CATEGORIES(
                        category_item.id
                    )"
                    :key="index"
                >
                    <i class="fas fa-tag bg-navy"></i>
                    <div class="timeline-item">
                        <span class="time"
                            ><i class="fas fa-clock"></i> 12:05</span
                        >
                        <h3 class="timeline-header text-navy">
                            {{ item.name }}
                        </h3>
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
                            :id="'id___' + category_item.id"
                            class="mx-5 col-8 d-flex"
                            :class="{ 'd-none': !isVisible(category_item.id) }"
                        >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Enter new Sub Category Name"
                            />
                            <button
                                type="button"
                                class="btn btn-sm btn-success ml-2"
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
import { ref } from "vue";

export default {
    name: "Timeline",
    props: {
        category_list: {
            type: Array,
            required: true,
        },
        sub_category_list: {
            type: Array,
            required: true,
        },
    },
    setup() {
        var categories = [];
        var sub_category_list = [];
        axios.get("/category/fetch").then(function (response) {
            const data = response.data.data;
            if (data.length > 0) {
                data.forEach((item) => {
                    if (item.parent_category_id == null) {
                        categories.push(item);
                    } else {
                        sub_category_list.push(item);
                    }
                });
            }
            window.sessionStorage.setItem(
                "categories",
                JSON.stringify(categories)
            );
            window.sessionStorage.setItem(
                "sub_categories",
                JSON.stringify(sub_category_list)
            );
        });
        const GET_CATEGORIES = JSON.parse(
            window.sessionStorage.getItem("categories")
        );

        const GET_SUB_CATEGORIES = JSON.parse(
            window.sessionStorage.getItem("sub_categories")
        );

        // Reactive state for visible items
        const visibleItems = ref({});

        // Toggle accordion visibility
        const toggleAccordion = (id) => {
            visibleItems.value[id] = !visibleItems.value[id];
        };

        // Check if item is visible
        const isVisible = (id) => {
            return visibleItems.value[id] || false;
        };

        const SET_SUB_CATEGORIES = (parent_id) => {
            // const parent_base_sub = GET_CATEGORIES.filter(
            //     (category) => {
            //         return category.parent_category_id == parent_id;
            //     }
            // );
            console.log(GET_CATEGORIES)
            console.log(parent_id)
            return GET_CATEGORIES;
        };

        return {
            category_list: GET_CATEGORIES, // Use default category list
            toggleAccordion,
            isVisible,
            SET_SUB_CATEGORIES,
        };
    },
};
</script>

<style scoped>
.d-none {
    display: none;
}
</style>
