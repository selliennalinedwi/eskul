<?php
$user_name = session()->get('user_name');
$role = session()->get('role');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Gallery - Ekskul Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
</head>
<body class="bg-gray-50">

<div class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <a href="/" class="text-2xl font-bold text-indigo-600">EkskulOnline</a>
                    <h2 class="text-lg font-semibold text-gray-700">Media Gallery</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/media/upload" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                        <i class="fas fa-cloud-upload-alt mr-2"></i>Upload Foto
                    </a>
                    <div class="text-sm text-gray-600">
                        <p class="font-semibold"><?= $user_name ?></p>
                        <p class="text-xs"><?= ucfirst($role) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Galeri Media Anda</h1>
            <p class="text-gray-600">Kelola dan lihat semua foto yang telah Anda upload</p>
        </div>

        <!-- Alert Messages -->
        <?php if(session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Foto</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $stats['total'] ?? 0 ?></p>
                    </div>
                    <i class="fas fa-images text-4xl text-indigo-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Foto Profil</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $stats['profile'] ?? 0 ?></p>
                    </div>
                    <i class="fas fa-user-circle text-4xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Foto Produk</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $stats['product'] ?? 0 ?></p>
                    </div>
                    <i class="fas fa-box text-4xl text-orange-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Logo</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $stats['logo'] ?? 0 ?></p>
                    </div>
                    <i class="fas fa-image text-4xl text-purple-200"></i>
                </div>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="/media/gallery" class="px-4 py-2 rounded-full font-semibold transition <?= !$current_type ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                <i class="fas fa-th mr-2"></i>Semua
            </a>
            <a href="/media/gallery?type=profile" class="px-4 py-2 rounded-full font-semibold transition <?= $current_type === 'profile' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                <i class="fas fa-user-circle mr-2"></i>Profil
            </a>
            <a href="/media/gallery?type=product" class="px-4 py-2 rounded-full font-semibold transition <?= $current_type === 'product' ? 'bg-orange-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                <i class="fas fa-box mr-2"></i>Produk
            </a>
            <a href="/media/gallery?type=logo" class="px-4 py-2 rounded-full font-semibold transition <?= $current_type === 'logo' ? 'bg-purple-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                <i class="fas fa-image mr-2"></i>Logo
            </a>
            <a href="/media/gallery?type=gallery" class="px-4 py-2 rounded-full font-semibold transition <?= $current_type === 'gallery' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                <i class="fas fa-images mr-2"></i>Galeri
            </a>
        </div>

        <!-- Media Grid -->
        <?php if(count($media) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach($media as $item): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group">
                <!-- Image -->
                <div class="relative overflow-hidden bg-gray-200 aspect-square">
                    <img src="<?= base_url($item['file_path']) ?>" alt="<?= $item['description'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center gap-2">
                        <a href="<?= base_url($item['file_path']) ?>" class="hidden group-hover:flex items-center justify-center w-10 h-10 bg-white rounded-full text-gray-700 hover:bg-indigo-600 hover:text-white transition" data-lightbox="gallery" data-title="<?= $item['description'] ?>">
                            <i class="fas fa-search-plus"></i>
                        </a>
                        <a href="/media/view/<?= $item['id'] ?>" class="hidden group-hover:flex items-center justify-center w-10 h-10 bg-white rounded-full text-gray-700 hover:bg-blue-600 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/media/delete/<?= $item['id'] ?>" class="hidden group-hover:flex items-center justify-center w-10 h-10 bg-white rounded-full text-gray-700 hover:bg-red-600 hover:text-white transition" onclick="return confirm('Hapus foto ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>

                    <!-- Type Badge -->
                    <div class="absolute top-2 left-2">
                        <span class="bg-indigo-600 text-white px-2 py-1 rounded text-xs font-semibold">
                            <?= ucfirst($item['type']) ?>
                        </span>
                    </div>

                    <!-- Visibility Badge -->
                    <div class="absolute top-2 right-2">
                        <span class="<?= $item['is_public'] ? 'bg-green-600' : 'bg-gray-600' ?> text-white px-2 py-1 rounded text-xs font-semibold">
                            <?= $item['is_public'] ? 'Publik' : 'Pribadi' ?>
                        </span>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-4">
                    <p class="text-sm font-semibold text-gray-700 truncate"><?= $item['original_filename'] ?></p>
                    <p class="text-xs text-gray-500 mb-3"><?= $item['width'] ?>x<?= $item['height'] ?> • <?= round($item['file_size'] / 1024, 1) ?> KB</p>
                    
                    <?php if($item['description']): ?>
                    <p class="text-xs text-gray-600 line-clamp-2 mb-3"><?= $item['description'] ?></p>
                    <?php endif; ?>

                    <p class="text-xs text-gray-400">
                        <i class="fas fa-calendar mr-1"></i><?= date('d M Y', strtotime($item['created_at'])) ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-16">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
            <h2 class="text-2xl font-bold text-gray-700 mb-2">Tidak ada foto</h2>
            <p class="text-gray-500 mb-6">Mulai upload foto Anda sekarang untuk mengisi galeri media</p>
            <a href="/media/upload" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-cloud-upload-alt mr-2"></i>Upload Foto Pertama
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

</body>
</html>
