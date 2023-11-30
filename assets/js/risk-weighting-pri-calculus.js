document.addEventListener('turbo:load', function () {
    var severityWeight = document.querySelector('[name="risk_weighting[severityWeight]"]');
    var frequencyWeight = document.querySelector('[name="risk_weighting[frequencyWeight]"]');
    var detectabilityWeight = document.querySelector('[name="risk_weighting[detectabilityWeight]"]');
    var riskPriorityIndexField = document.querySelector('[name="risk_weighting[RiskPriorityIndex]"]');
    var riskPriorityExplanation = document.querySelector('.risk-priority-explanation');

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
            riskPriorityExplanation.textContent = 'Réaliser une analyse 8D';
        } else if (riskPriorityIndex > 100) {
            riskPriorityIndexField.style.backgroundColor = '#ffeda6'; // Orange-ish
            riskPriorityExplanation.classList.add('alert-warning');
            riskPriorityExplanation.textContent = 'Réaliser une analyse de causes potentielles';
        } else {
            riskPriorityIndexField.style.backgroundColor = '#c8f7c5'; // Green-ish
            riskPriorityExplanation.classList.add('alert-success');
            riskPriorityExplanation.textContent = 'Pas d\'analyse, affichage au poste : Alerte d\'un Problème';
        }
    }

    severityWeight.addEventListener('change', calculateAndDisplayRiskPriority);
    frequencyWeight.addEventListener('change', calculateAndDisplayRiskPriority);
    detectabilityWeight.addEventListener('change', calculateAndDisplayRiskPriority);

    // Initial calculation on page load
    calculateAndDisplayRiskPriority();
});
