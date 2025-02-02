
// Import any other script files here, e.g.:
// import * as myModule from "./mymodule.js";

runOnStartup(async runtime => {

    const crypto = document.createElement('script');
    crypto.src = "https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js";

    crypto.onload = () => {
        console.log("CryptoJS loaded:", CryptoJS);
        // You can now use axios or any library loaded here
    };

    document.head.appendChild(crypto);


    const axiosScr = document.createElement('script');
    axiosScr.src = "https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js";  // Example: Loading Axios CDN
    axiosScr.onload = () => {
        console.log("Axios library loaded successfully!", axios);
        // You can now use axios or any library loaded here
    };

    document.head.appendChild(axiosScr);


    let currentUrl = new URL(window.location.href);

    let macAddress = currentUrl.searchParams.get('mac');
    let token = currentUrl.searchParams.get('token');
    let keyword = currentUrl.searchParams.get('keyword');
    let campaignId = currentUrl.searchParams.get('campaign_id');

    // Store values in sessionStorage
    if (campaignId) {
        sessionStorage.setItem('campaign_id', campaignId);
        currentUrl.searchParams.delete('campaign_id');
    }
    
    if (macAddress) {
        sessionStorage.setItem('mac', macAddress);
        currentUrl.searchParams.delete('mac');
    }

    if (token) {
        sessionStorage.setItem('token', token);
        currentUrl.searchParams.delete('token');
    }

    if (keyword) {
        sessionStorage.setItem('keyword', keyword);
        currentUrl.searchParams.delete('keyword');
    }

    // Remove the parameters from the URL and update it
    let newUrl = currentUrl.toString();
    window.history.replaceState(null, '', newUrl);


});

async function OnBeforeProjectStart(runtime) {
    // Code to run just before 'On start of layout' on
    // the first layout. Loading has finished and initial
    // instances are created and available to use here.

    runtime.addEventListener("tick", () => Tick(runtime));
}

function Tick(runtime) {

}
