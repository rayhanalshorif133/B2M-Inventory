<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li
                            v-for="(item, index) in items"
                            class="breadcrumb-item"
                            :key="index"
                        >

                            <a :href="item" v-if="index != items.length - 1" class="text-capitalize">{{ item }}</a>
                            <span class="text-gray" v-else>{{ item }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        items: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style></style>
