function previewImage(previewSelector) {
    var preview = document.querySelector(previewSelector);
    preview.innerHTML = ''; // Clear the existing content

    if (this.files) {
        [].forEach.call(this.files, function (file) {
            // Ensure it's an image
            if (!/\.(jpe?g|png)$/i.test(file.name)) {
                return; // Skip this file
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
        });
    }
}

document.addEventListener('turbo:load', () => {
    document.body.addEventListener('change', (event) => {
        if (event.target && event.target.id === 'picture_NCpicture') {
            previewImage.call(event.target, '#NCpicturePreview');
        } else if (event.target && event.target.id === 'picture_TraceabilityPicture') {
            previewImage.call(event.target, '#TraceabilityPicturePreview');
        }
    });
    if (document.getElementById('picture_TraceabilityPicture') || document.getElementById('picture_NCpicture')) {
        document.getElementById('picture_TraceabilityPicture').addEventListener('change', function () {
            var fileSize = this.files[0].size;
            var maxSize = 4 * 1024 * 1024; // Maximum size in bytes (4MB in this example)

            if (fileSize > maxSize) {
                alert('The file size must be less than 4MB.');
                this.value = ''; // Clear the file input
                document.getElementById('TraceabilityPictureSizeWarning').style.display = 'block';
            } else {
                document.getElementById('TraceabilityPictureSizeWarning').style.display = 'none';
            }
        });
        document.getElementById('picture_NCpicture').addEventListener('change', function () {
            var fileSize = this.files[0].size;
            var maxSize = 4 * 1024 * 1024; // Maximum size in bytes (4MB in this example)

            if (fileSize > maxSize) {
                alert('The file size must be less than 4MB.');
                this.value = ''; // Clear the file input
                document.getElementById('NCpictureSizeWarning').style.display = 'block';
            } else {
                document.getElementById('NCpictureSizeWarning').style.display = 'none';
            }
        });
    }
});


