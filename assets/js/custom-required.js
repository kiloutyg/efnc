document.addEventListener('turbo:load', function () {
    const form = document.getElementById('formCreationForm');

    form.addEventListener('submit', function (event) {
        var requiredElements = form.querySelectorAll('[required]');
        var isFormValid = true;

        requiredElements.forEach(function (input) {
            if (!input.value.trim()) {
                event.preventDefault();

                if (isFormValid) {
                    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    input.focus();
                    alert('Ce champ est obligatoire.');
                    isFormValid = false;
                }
            }
        });
    });
});