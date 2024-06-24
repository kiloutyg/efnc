document.addEventListener('turbo:load', function () {
    var severityWeight = document.querySelector('[name="form_creation[riskWeighting][severityWeight]"]');
    var frequencyWeight = document.querySelector('[name="form_creation[riskWeighting][frequencyWeight]"]');
    var detectabilityWeight = document.querySelector('[name="form_creation[riskWeighting][detectabilityWeight]"]');
    var riskPriorityIndexField = document.querySelector('[name="form_creation[riskWeighting][RiskPriorityIndex]"]');
    var riskPriorityExplanation = document.querySelector('.risk-priority-explanation');
    if (riskPriorityIndexField !== null) {
        function calculateAndDisplayRiskPriority() {
            var severityValue = parseInt(severityWeight.value);
            var frequencyValue = parseInt(frequencyWeight.value);
            var detectabilityValue = parseInt(detectabilityWeight.value);

            var riskPriorityIndex = severityValue * frequencyValue * detectabilityValue;
            riskPriorityIndexField.value = riskPriorityIndex;

            // Clear previous alert classes
            riskPriorityExplanation.className = 'risk-priority-explanation alert';

            // Determine the color based on the risk priority index value
            if (riskPriorityIndex > 300) {
                riskPriorityIndexField.style.backgroundColor = '#ffcccb'; // Red-ish
                riskPriorityExplanation.classList.add('alert-danger');
                riskPriorityExplanation.textContent = 'Réaliser une analyse 8D ou PSA3';
            } else if (riskPriorityIndex > 100) {
                riskPriorityIndexField.style.backgroundColor = '#ffeda6'; // Orange-ish
                riskPriorityExplanation.classList.add('alert-warning');
                riskPriorityExplanation.textContent = 'Réaliser une analyse de causes potentielles et les actions de suivis dans le PDCA de l\'UAP concerné';
            } else {
                riskPriorityIndexField.style.backgroundColor = '#c8f7c5'; // Green-ish
                riskPriorityExplanation.classList.add('alert-success');
                riskPriorityExplanation.innerHTML = 'Faire communication par mail au TOP 5 (informer les manager) + Présentation piéces et affichage au poste : Alerte d\'un Problème.<br><strong>➥ Cloture manuelle aprés un mois si pas de récurrence, si récurrence conserver la nouvelle FNC et cloturer la premiére occurrence.</strong>';
            }
        }

        severityWeight.addEventListener('change', calculateAndDisplayRiskPriority);
        frequencyWeight.addEventListener('change', calculateAndDisplayRiskPriority);
        detectabilityWeight.addEventListener('change', calculateAndDisplayRiskPriority);

        // Initial calculation on page load
        calculateAndDisplayRiskPriority();
    }
});
