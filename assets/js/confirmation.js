window.addEventListener("turbo:load", () => {
  const archiveEntityButtons = document.querySelectorAll(".archive-entity");
  const restoreArchivedEntityButtons = document.querySelectorAll(".restore-entity");
  const creationUserButtons = document.querySelectorAll(".submit-user-creation");
  const deleteUserButtons = document.querySelectorAll(".delete-user");
  const archiveEFNCButtons = document.querySelectorAll(".archive-EFNC");
  const creationEFNCformButtons = document.querySelectorAll(".submit-EFNCform-creation");
  const modificationEFNCformButtons = document.querySelectorAll(".submit-EFNCform-modification");
  const entityCreationButtons = document.querySelectorAll(".submit-entity-creation");

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

  creationEFNCformButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir créer cette EFNC?"
      );
    });
  });

  modificationEFNCformButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir modifier cette EFNC?"
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


});
