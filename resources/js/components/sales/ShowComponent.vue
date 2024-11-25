<template>
    <div
        class="modal fade"
        id="showSalesDetails"
        tabindex="-1"
        aria-labelledby="showSalesDetailsLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px">
                    <h5 class="modal-title" id="showSalesDetailsLabel">
                        Sales Details
                        <a
                            class="btn btn-sm btn-outline-primary"
                            :href="salesEditLink"
                        >
                            <i class="fa-solid fa-pen" aria-hidden="true"></i>
                            Edit
                        </a>
                    </h5>
                    <button
                        type="button"
                        class="btn-close text-white"
                        @click="closeModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div v-if="fetchShowData" class="row">
                        <h5>
                            <b>Sales Info:</b>
                        </h5>
                        <p class="col-md-4 col-sm-2">
                            <b>Code:</b> {{ fetchShowData.sales.code }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Invoice Date:</b>
                            {{ fetchShowData.sales.invoice_date }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Total Amount:</b>
                            {{ fetchShowData.sales.total_amount }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Paid Amount:</b>
                            {{ fetchShowData.sales.paid_amount }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Due Amount:</b>
                            {{ fetchShowData.sales.due_amount }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Note:</b>
                            {{ fetchShowData.sales.note }}
                        </p>
                        <hr />
                        <h5><b>Sales Details:</b></h5>
                        <table class="table px-2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Particulars</th>
                                    <th scope="col" style="width: 7rem">Qty</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col" style="width: 7rem">
                                        Discount
                                    </th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        item, index
                                    ) in fetchShowData.salesDetails"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        {{ item.product.name }}
                                        <br />
                                        {{ item.product_attribute.model }} -
                                        {{ item.product_attribute.size }} -
                                        {{ item.product_attribute.color }}
                                    </td>
                                    <td>
                                        {{ item.qty }}
                                    </td>
                                    <td>{{ item.sales_rate }} tk</td>
                                    <td>{{ item.discount }} tk</td>
                                    <td>{{ item.total }} tk</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end">
                                        <b>Total :</b>
                                    </td>
                                    <td colspan="2" class="text-start">
                                        {{ fetchShowData.sales.total_amount }}
                                        tk
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary text-white"
                        @click="closeModal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        closeModal: {
            type: Function,
            requeue: true,
        },
        salesEditLink: {
            type: String,
            requeue: true,
        },
        fetchShowData: {
            type: Object,
            requeue: true,
        },
    },
};
</script>

<style></style>
