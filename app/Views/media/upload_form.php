<?php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto - Media Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-8">
                <h1 class="text-3xl font-bold text-white">
                    <i class="fas fa-cloud-upload-alt mr-3"></i>Upload Foto
                </h1>
                <p class="text-indigo-100 mt-2">Unggah foto Anda dengan mudah dan sesuaikan aspect ratio seperti Instagram</p>
            </div>

            <div class="p-8">
                <!-- Alert Messages -->
                <?php if(session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
                <?php endif; ?>

                <!-- Upload Form -->
                <form id="uploadForm" enctype="multipart/form-data" class="space-y-6">
                    <?= csrf_field() ?>

                    <!-- File Input with Drag & Drop -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-image mr-2"></i>Pilih Foto
                        </label>
                        <div class="relative">
                            <div id="dropZone" class="border-2 border-dashed border-indigo-300 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-500 transition bg-indigo-50">
                                <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden" required>
                                
                                <div id="dropZoneContent">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-indigo-400 mb-3 block"></i>
                                    <p class="text-gray-700 font-semibold">Tarik foto ke sini atau klik untuk memilih</p>
                                    <p class="text-gray-500 text-sm mt-1">Maksimal 5MB | Format: JPG, PNG, GIF, WebP</p>
                                </div>

                                <div id="uploadProgress" class="hidden">
                                    <div class="text-indigo-600 font-semibold mb-2">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Mengupload...
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div id="progressBar" class="bg-indigo-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>

                                <div id="filePreview" class="hidden">
                                    <img id="previewImage" src="" alt="Preview" class="max-h-64 mx-auto mb-3 rounded">
                                    <p id="fileName" class="text-gray-600 text-sm"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aspect Ratio Selection -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-expand-alt mr-2"></i>Aspect Ratio
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <?php foreach($aspectRatios as $key => $ratio): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="aspect_ratio" value="<?= $key ?>" <?= $key === 'square' ? 'checked' : '' ?> class="sr-only" data-ratio="<?= $ratio['ratio'] ?>">
                                <div class="border-2 border-gray-300 rounded-lg p-4 text-center hover:border-indigo-500 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                    <div class="aspect-ratio-preview mb-2" style="--ratio: <?= $ratio['ratio'] ?>">
                                        <div class="bg-indigo-200 rounded" style="padding-bottom: <?= (1 / $ratio['ratio']) * 100 ?>%"></div>
                                    </div>
                                    <p class="font-semibold text-sm text-gray-700"><?= ucfirst(str_replace('_', ' ', $key)) ?></p>
                                    <p class="text-xs text-gray-500"><?= $ratio['width'] ?>x<?= $ratio['height'] ?></p>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Type Selection -->
                    <div class="space-y-3">
                        <label for="type" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-tag mr-2"></i>Tipe Foto
                        </label>
                        <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="profile">Foto Profil</option>
                            <option value="product">Foto Produk</option>
                            <option value="logo">Logo</option>
                            <option value="gallery">Galeri</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-align-left mr-2"></i>Deskripsi (Opsional)
                        </label>
                        <textarea name="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tambahkan deskripsi untuk foto Anda..."></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6">
                        <a href="/media/gallery" class="flex-1 text-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                            <i class="fas fa-upload mr-2"></i>Upload Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.aspect-ratio-preview {
    --ratio: 1;
}

.aspect-ratio-preview > div {
    padding-bottom: calc((1 / var(--ratio)) * 100%);
}
</style>

<script>
const dropZone = document.getElementById('dropZone');
const photoInput = document.getElementById('photoInput');
const filePreview = document.getElementById('filePreview');
const previewImage = document.getElementById('previewImage');
const fileName = document.getElementById('fileName');
const uploadForm = document.getElementById('uploadForm');
const dropZoneContent = document.getElementById('dropZoneContent');
const uploadProgress = document.getElementById('uploadProgress');
const progressBar = document.getElementById('progressBar');

// Drag & Drop
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-indigo-500', 'bg-indigo-100');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-indigo-500', 'bg-indigo-100');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-indigo-500', 'bg-indigo-100');
    
    const files = e.dataTransfer.files;
    if(files.length > 0) {
        photoInput.files = files;
        handleFileSelect();
    }
});

dropZone.addEventListener('click', () => {
    photoInput.click();
});

photoInput.addEventListener('change', handleFileSelect);

function handleFileSelect() {
    const file = photoInput.files[0];
    if(!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        previewImage.src = e.target.result;
        fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        dropZoneContent.classList.add('hidden');
        filePreview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

// Form submit
uploadForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(uploadForm);
    const submitBtn = uploadForm.querySelector('button[type="submit"]');
    
    submitBtn.disabled = true;
    dropZoneContent.classList.add('hidden');
    filePreview.classList.add('hidden');
    uploadProgress.classList.remove('hidden');

    try {
        const response = await fetch('/media/upload-ajax', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if(result.status) {
            alert(result.message);
            window.location.href = '/media/gallery';
        } else {
            alert('Error: ' + result.message);
            uploadProgress.classList.add('hidden');
            dropZoneContent.classList.remove('hidden');
        }
    } catch(error) {
        console.error('Upload error:', error);
        alert('Error uploading file');
        uploadProgress.classList.add('hidden');
        dropZoneContent.classList.remove('hidden');
    }

    submitBtn.disabled = false;
});

// Simulate progress
function simulateProgress() {
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 30;
        if(progress > 90) progress = 90;
        progressBar.style.width = progress + '%';
        
        if(progress >= 90) clearInterval(interval);
    }, 200);
}

uploadForm.addEventListener('submit', () => {
    simulateProgress();
});
</script>

</body>
</html>
