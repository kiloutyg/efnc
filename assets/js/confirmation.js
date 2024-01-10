window.addEventListener("turbo:load", () => {
  const archiveEntityButtons = document.querySelectorAll(".archive-entity");
  const restoreArchivedEntityButtons = document.querySelectorAll(
    ".restore-entity"
  );
  const deleteCategoryButtons = document.querySelectorAll(".delete-category");
  const deleteButtonButtons = document.querySelectorAll(".delete-button");
  const deleteUserButtons = document.querySelectorAll(".delete-user");
  const deleteUserButtonsDefinitively = document.querySelectorAll(".definitively-delete-user");
  const deleteUploadButtons = document.querySelectorAll(".delete-upload");
  const deleteIncidentButtons = document.querySelectorAll(".delete-incident");
  const deleteIncidentCategoryButtons = document.querySelectorAll(
    ".delete-incidentCategory"
  );
  const deleteDepartmentButtons = document.querySelectorAll(
    ".delete-department"
  );
  const submitApprovalButtons = document.querySelectorAll(
    ".submit-approval"
  );
  const submitDisapprovalModifcationButtons = document.querySelectorAll(
    ".submit-disapproval-modification");
  const submitUploadModifcationButtons = document.querySelectorAll(
    ".submit-upload-modification");
  const submitIncidentModifcationButtons = document.querySelectorAll(
    ".submit-incident-modification");
  const submitViewsModifcationButtons = document.querySelectorAll(
    ".submit-views-modification");

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
  deleteCategoryButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer cette categorie?"
      );
    });
  });
  deleteButtonButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer ce Bouton?"
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
  deleteUserButtonsDefinitively.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer cet Utilisateur? Celà supprimera également tous les incidents et documents liés à cet utilisateur."
      );
    });
  });
  deleteUploadButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer ce Document?"
      );
    });
  });
  deleteIncidentButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer cet Incident?"
      );
    });
  });
  deleteIncidentCategoryButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer ce Type d'Incident?"
      );
    });
  });
  deleteDepartmentButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir supprimer ce Service?"
      );
    });
  });
  submitApprovalButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir soumettre ce formulaire de validation?"
      );
    });
  });
  submitDisapprovalModifcationButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir soumettre ces modifications?"
      );
    });
  });
  submitUploadModifcationButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir soumettre ces modifications?"
      );
    });
  });
  submitIncidentModifcationButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir soumettre ces modifications?"
      );
    });
  });
  submitViewsModifcationButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      confirmationHandler(
        event,
        "Êtes vous sûr de vouloir soumettre ces modifications?"
      );
    });
  });
});
