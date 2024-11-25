import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from 'axios';
import Swal from 'sweetalert2'
import moment from 'moment';
window.axios = axios;
window.moment = moment;
window.Swal = Swal;

const Toastr = Swal.mixin({
    toast: true,
    position: "top",
    iconColor: "white",
    customClass: {
        popup: "colored-toast",
    },
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
});

window.Toastr = Toastr;


const getId = () => {
    const currentURL = window.location.pathname;
    const id = parseInt(currentURL.match(/\d+/)[0]);
    if (id === undefined) {
        return 0;
    }
    return id;
}

window.getId = getId;


function validateBDPhoneNumber(phoneNumber) {
    // Regular expression for Bangladeshi phone number
    const bdPhoneNumberPattern = /^(?:\+8801|8801|01)[3-9]\d{8}$/;

    return bdPhoneNumberPattern.test(phoneNumber);
}

window.checkBDPhoneNumber = validateBDPhoneNumber;

function validateEmail(email) {
    // Regular expression for validating an email address
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    return emailPattern.test(email);
}

window.checkEmail = validateEmail;


const handleRequest = (response) => {
    const data = response.data.data;
    const message = response.data.message;
    Toastr.fire({
        icon: message,
        title: data,
    });

    if (message == "success") {
        setTimeout(() => {
            window.location.reload();
        }, 1600);
    }
};

window.handleRequest = handleRequest;


window.handleResponseRequest = handleRequest;


const getCurrentDate = () => {
    const currentDate = new Date();

    // Format the date as YYYY-MM-DD (you can change the format as needed)
    const formattedDate = `${currentDate.getFullYear()}-${(
        currentDate.getMonth() + 1
    )
        .toString()
        .padStart(2, "0")}-${currentDate
            .getDate()
            .toString()
            .padStart(2, "0")}`;
    return formattedDate;
}

window.getCurrentDate = getCurrentDate;






window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Set up Axios to include the CSRF token in the headers for all requests
axios.defaults.headers.common['X-CSRF-Token'] = csrfToken;


