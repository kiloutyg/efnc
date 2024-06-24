document.addEventListener('turbo:load', function () {
  // Define the "form" element and indicator
  var form = null;
  var indic = '';
  if (document.getElementById('formCreationForm')) {
    form = document.getElementById('formCreationForm');
    indic = 'creation';
  } else if (document.getElementById('formModificationForm')) {
    form = document.getElementById('formModificationForm');
    indic = 'modification';
  }
  console.log(indic);

  const checkFormValidity = (form) => {
    var requiredElements = form.querySelectorAll('[required]');
    var isFormValid = true;

    // Clear previous errors
    const errorMessages = form.querySelectorAll('.error-message');
    errorMessages.forEach((msg) => {
      msg.remove();
    });

    for (let i = 0; i < requiredElements.length; i++) {
      const input = requiredElements[i];
      if (!input.value.trim()) {
        const errorMessage = document.createElement('span');
        errorMessage.textContent = 'Ce champ est obligatoire.';
        errorMessage.classList.add('error-message');
        // Style the error message, for example:
        errorMessage.style.color = 'red';

        // Insert the error message in the DOM
        input.parentNode.insertBefore(errorMessage, input.nextSibling);

        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        input.focus();

        isFormValid = false;
        console.log('hello from the checkFormValidity function = false');
        break; // Exit the loop on the first invalid input
      }
    }

    console.log('isFormValid = ' + isFormValid);
    return isFormValid;
  };


  if (form !== null) {
    console.log('hello from the test (form !== null) = true ');

    // Attach the submit handler if the "form" element exists
    form.addEventListener('submit', function (event) {
      if (!checkFormValidity(form)) {
        event.preventDefault(); // Prevent form submission if form is invalid
      }
    });
  }

  // Validation before confirmation
  const attachClickHandlerWithValidation = (button, message) => {
    console.log('hello from the attachClickHandlerWithValidation function');
    button.addEventListener('click', (event) => {
      if (!checkFormValidity(form)) { // If form is invalid
        event.preventDefault(); // Prevent the action
        return; // Exit the function early
      }
      const confirmed = confirm(message);
      if (!confirmed) {
        event.preventDefault();
      }
    });
  };

  // // Your button selectors and confirmation messages
  const creationEFNCformButtons = document.querySelectorAll(".submit-EFNCform-creation");
  creationEFNCformButtons.forEach((button) => {
    attachClickHandlerWithValidation(
      button,
      "Êtes vous sûr de vouloir ajouter cette Fiche de Non Conformité ?"
    );
  });

  const modificationEFNCformButtons = document.querySelectorAll(".submit-EFNCform-modification");

  modificationEFNCformButtons.forEach((button) => {
    attachClickHandlerWithValidation(
      button,
      "Êtes vous sûr de vouloir modifier cette Fiche de Non Conformité ?"
    );
  });


  const archiveEntityButtons = document.querySelectorAll(".archive-entity");
  const restoreArchivedEntityButtons = document.querySelectorAll(".restore-entity");
  const creationUserButtons = document.querySelectorAll(".submit-user-creation");
  const deleteUserButtons = document.querySelectorAll(".delete-user");
  const archiveEFNCButtons = document.querySelectorAll(".archive-EFNC");
  const closeEFNCButtons = document.querySelectorAll(".close-EFNC");

  const entityCreationButtons = document.querySelectorAll(".submit-entity-creation");

  const ncfCreationButtons = document.querySelectorAll(".new-ncf-alert");

  const confirmationHandler = (event, message) => {
    const confirmed = confirm(message);
    if (!confirmed) {
      event.preventDefault();
    }
  };

  archiveEntityButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir archiver cette Entitée?"
      );
    });
  });

  restoreArchivedEntityButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir restorer cette entitée?"
      );
    });
  });


  creationUserButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir créer cet Utilisateur?"
      );
    });
  });

  deleteUserButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer cet Utilisateur?"
      );
    });
  });


  archiveEFNCButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir archiver cette EFNC?"
      );
    });
  });

  closeEFNCButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir clore cette EFNC?"
      );
    });
  });

  entityCreationButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir créer cette entitée?"
      );
    });
  });

  ncfCreationButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        " ⚠️ Une FNC ne doit être crée que si le défaut represente ❗ UN NOMBRE DE PIECES SUPERIEUR OU EGAL A 5  ❗  Êtes vous sûr de vouloir continuer ? "

      );
    });
  });

});
