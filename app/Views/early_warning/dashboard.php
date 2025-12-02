<?php
$admin_name = session()->get('user_name');
?>

<!-- Page Header -->
<div class="bg-white shadow-sm border-b border-gray-200 mb-6">
    <div class="px-6 py-4 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Early Warning System</h2>
            <p class="text-gray-500">Sistem Peringatan Dini Siswa</p>
        </div>
        <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center text-white font-bold">
            <?= substr($admin_name, 0, 1) ?>
        </div>
    </div>
</div>

<!-- Content Area -->
<div class="space-y-6">
            <!-- Action Buttons -->
            <div class="mb-6 flex gap-4">
                <a href="/early-warning/create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    <i class="fas fa-plus mr-2"></i>Buat Warning Baru
                </a>
                <a href="/early-warning/send-notifications" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Notifikasi
                </a>
            </div>

            <!-- Warnings Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Peringatan Aktif</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Tipe Warning</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Tingkat</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($warnings) > 0): ?>
                                <?php foreach($warnings as $key => $warning): ?>
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-3 text-sm text-gray-700"><?= $key + 1 ?></td>
                                    <td class="px-6 py-3 text-sm">
                                        <div>
                                            <p class="font-semibold text-gray-800"><?= $warning['student_name'] ?></p>
                                            <p class="text-xs text-gray-500"><?= $warning['email'] ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-sm">
                                        <?php 
                                        $type_badge = [
                                            'attendance' => 'blue',
                                            'performance' => 'orange',
                                            'behavior' => 'red',
                                            'dropout_risk' => 'purple'
                                        ];
                                        $color = $type_badge[$warning['type']] ?? 'gray';
                                        ?>
                                        <span class="bg-<?= $color ?>-100 text-<?= $color ?>-800 px-2 py-1 rounded text-xs font-semibold">
                                            <?= ucfirst(str_replace('_', ' ', $warning['type'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-700"><?= $warning['title'] ?></td>
                                    <td class="px-6 py-3 text-sm">
                                        <?php 
                                        $severity_color = $warning['severity'] === 'high' ? 'red' : ($warning['severity'] === 'medium' ? 'yellow' : 'green');
                                        ?>
                                        <span class="bg-<?= $severity_color ?>-100 text-<?= $severity_color ?>-800 px-2 py-1 rounded text-xs font-semibold">
                                            <?= strtoupper($warning['severity']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-600"><?= date('d M Y', strtotime($warning['created_at'])) ?></td>
                                    <td class="px-6 py-3 text-sm space-x-2">
                                        <a href="/early-warning/view/<?= $warning['id'] ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">
                                            <i class="fas fa-eye mr-1"></i>Lihat
                                        </a>
                                        <a href="/early-warning/resolve/<?= $warning['id'] ?>" class="text-green-600 hover:text-green-800 font-semibold text-xs" onclick="return confirm('Tandai sebagai terselesaikan?')">
                                            <i class="fas fa-check mr-1"></i>Selesai
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-smile text-4xl mb-3 block"></i>
                                        Tidak ada warning aktif
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Total Warning</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($warnings) ?></p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Tingkat Tinggi</p>
                            <p class="text-3xl font-bold text-gray-800">
                                <?php echo count(array_filter($warnings, function($w) { return $w['severity'] === 'high'; })); ?>
                            </p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-lg">
                            <i class="fas fa-alert text-red-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Tingkat Sedang</p>
                            <p class="text-3xl font-bold text-gray-800">
                                <?php echo count(array_filter($warnings, function($w) { return $w['severity'] === 'medium'; })); ?>
                            </p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <i class="fas fa-info-circle text-yellow-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Tingkat Rendah</p>
                            <p class="text-3xl font-bold text-gray-800">
                                <?php echo count(array_filter($warnings, function($w) { return $w['severity'] === 'low'; })); ?>
                            </p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
