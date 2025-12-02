<?php
$admin_name = session()->get('user_name');
?>

<!-- Dashboard Admin View - Content Only (without header/footer tags) -->
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
                    <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-red-700 hover:bg-red-600 transition">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/early-warning" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Early Warning</span>
                    </a>
                </li>
                <li>
                    <a href="/media/gallery" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-images"></i>
                        <span>Media</span>
                    </a>
                </li>
                <li>
                    <a href="/profile/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition">
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
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
                    <p class="text-gray-500">Selamat datang, Admin <?= esc($admin_name) ?>!</p>
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

        <!-- Content Area -->
        <div class="p-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Pending</p>
                            <p class="text-3xl font-bold text-gray-800"><?= $pending ?? 0 ?></p>
                        </div>
                        <i class="fas fa-hourglass-half text-yellow-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Approved</p>
                            <p class="text-3xl font-bold text-gray-800"><?= $approved ?? 0 ?></p>
                        </div>
                        <i class="fas fa-check-circle text-green-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Rejected</p>
                            <p class="text-3xl font-bold text-gray-800"><?= $rejected ?? 0 ?></p>
                        </div>
                        <i class="fas fa-times-circle text-red-500 text-3xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Ekskul</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($ekskuls ?? []) ?></p>
                        </div>
                        <i class="fas fa-star text-blue-500 text-3xl opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Chart and Table -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Chart -->
                <div class="lg:col-span-1 bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-chart-doughnut text-red-600 mr-2"></i>Status Pendaftaran
                    </h3>
                    <canvas id="registrationChart" class="max-w-xs mx-auto"></canvas>
                </div>

                <!-- Recent Registrations -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-list text-blue-600 mr-2"></i>Pendaftaran Terbaru
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">Siswa</th>
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">Ekskul</th>
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(array_slice($registrations ?? [], 0, 5) as $reg): ?>
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="py-3 px-4"><?= esc($reg['student_name']) ?></td>
                                    <td class="py-3 px-4"><?= esc($reg['ekskul_title']) ?></td>
                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            <?= $reg['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                ($reg['status'] === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') ?>">
                                            <?= ucfirst($reg['status']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 space-x-2">
                                        <?php if($reg['status'] === 'pending'): ?>
                                        <a href="/admin/approve/<?= $reg['id'] ?>" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                            <i class="fas fa-check mr-1"></i>Setujui
                                        </a>
                                        <a href="/admin/reject/<?= $reg['id'] ?>" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                            <i class="fas fa-times mr-1"></i>Tolak
                                        </a>
                                        <?php endif; ?>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart: Status Pendaftaran
document.addEventListener('DOMContentLoaded', function() {
    const statusData = {
        pending: <?= $pending ?? 0 ?>,
        approved: <?= $approved ?? 0 ?>,
        rejected: <?= $rejected ?? 0 ?>
    };

    const ctx = document.getElementById('registrationChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
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
    }
});
</script>
