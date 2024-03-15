import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ['archivingCommentary', 'archivingCommentaryMessage', 'archivingButton'];

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
}