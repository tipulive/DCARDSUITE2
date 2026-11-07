<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Image Upload Test</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Product Image Upload</h4>
                    </div>
                    <div class="card-body">

                        <form id="uploadForm">
                            <!-- Product Code -->
                            <div class="mb-3">
                                <label for="productCode" class="form-label fw-bold">Product Code</label>
                                <input type="text" class="form-control" id="productCode" name="productCode" value="PROD-123" required>
                            </div>

                            <!-- Image File Input -->
                            <div class="mb-3">
                                <label for="image" class="form-label fw-bold">Select Image (JPEG, PNG, JPG)</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg, image/png, image/jpg" required>
                                <div class="form-text">Max size: 2MB.</div>
                            </div>

                            <!-- Parameters sent separately in FormData -->
                            <input type="hidden" name="fileNumb" value="01">
                            <input type="hidden" name="isFilenameExist" value="false">

                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn" class="btn btn-primary w-100">
                                <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                                Upload Image
                            </button>
                        </form>

                        <!-- Response Box Section -->
                        <div class="mt-4">
                            <h5 class="text-muted fs-6">Server Response:</h5>
                            <div id="responseAlert" class="alert alert-secondary font-monospace small mb-0" style="white-space: pre-wrap; max-height: 250px; overflow-y: auto;">
                                Awaiting submission...
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const responseAlert = document.getElementById('responseAlert');
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('spinner');

            // UI Loading state
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            responseAlert.className = 'alert alert-info font-monospace small mb-0';
            responseAlert.textContent = 'Uploading image...';

            // Clean URL without parameters in path
            const url = '/api/testImageUpload';
  var Usertoken=localStorage.getItem("Usertoken");
            // Create FormData object directly from the form (includes hidden fields & file automatically)
            const formData = new FormData(this);

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Authorization': 'Bearer ' + Usertoken, // Uncomment if using auth middleware
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();
                responseAlert.textContent = JSON.stringify(result, null, 2);

                if (response.ok && result.status) {
                    responseAlert.className = 'alert alert-success font-monospace small mb-0';
                } else {
                    responseAlert.className = 'alert alert-danger font-monospace small mb-0';
                }
            } catch (error) {
                responseAlert.className = 'alert alert-danger font-monospace small mb-0';
                responseAlert.textContent = 'Network or Client Error:\n' + error.message;
            } finally {
                // Restore button state
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        });
    </script>
</body>
</html>
