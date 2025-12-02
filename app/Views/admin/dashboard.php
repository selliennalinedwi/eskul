<?php
$admin_name = session()->get('user_name');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Ekskul Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">

<!-- Navigation Sidebar -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-red-600 to-red-800 text-white shadow-lg">
        <div class="p-6 border-b border-red-700">
            <h1 class="text-2xl font-bold">EkskulOnline</h1>
            <p class="text-red-200 text-sm">Dashboard Admin</p>
        </div>
        
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-red-700 hover:bg-red-600 transition">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/registrations" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Pendaftaran</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/ekskuls" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-star"></i>
                        <span>Kelola Ekskul</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-users"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/teachers" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-chalkboard-user"></i>
                        <span>Kelola Guru</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/reports" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
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
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                    <p class="text-gray-500">Selamat datang, Admin <?= $admin_name ?>!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500"><?= date('l, d F Y') ?></p>
                        <p class="text-xs text-gray-400"><?= date('H:i') ?></p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center text-white font-bold">
                        <?= substr($admin_name, 0, 1) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="p-8">
            <!-- Alert Messages -->
            <?php if(session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <!-- Card 1: Total Ekskul -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Total Ekskul</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($ekskuls) ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-star text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Pendaftaran -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Total Pendaftaran</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($registrations) ?></p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-users text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Pending -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Menunggu Verifikasi</p>
                            <p class="text-3xl font-bold text-gray-800">
                                <?php 
                                $pending = count(array_filter($registrations, function($r) { 
                                    return $r['status'] === 'pending'; 
                                }));
                                echo $pending;
                                ?>
                            </p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <i class="fas fa-hourglass-half text-yellow-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Approved -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Disetujui</p>
                            <p class="text-3xl font-bold text-gray-800">
                                <?php 
                                $approved = count(array_filter($registrations, function($r) { 
                                    return $r['status'] === 'approved'; 
                                }));
                                echo $approved;
                                ?>
                            </p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Rejected -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Ditolak</p>
                            <p class="text-3xl font-bold text-gray-800">
                                <?php 
                                $rejected = count(array_filter($registrations, function($r) { 
                                    return $r['status'] === 'rejected'; 
                                }));
                                echo $rejected;
                                ?>
                            </p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-lg">
                            <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Left Column: Charts -->
                <div class="lg:col-span-2">
                    <!-- Chart: Distribusi Pendaftaran -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Status Pendaftaran</h3>
                        <canvas id="registrationChart" height="300"></canvas>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4 pb-4 border-b">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Pendaftaran baru</p>
                                    <p class="text-sm text-gray-500"><?= $pending ?> menunggu verifikasi</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 pb-4 border-b">
                                <div class="bg-green-100 p-2 rounded-full">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Ekskul Aktif</p>
                                    <p class="text-sm text-gray-500"><?= count($ekskuls) ?> ekskul tersedia</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="bg-orange-100 p-2 rounded-full">
                                    <i class="fas fa-bell text-orange-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Sistem Sehat</p>
                                    <p class="text-sm text-gray-500">Semua fitur berjalan normal</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Actions -->
                <div>
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="/admin/ekskul/add" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition">
                                <i class="fas fa-plus mr-2"></i>Tambah Ekskul
                            </a>
                            <a href="/admin/registrations" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition">
                                <i class="fas fa-list mr-2"></i>Lihat Pendaftaran
                            </a>
                            <a href="/admin/users" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition">
                                <i class="fas fa-users mr-2"></i>Kelola Pengguna
                            </a>
                        </div>
                    </div>

                    <!-- Top Ekskul -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ekskul Terpopuler</h3>
                        <div class="space-y-3">
                            <?php 
                            $ekskulCount = [];
                            foreach($registrations as $reg) {
                                $ekskul = $reg['ekskul_title'];
                                $ekskulCount[$ekskul] = ($ekskulCount[$ekskul] ?? 0) + 1;
                            }
                            arsort($ekskulCount);
                            $count = 0;
                            foreach($ekskulCount as $eks => $cnt):
                                if($count >= 5) break;
                                $count++;
                            ?>
                            <div class="flex justify-between items-center pb-3 border-b last:border-b-0">
                                <p class="font-semibold text-gray-700"><?= $eks ?></p>
                                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-bold">
                                    <?= $cnt ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Registrations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Pendaftaran Menunggu Verifikasi</h3>
                    <a href="/admin/registrations" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Ekskul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $displayed = 0;
                            foreach($registrations as $reg):
                                if($reg['status'] !== 'pending') continue;
                                if($displayed >= 5) break;
                                $displayed++;
                            ?>
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-700"><?= $i++ ?></td>
                                <td class="px-6 py-3 text-sm font-semibold text-gray-800"><?= $reg['student_name'] ?></td>
                                <td class="px-6 py-3 text-sm text-gray-700"><?= $reg['ekskul_title'] ?></td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-sm space-x-2">
                                    <a href="/admin/approve/<?= $reg['id'] ?>" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                        <i class="fas fa-check mr-1"></i>Setujui
                                    </a>
                                    <a href="/admin/reject/<?= $reg['id'] ?>" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                        <i class="fas fa-times mr-1"></i>Tolak
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chart: Status Pendaftaran
document.addEventListener('DOMContentLoaded', function() {
    const statusData = {
        pending: <?= $pending ?>,
        approved: <?= $approved ?>,
        rejected: <?= $rejected ?>
    };

    const ctx = document.getElementById('registrationChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [statusData.pending, statusData.approved, statusData.rejected],
                backgroundColor: [
                    'rgba(234, 179, 8, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                ],
                borderColor: [
                    'rgba(234, 179, 8, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

</body>
</html>
