function previewNcPicture() {
    var preview = document.querySelector('#NCpicturePreview');
    preview.innerHTML = '';  // Clear the existing content

    if (this.files) {
        [].forEach.call(this.files, readAndPreview);
    }

    function readAndPreview(file) {
        // Ensure it's an image
        if (!/\.(jpe?g|png)$/i.test(file.name)) {
            return;  // Skip this file
        }

        var reader = new FileReader();

        reader.addEventListener("load", function () {
            var image = new Image();
            image.height = 100; // Set the image height (optional)
            image.title = file.name;
            image.src = this.result;
            preview.appendChild(image);
        }, false);

        reader.readAsDataURL(file);
    }
}
document.addEventListener('turbo:load', () => {
    document.body.addEventListener('change', (event) => {
        if (event.target && event.target.id === 'picture_NCpicture') {
            previewNcPicture.call(event.target);
        }
    });
});




function previewTraceabilityPicture() {
    var preview = document.querySelector('#TraceabilityPicturePreview');
    preview.innerHTML = '';  // Clear the existing content

    if (this.files) {
        [].forEach.call(this.files, readAndPreview);
    }

    function readAndPreview(file) {
        // Ensure it's an image
        if (!/\.(jpe?g|png)$/i.test(file.name)) {
            return;  // Skip this file
        }

        var reader = new FileReader();

        reader.addEventListener("load", function () {
            var image = new Image();
            image.height = 100; // Set the image height (optional)
            image.title = file.name;
            image.src = this.result;
            preview.appendChild(image);
        }, false);

        reader.readAsDataURL(file);
    }
}

document.addEventListener('turbo:load', () => {
    document.body.addEventListener('change', (event) => {
        if (event.target && event.target.id === 'picture_TraceabilityPicture') {
            previewTraceabilityPicture.call(event.target);
        }
    });
});