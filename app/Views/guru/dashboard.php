<?php
// Ambil data guru dari session
$guru_id = session()->get('user_id');
$guru_name = session()->get('user_name');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Ekskul Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">

<!-- Navigation Sidebar -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-indigo-600 to-indigo-800 text-white shadow-lg">
        <div class="p-6 border-b border-indigo-700">
            <h1 class="text-2xl font-bold">EkskulOnline</h1>
            <p class="text-indigo-200 text-sm">Dashboard Guru</p>
        </div>
        
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="/guru/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-indigo-700 hover:bg-indigo-600 transition">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/guru/students" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-users"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="/guru/attendance" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Kehadiran</span>
                    </a>
                </li>
                <li>
                    <a href="/guru/schedule" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal</span>
                    </a>
                </li>
                <li>
                    <a href="/guru/messages" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-envelope"></i>
                        <span>Pesan</span>
                    </a>
                </li>
                <li>
                    <a href="/guru/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                <li>
                    <a href="/auth/logout" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-600 transition">
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
                    <p class="text-gray-500">Selamat datang, <?= $guru_name ?>!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500"><?= date('l, d F Y') ?></p>
                        <p class="text-xs text-gray-400"><?= date('H:i') ?></p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                        <?= substr($guru_name, 0, 1) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="p-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Card 1: Total Siswa -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Total Siswa</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($murid) ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Ekskul Aktif -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Ekskul Aktif</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($schedule) ?></p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-star text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Kehadiran Hari Ini -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Kehadiran Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-800" id="attendance-today">-</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Pesan Baru -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Pesan Baru</p>
                            <p class="text-3xl font-bold text-gray-800" id="new-messages">0</p>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-lg">
                            <i class="fas fa-bell text-orange-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Left Column: Charts -->
                <div class="lg:col-span-2">
                    <!-- Chart: Siswa per Ekskul -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Siswa per Ekskul</h3>
                        <canvas id="studentChart" height="300"></canvas>
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4 pb-4 border-b">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Siswa baru terdaftar</p>
                                    <p class="text-sm text-gray-500">2 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 pb-4 border-b">
                                <div class="bg-green-100 p-2 rounded-full">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Kehadiran dicatat</p>
                                    <p class="text-sm text-gray-500">Hari ini</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="bg-orange-100 p-2 rounded-full">
                                    <i class="fas fa-bell text-orange-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Pengingat jadwal</p>
                                    <p class="text-sm text-gray-500">Besok pukul 10:00</p>
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
                            <a href="/guru/attendance/create" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition">
                                <i class="fas fa-plus mr-2"></i>Catat Kehadiran
                            </a>
                            <a href="/guru/messages/compose" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition">
                                <i class="fas fa-envelope mr-2"></i>Kirim Pesan
                            </a>
                            <a href="/guru/schedule/create" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition">
                                <i class="fas fa-calendar mr-2"></i>Buat Jadwal
                            </a>
                        </div>
                    </div>

                    <!-- Jadwal Hari Ini -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Jadwal Hari Ini</h3>
                        <div class="space-y-3" id="today-schedule">
                            <?php 
                            $today = date('l');
                            $today_schedule = array_filter($schedule, function($s) use($today) {
                                return $s['hari'] === $today;
                            });
                            
                            if(count($today_schedule) > 0):
                                foreach($today_schedule as $s):
                            ?>
                            <div class="border-l-4 border-indigo-600 pl-4 py-2">
                                <p class="font-semibold text-gray-800"><?= $s['title'] ?? 'Ekskul' ?></p>
                                <p class="text-sm text-gray-500"><i class="fas fa-clock mr-2"></i><?= $s['jam_mulai'] ?? '10:00' ?> - <?= $s['jam_selesai'] ?? '11:00' ?></p>
                            </div>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <p class="text-gray-500 text-sm">Tidak ada jadwal hari ini</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Siswa Terakhir -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Siswa</h3>
                    <a href="/guru/students" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Ekskul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $displayed = 0;
                            foreach($murid as $m): 
                                if($displayed >= 5) break;
                                $formData = json_decode($m['form_data'], true);
                                $displayed++;
                            ?>
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-700"><?= $i++ ?></td>
                                <td class="px-6 py-3 text-sm font-semibold text-gray-800"><?= $formData['student_name'] ?? '-' ?></td>
                                <td class="px-6 py-3 text-sm text-gray-700"><?= $m['ekskul'] ?></td>
                                <td class="px-6 py-3 text-sm text-gray-600"><?= $formData['email'] ?? '-' ?></td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-sm">
                                    <a href="/guru/students/<?= $m['id'] ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold">Detail</a>
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
// Chart: Distribusi Siswa per Ekskul
document.addEventListener('DOMContentLoaded', function() {
    const studentData = <?= json_encode(array_count_values(array_column($murid, 'ekskul'))) ?>;
    const labels = Object.keys(studentData);
    const data = Object.values(studentData);

    const ctx = document.getElementById('studentChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Siswa',
                data: data,
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                ],
                borderColor: [
                    'rgba(99, 102, 241, 1)',
                    'rgba(236, 72, 153, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(249, 115, 22, 1)',
                ],
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>
