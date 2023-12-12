
document.addEventListener('turbo:load', function () {
    // Get the container that holds the collection and the add-item button
    var collectionHolder = document.querySelector('#imcome-container');
    var addItemButton = document.querySelector('#add-another-imcome');

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    var index = collectionHolder.querySelectorAll('.imcome-entry').length;

    // Add a new item when the button is clicked
    addItemButton.addEventListener('click', function (e) {
        e.preventDefault();

        // Retrieve the prototype defined by the 'data-prototype' attribute
        var prototype = collectionHolder.getAttribute('data-prototype');

        // Replace '__name__' in the prototype's HTML to create a new index
        var newItem = prototype.replace(/__name__/g, index);

        // Increase the index with one for the next item
        index++;

        // Convert the HTML string into an actual DOM element
        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = newItem;

        var formGroup = tempDiv.firstChild; // Change this if your newItem is nested

        // Append the new form group to the collectionHolder
        collectionHolder.appendChild(formGroup);

        // Optionally: add a remove button to the newItem and attach event handler
        addRemoveButton(formGroup);
    });

    function addRemoveButton(item) {
        // Create the remove button
        var removeButton = document.createElement('button');
        removeButton.textContent = 'Supprimer';
        removeButton.className = 'remove-item-button'; // You can set your class for styling

        // Append it to the item
        item.appendChild(removeButton);

        // Handle the click event of the remove button
        removeButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove the item from the DOM
            item.remove();
        });
    }

    // Optionally: Setup an initial "remove" button on existing items
    var existingItems = collectionHolder.querySelectorAll('.imcome-entry');
    existingItems.forEach(function (item) {
        addRemoveButton(item);
    });
});

