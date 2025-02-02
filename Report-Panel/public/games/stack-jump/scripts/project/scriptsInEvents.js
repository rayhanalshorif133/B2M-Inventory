


const scriptsInEvents = {

    async Game_event_Event44_Act6(runtime, localVars) {
        const encryptionKey = runtime.globalVars.mosfet.toString(); // Get key from Construct 3 global variable


        // Retrieve global variables and URL parameters
        function getParams() {
            const token = sessionStorage.getItem('token');
            const macAddress = sessionStorage.getItem('mac');
            const keyword = sessionStorage.getItem('keyword');
            const campaignId = sessionStorage.getItem('campaign_id');
            return {
                token: token || "",
                keyword: keyword || "",
                campaignId: campaignId || "",
                score: runtime.globalVars.Score.toString() || "0",
            };
        }

        // Encrypt text using AES-128-CBC with CryptoJS
        function encrypt(text) {

            const passphrase = encryptionKey; // The passphrase
            const salt = CryptoJS.lib.WordArray.random(128 / 8); // Generate random salt (16 bytes)

            // Derive key and IV from passphrase and salt using PBKDF2
            const keyIv = CryptoJS.PBKDF2(passphrase, salt, { keySize: 256 / 32 + 128 / 32, iterations: 1000 });

            // Extract the key and IV
            const key = CryptoJS.lib.WordArray.create(keyIv.words.slice(0, 8)); // First 8 words (256 bits)
            const iv = CryptoJS.lib.WordArray.create(keyIv.words.slice(8, 12)); // Next 4 words (128 bits)

            const plaintext = text;

            const encrypted = CryptoJS.AES.encrypt(plaintext, key, {
                iv: iv,
                padding: CryptoJS.pad.Pkcs7 // Ensure padding is applied
            });

            // Return the key (Base64), salt (Base64), IV (Base64), and ciphertext (Base64)
            return {
                key: key.toString(CryptoJS.enc.Base64), // Return key in Base64 format
                salt: salt.toString(CryptoJS.enc.Base64), // Return salt in Base64 format
                iv: iv.toString(CryptoJS.enc.Base64), // Return IV in Base64 format
                ciphertext: encrypted.toString() // Return ciphertext in Base64 format
            };
        }


        // Main function: Encrypt and send data
        window.onGameOver = async function () {

            const { token, keyword, score, campaignId } = getParams();


            // Redirect to fallback URL if token or keyword is missing
            if (!token || !keyword || !campaignId) {
                window.location.href = "http://bkash.bdgamers.club";
                return false;
            }


            // Encrypt the required parameters
            var encryptedTokenKeyword = encrypt(`${token}_${keyword}_${campaignId}`);
            var encryptedScore = encrypt(score);

            encryptedTokenKeyword = JSON.stringify(encryptedTokenKeyword);
            encryptedScore = JSON.stringify(encryptedScore);


            // Define the request URL
            const url = `http://bkash-sandbox.bdgamers.club/api/score?pengenal=${encryptedTokenKeyword}&puntaje=${encryptedScore}`;

            try {
                const response = await fetch(url);
                const data = await response.json();
            } catch (error) {
                console.error("Error sending data:", error);
            }

        };

        window.onGameOver();
    },

    async Menu_event_Event7_Act5(runtime, localVars) {
        // Separate function to handle fetching and redirection
        function fetchAndRedirect() {
            window.location.href = `http://bkash.bdgamers.club`;
        }

        fetchAndRedirect();
    },

    async Game_over_event_Event6_Act5(runtime, localVars) {
        // Separate function to handle fetching and redirection
        function fetchAndRedirect() {
            window.location.href = `http://bkash.bdgamers.club`;
        }

        fetchAndRedirect();
    }

};

self.C3.ScriptsInEvents = scriptsInEvents;

