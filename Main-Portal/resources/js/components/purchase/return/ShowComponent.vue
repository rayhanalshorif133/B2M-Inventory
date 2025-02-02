<template>
    <div
        class="modal fade"
        id="showReturnPurchaseDetails"
        tabindex="-1"
        aria-labelledby="showReturnPurchaseDetailsLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px">
                    <h5 class="modal-title" id="showReturnPurchaseDetailsLabel">
                        Purchase Details
                        <a
                            class="btn btn-sm btn-outline-primary"
                            :href="purchaseReturnEditLink"
                        >
                            <i class="fa-solid fa-pen" aria-hidden="true"></i> Edit
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
                            <b>Purchase Info: </b>
                        </h5>
                        <p class="col-md-4 col-sm-2">
                            <b>Code:</b> {{ fetchShowData.purchaseReturn.code }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Invoice Date:</b>
                            {{ fetchShowData.purchaseReturn.invoice_date }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Total Amount:</b>
                            {{ fetchShowData.purchaseReturn.total_amount }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Return Amount:</b>
                            {{ fetchShowData.purchaseReturn.return_amount }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Due Amount:</b>
                            {{ fetchShowData.purchaseReturn.due_amount }}
                        </p>
                        <p class="col-md-4 col-sm-2">
                            <b>Note:</b>
                            {{ fetchShowData.purchaseReturn.note }}
                        </p>
                        <hr />
                        <h5><b>Purchase Details:</b></h5>
                        <table class="table px-2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Particulars</th>
                                    <th scope="col" style="width: 7rem">Qty</th>
                                    <th scope="col" style="width: 7rem">
                                        Purchases
                                    </th>
                                    <th scope="col" style="width: 7rem">
                                        Discount
                                    </th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <show-details-item
                                    v-for="(
                                        item, index
                                    ) in fetchShowData.purchaseReturnDetails"
                                    :key="index"
                                    :item="item"
                                    :index="index"
                                    :fetchShowData="fetchShowData"
                                >
                                </show-details-item>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end">
                                        <b>Total :</b>
                                    </td>
                                    <td colspan="2" class="text-start">
                                        {{
                                            fetchShowData.purchaseReturn.total_amount
                                        }}
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
import ShowDetailsItem from "./ShowDetailsItem.vue";

export default {
    components: {
        ShowDetailsItem,
    },
    props: {
        closeModal: {
            type: Function,
            requeue: true,
        },
        purchaseReturnEditLink: {
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
