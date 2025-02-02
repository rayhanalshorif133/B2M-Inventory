$(() => {
    const BASE_URL = window.location.href;
    const urlParams = new URLSearchParams(new URL(BASE_URL).search);
    const paymentStatus = urlParams.get('payment');
    const campaignId = urlParams.get('campaign_id');
    if (paymentStatus && campaignId) {
        handlePaymentCallback(paymentStatus, campaignId);
    }
});



const handlePaymentCallback = (status, campaignId) => {
    console.log(status, campaignId);
    // Get the modal element by its ID
    const paymentDetailsModal = document.getElementById('paymentDetailsModal');
    const modalInstance = new bootstrap.Modal(paymentDetailsModal);

    axios.get(`/campaign/${campaignId}/fetch`)
        .then(function (response) {
            const data = response.data.data;
            const token = data.user?.phone;
            console.log(data);
            $(".paymentDetailsModalInfo h3").text(data.name);
            $(".paymentDetailsModalInfo p").text(data.game.title);

            const URL = `${data.game.url}/?token=${token}&keyword=${data.game.keyword}&campaign_id=${campaignId}`

            $("#paymentGameDetailsSetURL").attr("href", URL);

            if (status == 'success') {
                $("#paymentDetailsModal .payment_status").text('Payment Successful!');
                $("#paymentDetailsModal .payment_status").addClass('text-success');
                $("#paymentDetailsModal .modal-header").addClass('bg-success');
                $("#paymentDetailsModal .icon-container").addClass('success');
                $("#paymentDetailsModal .icon-container i").addClass('fa-check').removeClass('fa-xmark');
                const HTMLBtn = `
                    <a href="${URL}" class="btn btn-navy mb-2" id="bKash_button">
                            <i class="fas fa-play"></i> Play Now!
                    </a>
                `;
                $(".paymentPlayButton").html(HTMLBtn);
                $(".paymentGuestButton").remove();
            } else {
                $("#paymentDetailsModal .payment_status").text('Payment Failed!');
                $("#paymentDetailsModal .payment_status").addClass('text-danger');
                $("#paymentDetailsModal .modal-header").addClass('bg-danger');
                $("#paymentDetailsModal .icon-container").addClass('error');
                $("#paymentDetailsModal .icon-container i").removeClass('fa-check').addClass('fa-xmark');
                $("#payment_gameDetailsTk").text(`${data.amount} tk`);
            }

            modalInstance.show();

        })



};
