document.addEventListener('turbo:load', function () {
    var severityWeight = document.querySelector('[name="risk_weighting[severityWeight]"]');
    var frequencyWeight = document.querySelector('[name="risk_weighting[frequencyWeight]"]');
    var detectabilityWeight = document.querySelector('[name="risk_weighting[detectabilityWeight]"]');
    var riskPriorityIndexField = document.querySelector('.risk-priority-index');

    function calculateAndDisplayRiskPriority() {
        var severityValue = parseInt(severityWeight.value);
        var frequencyValue = parseInt(frequencyWeight.value);
        var detectabilityValue = parseInt(detectabilityWeight.value);

        var riskPriorityIndex = severityValue * frequencyValue * detectabilityValue;
        riskPriorityIndexField.value = riskPriorityIndex;

        // Determine the color based on the risk priority index value
        if (riskPriorityIndex > 100) {
            riskPriorityIndexField.style.backgroundColor = '#ffcccb'; // Red-ish
        } else if (riskPriorityIndex > 50) {
            riskPriorityIndexField.style.backgroundColor = '#ffeda6'; // Orange-ish
        } else {
            riskPriorityIndexField.style.backgroundColor = '#c8f7c5'; // Green-ish
        }
    }

    severityWeight.addEventListener('change', calculateAndDisplayRiskPriority);
    frequencyWeight.addEventListener('change', calculateAndDisplayRiskPriority);
    detectabilityWeight.addEventListener('change', calculateAndDisplayRiskPriority);

    // Initial calculation on page load
    calculateAndDisplayRiskPriority();
});
