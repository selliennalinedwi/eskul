<?php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Warning Baru - Early Warning System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-plus-circle text-red-600 mr-2"></i>Buat Peringatan Baru
                </h1>
                <p class="text-gray-500 mt-2">Sistem akan mengirimkan notifikasi ke siswa dan orang tua</p>
            </div>

            <?php if(session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <ul>
                    <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form action="/early-warning/store" method="POST" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Pilih Siswa -->
                <div>
                    <label for="student_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-graduate mr-2"></i>Pilih Siswa
                    </label>
                    <select name="student_id" id="student_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="">-- Pilih Siswa --</option>
                    </select>
                    <small class="text-gray-500 mt-1 block">
                        <i class="fas fa-info-circle mr-1"></i>Nomor WhatsApp & Email akan diambil dari data siswa
                    </small>
                </div>

                <!-- Tipe Warning -->
                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2"></i>Tipe Warning
                    </label>
                    <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="attendance">Kehadiran Rendah</option>
                        <option value="performance">Performa Akademik Rendah</option>
                        <option value="behavior">Perilaku Kurang Baik</option>
                        <option value="dropout_risk">Risiko Keluar</option>
                    </select>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading mr-2"></i>Judul Warning
                    </label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Contoh: Kehadiran Siswa Sangat Rendah" required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2"></i>Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Jelaskan detail warning ini..." required></textarea>
                </div>

                <!-- Severity -->
                <div>
                    <label for="severity" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Tingkat Keseriusan
                    </label>
                    <select name="severity" id="severity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="low">Rendah</option>
                        <option value="medium">Sedang</option>
                        <option value="high">Tinggi</option>
                    </select>
                </div>

                <!-- Notification Options -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-bell mr-2"></i>Opsi Notifikasi
                    </h3>
                    
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="send_notification" value="1" checked class="w-4 h-4 text-red-600 rounded focus:ring-red-500 cursor-pointer">
                            <span class="ml-3 text-gray-700">Kirim notifikasi ke siswa/orang tua</span>
                        </label>

                        <div class="ml-8 space-y-2" id="notification-options">
                            <label class="flex items-center">
                                <input type="checkbox" name="notify_email" value="1" checked class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                                <span class="ml-3 text-gray-700"><i class="fas fa-envelope mr-2"></i>Email</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="notify_whatsapp" value="1" checked class="w-4 h-4 text-green-600 rounded focus:ring-green-500 cursor-pointer">
                                <span class="ml-3 text-gray-700"><i class="fas fa-whatsapp mr-2"></i>WhatsApp</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="border-t pt-6 flex gap-3 justify-end">
                    <a href="/early-warning" class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Buat Warning
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Load students via AJAX or populate from data
document.addEventListener('DOMContentLoaded', function() {
    // Fetch students from server
    fetch('/early-warning/get-students')
        .then(response => response.json())
        .then(data => {
            const selectElement = document.getElementById('student_id');
            data.forEach(student => {
                const option = document.createElement('option');
                option.value = student.id;
                option.textContent = `${student.username} (${student.email})`;
                selectElement.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading students:', error));
});
</script>

</body>
</html>
