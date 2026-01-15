
        

        // Preview Image Script
        function previewCover(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('coverPreview').src = e.target.result;
                    document.getElementById('coverPreview').style.display = 'block';
                    document.getElementById('uploadPlaceholder').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        