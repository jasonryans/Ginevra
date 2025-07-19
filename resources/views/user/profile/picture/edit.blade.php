@extends('user.base')

@section('user.content')
    <div class="min-h-screen bg-gray-50 pt-24 pb-4">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('profile.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Profil</span>
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Ubah Foto Profil</h1>
                <p class="mt-2 text-gray-600">Pilih foto baru untuk profil Anda. Anda dapat memotong gambar sesuai
                    keinginan.</p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Main Content -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Current Profile Picture -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Profil Saat Ini</h3>
                        <div class="flex justify-center">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-avatar.svg') }}"
                                alt="Foto Profil" class="w-48 h-48 rounded-full object-cover border-4 border-gray-200">
                        </div>
                    </div>

                    <!-- Upload New Picture -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Unggah Foto Baru</h3>

                        <!-- File Upload -->
                        <div class="mb-6">
                            <label for="file-upload" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Gambar
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Unggah file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only"
                                                accept="image/*" onchange="loadImage(event)">
                                        </label>
                                        <p class="pl-1">atau seret dan letakkan</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                            @error('profile_picture')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Image Cropper Section -->
                <div id="cropper-section" class="mt-8 hidden">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Potong Gambar</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-center mb-4">
                            <div style="max-width: 100%; max-height: 400px;">
                                <img id="crop-image" src="" alt="Potong Gambar"
                                    style="max-width: 100%; height: auto;">
                            </div>
                        </div>

                        <!-- Crop Controls -->
                        <div class="flex justify-center space-x-4 mb-4">
                            <button type="button" onclick="cropper.rotate(-90)"
                                class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Putar Kiri
                            </button>
                            <button type="button" onclick="cropper.rotate(90)"
                                class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 4v5h-.582m-15.356 2A8.001 8.001 0 0119.418 9m0 0H15m-11 11v-5h.581m0 0a8.003 8.003 0 0115.357-2M4.581 15H9">
                                    </path>
                                </svg>
                                Putar Kanan
                            </button>
                            <button type="button" onclick="cropper.reset()"
                                class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Reset
                            </button>
                        </div>

                        <!-- Preview -->
                        <div class="text-center mb-4">
                            <h4 class="text-md font-medium text-gray-700 mb-2">Preview:</h4>
                            <div class="inline-block">
                                <div id="preview"
                                    class="w-32 h-32 rounded-full border-4 border-gray-200 overflow-hidden bg-gray-100">
                                </div>
                            </div>
                        </div>

                        <!-- Upload Form -->
                        <form action="{{ route('user.profile.picture.update') }}" method="POST" enctype="multipart/form-data"
                            id="upload-form">
                            @csrf
                            <input type="hidden" name="profile_picture" id="cropped-image-data">

                            <div class="flex justify-center space-x-4">
                                <button type="button" onclick="cancelCrop()"
                                    class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                                    Batal
                                </button>
                                <button type="button" onclick="uploadCroppedImage(event)"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                    Simpan Foto Profil
                                </button>
                            </div>
                        </form>
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

        function loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                originalFileName = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    const image = document.getElementById('crop-image');
                    image.src = e.target.result;

                    // Show cropper section
                    document.getElementById('cropper-section').classList.remove('hidden');

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
                    const originalText = button.textContent;
                    button.textContent = 'Menyimpan...';
                    button.disabled = true;

                    fetch('{{ route('profile.picture.update') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                window.location.href = '{{ route('profile.index') }}';
                            } else {
                                alert('Terjadi kesalahan saat menyimpan foto profil.');
                                button.textContent = originalText;
                                button.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menyimpan foto profil.');
                            button.textContent = originalText;
                            button.disabled = false;
                        });
                }, 'image/jpeg', 0.9);
            }
        }

        function cancelCrop() {
            document.getElementById('cropper-section').classList.add('hidden');
            document.getElementById('file-upload').value = '';
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');
        const fileInput = document.getElementById('file-upload');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');

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
@endsection
