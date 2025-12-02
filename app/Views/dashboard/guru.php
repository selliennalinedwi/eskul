<?php
$guru_name = session()->get('user_name');
?>

<!-- Dashboard Guru View -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="p-6 border-b border-blue-700">
            <h1 class="text-2xl font-bold">EkskulOnline</h1>
            <p class="text-blue-200 text-sm">Dashboard Guru</p>
        </div>
        
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-blue-700 hover:bg-blue-600 transition">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/early-warning" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Early Warning</span>
                    </a>
                </li>
                <li>
                    <a href="/early-warning/create" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus-circle"></i>
                        <span>Buat Warning</span>
                    </a>
                </li>
                <li>
                    <a href="/media/gallery" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-images"></i>
                        <span>Media</span>
                    </a>
                </li>
                <li>
                    <a href="/profile/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
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
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard Guru</h2>
                    <p class="text-gray-500">Selamat datang, Guru <?= esc($guru_name) ?>!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500"><?= date('l, d F Y') ?></p>
                        <p class="text-xs text-gray-400"><?= date('H:i') ?></p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        <?= substr($guru_name, 0, 1) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="p-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Siswa</p>
                            <p class="text-3xl font-bold text-gray-800"><?= $total_siswa ?? 0 ?></p>
                        </div>
                        <i class="fas fa-users text-blue-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Ekskul</p>
                            <p class="text-3xl font-bold text-gray-800"><?= $ekskuls_count ?? 0 ?></p>
                        </div>
                        <i class="fas fa-star text-green-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Registrasi Baru</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($registrations ?? []) ?></p>
                        </div>
                        <i class="fas fa-clipboard-list text-orange-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Warning Aktif</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($warnings ?? []) ?></p>
                        </div>
                        <i class="fas fa-exclamation-triangle text-red-500 text-3xl opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Registrations -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-list text-blue-600 mr-2"></i>Registrasi Terbaru
                    </h3>
                    <div class="space-y-3">
                        <?php foreach(array_slice($registrations ?? [], 0, 5) as $reg): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div>
                                <p class="text-sm font-semibold text-gray-800"><?= esc($reg['student_name']) ?></p>
                                <p class="text-xs text-gray-500"><?= esc($reg['ekskul_title']) ?></p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <?= ucfirst($reg['status']) ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                        <?php if(empty($registrations)): ?>
                        <p class="text-gray-500 text-center py-4">Belum ada registrasi</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Active Warnings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>Peringatan Aktif
                    </h3>
                    <div class="space-y-3">
                        <?php foreach(array_slice($warnings ?? [], 0, 5) as $warning): ?>
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition">
                            <div>
                                <p class="text-sm font-semibold text-gray-800"><?= esc($warning['student_name']) ?></p>
                                <p class="text-xs text-gray-500"><?= esc(substr($warning['title'] ?? $warning['description'] ?? '', 0, 40)) ?></p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                <?= ucfirst($warning['severity'] ?? 'normal') ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                        <?php if(empty($warnings)): ?>
                        <p class="text-gray-500 text-center py-4">Belum ada warning</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <a href="/early-warning/create" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <i class="fas fa-plus-circle text-4xl mb-4"></i>
                    <p class="font-semibold">Buat Warning Baru</p>
                    <p class="text-sm opacity-90 mt-2">Buat peringatan untuk siswa</p>
                </a>

                <a href="/media/upload" class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <i class="fas fa-image text-4xl mb-4"></i>
                    <p class="font-semibold">Upload Media</p>
                    <p class="text-sm opacity-90 mt-2">Upload foto atau file media</p>
                </a>

                <a href="/profile/settings" class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <i class="fas fa-bell text-4xl mb-4"></i>
                    <p class="font-semibold">Atur Notifikasi</p>
                    <p class="text-sm opacity-90 mt-2">Update nomor WA & email</p>
                </a>
            </div>
        </div>
    </div>
</div>
