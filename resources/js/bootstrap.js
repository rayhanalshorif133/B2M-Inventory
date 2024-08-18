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




window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Set up Axios to include the CSRF token in the headers for all requests
axios.defaults.headers.common['X-CSRF-Token'] = csrfToken;


