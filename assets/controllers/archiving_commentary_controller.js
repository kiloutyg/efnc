import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ['archivingCommentary', 'archivingCommentaryMessage', 'archivingButton'];

    connect() {
        // Initialization code or leave empty if not needed
    }

    archivingCommentary() {
        console.log("archivingCommentary" + this.archivingCommentaryTarget.value);
        const commentary = this.archivingCommentaryTarget.value.trim();
        const isValid = commentary.length > 5;

        if (isValid) {
            this.archivingCommentaryMessageTarget.textContent = "";
            this.archivingButtonTarget.disabled = false;
            this.archivingButtonTarget.hidden = false;
        } else {
            this.archivingCommentaryMessageTarget.textContent = "Format invalide. Veuillez saisir un commentaire plus complet.";
            this.archivingCommentaryMessageTarget.style.color = "red"; // Display the message in red color.
        }
    }


    archiveWithCommentary(event) {

        const entityType = this.trainingOperatorCodeTarget.dataset.entityType;
        const efncid = this.trainingOperatorCodeTarget.dataset.efncid;

        // Prevent default form submission behavior
        event.preventDefault();

        // Validate commentary as per your logic; here directly using validateCommentary method
        this.validateCommentary();

        if (!this.archivingButtonTarget.disabled) {
            const url = '/efnc/admin/archive/'; // Replace with your actual endpoint
            const commentary = this.archivingCommentaryTarget.value;

            fetch(url, {
                method: 'POST',
                body: JSON.stringify({ archivingCommentary: commentary }),
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