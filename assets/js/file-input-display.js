function addNewInput(event) {
    // 'event.target' is the input element on which the change event is fired
    var inputElement = event.target;

    // Clone the file input container
    var newInputContainer = inputElement.parentNode.cloneNode(true);

    // Get the new file input
    var newInput = newInputContainer.querySelector('input[type=file]');

    // Clear any selected files
    newInput.value = '';

    // Set a unique ID for the new input
    var newId = inputElement.id + '_' + document.querySelectorAll('input[type=file]').length;
    newInput.id = newId;

    // Update the container ID
    newInputContainer.id = newId + '_container';

    // Append the new file input container
    inputElement.parentNode.after(newInputContainer);
}


document.addEventListener('turbo:load', (event) => {
    // Grab the file input elements
    var traceabilityInput = document.querySelector('#form_creation_TraceabilityPicture');
    var ncInput = document.querySelector('#form_creation_NCpicture');

    // Attach 'change' event listeners to them
    if (traceabilityInput) {
        traceabilityInput.addEventListener('change', addNewInput);
    }
    if (ncInput) {
        ncInput.addEventListener('change', addNewInput);
    }
});
