<?php
$siswa_name = session()->get('user_name');
?>

<!-- Dashboard Siswa View -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-purple-600 to-purple-800 text-white shadow-lg">
        <div class="p-6 border-b border-purple-700">
            <h1 class="text-2xl font-bold">EkskulOnline</h1>
            <p class="text-purple-200 text-sm">Dashboard Siswa</p>
        </div>
        
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-purple-700 hover:bg-purple-600 transition">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/ekskul" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-star"></i>
                        <span>Daftar Ekskul</span>
                    </a>
                </li>
                <li>
                    <a href="/media/gallery" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-images"></i>
                        <span>Galeri</span>
                    </a>
                </li>
                <li>
                    <a href="/profile/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-bell"></i>
                        <span>Notifikasi</span>
                    </a>
                </li>
                <li>
                    <a href="/auth/logout" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-orange-600 transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Top Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-8 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard Siswa</h2>
                    <p class="text-gray-500">Halo, <?= esc($siswa_name) ?>! 👋</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500"><?= date('l, d F Y') ?></p>
                        <p class="text-xs text-gray-400"><?= date('H:i') ?></p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                        <?= substr($siswa_name, 0, 1) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="p-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Ekskul Saya</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($my_registrations ?? []) ?></p>
                        </div>
                        <i class="fas fa-star text-purple-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Ekskul</p>
                            <p class="text-3xl font-bold text-gray-800"><?= $total_ekskul ?? 0 ?></p>
                        </div>
                        <i class="fas fa-list text-green-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Peringatan</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($my_warnings ?? []) ?></p>
                        </div>
                        <i class="fas fa-exclamation-triangle text-red-500 text-3xl opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- My Registrations -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-check-circle text-purple-600 mr-2"></i>Ekskul Saya
                    </h3>
                    <div class="space-y-3">
                        <?php foreach($my_registrations ?? [] as $reg): ?>
                        <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500 hover:shadow-md transition">
                            <p class="font-semibold text-gray-800"><?= esc($reg['title']) ?></p>
                            <p class="text-sm text-gray-600 mt-1"><?= esc(substr($reg['description'] ?? '', 0, 60)) ?></p>
                            <div class="flex items-center justify-between mt-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    <?= $reg['status'] === 'approved' ? 'bg-green-100 text-green-800' : 
                                        ($reg['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= ucfirst($reg['status']) ?>
                                </span>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php if(empty($my_registrations)): ?>
                        <p class="text-gray-500 text-center py-6">Belum mendaftar ekskul manapun</p>
                        <a href="/ekskul" class="block mt-4 w-full text-center bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg transition font-semibold">
                            <i class="fas fa-plus mr-2"></i>Jelajahi Ekskul
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Warnings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>Peringatan Anda
                    </h3>
                    <div class="space-y-3">
                        <?php foreach($my_warnings ?? [] as $warning): ?>
                        <div class="p-4 bg-red-50 rounded-lg border-l-4 border-red-500 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800"><?= esc($warning['title'] ?? $warning['description'] ?? '') ?></p>
                                    <p class="text-sm text-gray-600 mt-1"><?= esc(substr($warning['description'] ?? '', 0, 60)) ?></p>
                                </div>
                                <span class="ml-2 px-3 py-1 rounded text-xs font-semibold
                                    <?= $warning['severity'] === 'high' ? 'bg-red-200 text-red-800' :
                                        ($warning['severity'] === 'medium' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800') ?>">
                                    <?= ucfirst($warning['severity'] ?? 'normal') ?>
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                <?= date('d M Y H:i', strtotime($warning['created_at'] ?? '')) ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                        <?php if(empty($my_warnings)): ?>
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-4xl text-green-500 mb-3"></i>
                            <p class="text-gray-500">Tidak ada peringatan - Terus semangat! 🎉</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <a href="/ekskul" class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-lg mb-2">Jelajahi Ekskul Lainnya</h4>
                            <p class="opacity-90">Daftar ke ekskul pilihan Anda</p>
                        </div>
                        <i class="fas fa-arrow-right text-3xl opacity-30"></i>
                    </div>
                </a>

                <a href="/media/gallery" class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-lg mb-2">Galeri Saya</h4>
                            <p class="opacity-90">Lihat koleksi foto dan media Anda</p>
                        </div>
                        <i class="fas fa-arrow-right text-3xl opacity-30"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
