@extends('user.base')

@section('content')
    <div class="container py-5">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('user.profile.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Profile
            </a>
        </div>

        <!-- Header -->
        <div class="mb-4">
            <h1 class="font-playfair h2 mb-2">Change Profile Picture</h1>
            <p class="text-muted">Select a new photo for your profile. You can crop the image as desired.</p>
        </div>

        <!-- Success Message -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Content -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row">
                    <!-- Current Profile Picture -->
                    <div class="col-lg-6 mb-4">
                        <h4 class="h5 mb-3">Current Profile Picture</h4>
                        <div class="text-center">
                            <img src="{{ $user->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&size=200&background=ff6b9d&color=ffffff&bold=true' }}"
                                alt="Current Profile Picture" class="rounded-circle border"
                                style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                    </div>

                    <!-- Upload New Picture -->
                    <div class="col-lg-6 mb-4">
                        <h4 class="h5 mb-3">Upload New Picture</h4>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label for="file-upload" class="form-label">Select Image</label>
                            <div class="border-2 border-dashed rounded p-4 text-center upload-zone"
                                style="border-color: #dee2e6; min-height: 120px; cursor: pointer;"
                                onclick="document.getElementById('file-upload').click()">
                                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-1">
                                        <strong>Click to upload</strong> or drag and drop
                                    </p>
                                    <p class="small text-muted mb-0">PNG, JPG, GIF up to 2MB</p>
                                </div>
                                <input id="file-upload" type="file" class="d-none" accept="image/*"
                                    onchange="loadImage(event)">
                            </div>
                            @error('profile_picture')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Image Cropper Section -->
                <div id="cropper-section" class="d-none mt-4">
                    <h4 class="h5 mb-3">Crop Image</h4>
                    <div class="bg-light rounded p-3">
                        <div class="text-center mb-3">
                            <div style="max-width: 100%; max-height: 400px; overflow: hidden;">
                                <img id="crop-image" src="" alt="Crop Image" style="max-width: 100%; height: auto;">
                            </div>
                        </div>

                        <!-- Crop Controls -->
                        <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
                            <button type="button" onclick="cropper.rotate(-90)" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i>
                                Rotate Left
                            </button>
                            <button type="button" onclick="cropper.rotate(90)" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-redo me-1"></i>
                                Rotate Right
                            </button>
                            <button type="button" onclick="cropper.reset()" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-refresh me-1"></i>
                                Reset
                            </button>
                        </div>

                        <!-- Preview -->
                        <div class="text-center mb-4">
                            <h5 class="h6 mb-2">Preview:</h5>
                            <div class="d-inline-block">
                                <div id="preview" class="rounded-circle border bg-light"
                                    style="width: 128px; height: 128px; overflow: hidden;">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" onclick="cancelCrop()" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </button>
                            <button type="button" onclick="uploadCroppedImage(event)" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Save Profile Picture
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

    <!-- Cropper.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        let cropper;
        let originalFileName;

        // Add CSRF token to meta if not exists
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const metaTag = document.createElement('meta');
            metaTag.name = 'csrf-token';
            metaTag.content = '{{ csrf_token() }}';
            document.head.appendChild(metaTag);
        }

        function loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                originalFileName = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    const image = document.getElementById('crop-image');
                    image.src = e.target.result;

                    // Show cropper section
                    document.getElementById('cropper-section').classList.remove('d-none');

                    // Initialize cropper
                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 2,
                        preview: '#preview',
                        responsive: true,
                        restore: false,
                        checkCrossOrigin: false,
                        checkOrientation: false,
                        modal: true,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        function uploadCroppedImage(event) {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingQuality: 'high'
                });

                canvas.toBlob(function(blob) {
                    const formData = new FormData();
                    formData.append('profile_picture', blob, originalFileName || 'profile.jpg');

                    // Show loading state
                    const button = event.target;
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';
                    button.disabled = true;

                    fetch('{{ route('user.profile.picture.update') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                setTimeout(() => {
                                    window.location.href = '{{ route('user.profile.index') }}';
                                }, 1500);
                            } else {
                                throw new Error(data.message || 'Upload failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);

                            // Show error message
                            showAlert('danger',
                                `An error occurred while saving the profile picture: ${error.message}`);

                            // Reset button
                            button.innerHTML = originalText;
                            button.disabled = false;
                        });
                }, 'image/jpeg', 0.9);
            }
        }

        // Helper function to show alerts safely
        function showAlert(type, message) {
            // Remove any existing alerts first
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            // Create new alert
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show mb-4`;
            alert.style.marginTop = '20px';
            alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

            // Find container and insert alert at the top
            const container = document.querySelector('.container');
            const firstChild = container.firstElementChild;

            if (firstChild) {
                container.insertBefore(alert, firstChild);
            } else {
                container.appendChild(alert);
            }

            // Auto-dismiss success alerts after 3 seconds
            if (type === 'success') {
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.remove();
                    }
                }, 3000);
            }
        }

        function cancelCrop() {
            document.getElementById('cropper-section').classList.add('d-none');
            document.getElementById('file-upload').value = '';
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        // Drag and drop functionality
        const dropZone = document.querySelector('.upload-zone');
        const fileInput = document.getElementById('file-upload');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--accent-pink)';
            dropZone.style.backgroundColor = '#fff5f8';
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
            dropZone.style.backgroundColor = '';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
            dropZone.style.backgroundColor = '';

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                loadImage({
                    target: {
                        files
                    }
                });
            }
        });
    </script>

    <style>
        .upload-zone:hover {
            border-color: var(--accent-pink) !important;
            background-color: #fff5f8;
        }

        .upload-zone {
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .gap-2 {
                gap: 0.5rem !important;
            }

            .gap-3 {
                gap: 1rem !important;
            }
        }
    </style>
@endsection
