import { Controller } from '@hotwired/stimulus';

export default class closingCommentaryController extends Controller {

    static targets = ['closingCommentary', 'closingCommentaryMessage', 'closingButton'];

    connect() {
        // Initialization code or leave empty if not needed
    }

    closingCommentary() {
        console.log("closingCommentary" + this.closingCommentaryTarget.value);
        const commentary = this.closingCommentaryTarget.value.trim();
        const isValid = commentary.length > 5;

        if (isValid) {
            this.closingCommentaryMessageTarget.textContent = "";
            this.closingButtonTarget.disabled = false;
            this.closingButtonTarget.hidden = false;
        } else {
            this.closingCommentaryMessageTarget.textContent = "Format invalide. Veuillez saisir un commentaire plus complet.";
            this.closingCommentaryMessageTarget.style.color = "red"; // Display the message in red color.
        }
    }


    closeWithCommentary(event) {

        const entityType = this.trainingOperatorCodeTarget.dataset.entityType;
        const efncid = this.trainingOperatorCodeTarget.dataset.efncid;

        // Prevent default form submission behavior
        event.preventDefault();

        // Validate commentary as per your logic; here directly using validateCommentary method
        this.validateCommentary();

        if (!this.closingButtonTarget.disabled) {
            const url = '/efnc/admin/close/'; // Replace with your actual endpoint
            const commentary = this.closingCommentaryTarget.value;

            fetch(url, {
                method: 'POST',
                body: JSON.stringify({ closingCommentary: commentary }),
                headers: {
                    'Content-Type': 'application/json',
                    // Add other headers like CSRF token if necessary
                }
            })
                .then(response => {
                    // Handle successful response
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json(); // Or `response.text()` if your server sends something other than JSON
                })
                .then(data => {
                    // Do something with the data
                    console.log(data);
                })
                .catch(error => {
                    // Handle errors here
                    console.error('Fetch error:', error);
                });
        }
    }
}