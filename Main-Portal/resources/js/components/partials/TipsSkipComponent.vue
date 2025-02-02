<template>
    <section>
        <!-- Modal -->
        <div
            class="modal fade"
            id="tipsAndSkipModal"
            tabindex="-1"
            aria-labelledby="tipsAndSkipModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content tips_skips_container">
                    <div class="modal-header">
                        <div class="title">
                            <h6>Welcome!</h6>
                            <div>
                                <button
                                    type="button"
                                    @click="handleTour(false)"
                                >
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex">
                            <img
                                src="/images/inventory_logo.gif"
                                alt="inventory logo"
                            />
                            <h3 class="welcome_inventory">
                                Welcome to Inventory!
                            </h3>
                        </div>
                        <p>
                            Congratulations on choosing a powerful inventory
                            management software! Take a <b>guided tour</b> to
                            streamline your processes with easy,
                            <b>step-by-step instructions</b>. Optimize stock
                            management, track inventory levels, and generate
                            insightful reports quickly. Say goodbye to manual
                            tracking and embrace efficient, hassle-free
                            inventory management!
                        </p>
                        <div class="btn-container">
                            <button
                                class="btn-guided-tour"
                                @click="handleTour(true)"
                            >
                                Take a guided tour
                                <i class="fa-solid fa-caret-right"></i>
                            </button>
                            <button
                                class="btn btn-no-thanks"
                                @click="handleTour(false)"
                            >
                                No thanks, Not now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
export default {
    setup() {
        var tipsAndSkipModal = ref();
        var tipsAndTourData = ref();

        const handleTour = (type) => {
            tipsAndSkipModal.value.hide();
            if (!type) {
                const data = {};
                axios.put('/tips-tour-guide/update',data);
            }
        };

        onMounted(() => {
            axios.get("/tips-tour-guide/fetch").then((res) => {
                tipsAndTourData.value = res.data.data;
                const { is_viewed } = tipsAndTourData.value;
                const params = new URLSearchParams(window.location.search);
                const hasTourParam = params.has("tour");
                if (!is_viewed && !hasTourParam) {
                    showTourGuide();
                }
            });
        });
        const showTourGuide = () => {
            tipsAndSkipModal.value = new bootstrap.Modal(
                document.getElementById("tipsAndSkipModal")
            );
            tipsAndSkipModal.value.show();
        };

        return { handleTour };
    },
};
</script>

<style></style>
