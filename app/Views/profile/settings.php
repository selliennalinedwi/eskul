<?php
$user_id = session()->get('user_id');
$user_name = session()->get('user_name');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Notifikasi - Ekskul Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-bell text-blue-600 mr-2"></i>Pengaturan Notifikasi
                </h1>
                <p class="text-gray-500 mt-2">Atur nomor WhatsApp dan email untuk menerima notifikasi</p>
            </div>

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

            <form action="/profile/update-notification-settings" method="POST" class="space-y-6">
                <?= csrf_field() ?>

                <!-- WhatsApp Section -->
                <div class="border-l-4 border-green-500 bg-green-50 p-6 rounded-lg">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fab fa-whatsapp text-green-600 mr-2"></i>WhatsApp
                    </h2>
                    
                    <div>
                        <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor WhatsApp (Format: 62XXXXXXXXXX)
                        </label>
                        <div class="flex gap-2">
                            <input type="text" 
                                   name="phone_number" 
                                   id="phone_number" 
                                   value="<?= esc($user['phone_number'] ?? '') ?>"
                                   placeholder="Contoh: 6285123456789"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   pattern="^62[0-9]{9,12}$">
                            <button type="button" 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition"
                                    onclick="testWhatsApp()">
                                <i class="fas fa-paper-plane mr-2"></i>Test
                            </button>
                        </div>
                        <small class="text-gray-600 mt-2 block">
                            <i class="fas fa-info-circle mr-1"></i>Mulai dengan kode negara 62, contoh: 6285123456789
                        </small>
                    </div>

                    <div class="mt-4 p-4 bg-white rounded border border-green-200">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Notifikasi WhatsApp akan dikirim ke nomor ini
                        </p>
                        <?php if(!empty($user['phone_number'])): ?>
                        <p class="text-sm text-green-600 mt-2">
                            ✓ Nomor terdaftar: <strong><?= esc($user['phone_number']) ?></strong>
                        </p>
                        <?php else: ?>
                        <p class="text-sm text-orange-600 mt-2">
                            ⚠ Belum ada nomor WhatsApp. Notifikasi tidak akan terkirim via WhatsApp.
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Email Section -->
                <div class="border-l-4 border-blue-500 bg-blue-50 p-6 rounded-lg">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-envelope text-blue-600 mr-2"></i>Email
                    </h2>
                    
                    <div>
                        <label for="notification_email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Notifikasi (Opsional)
                        </label>
                        <div class="flex gap-2">
                            <input type="email" 
                                   name="notification_email" 
                                   id="notification_email" 
                                   value="<?= esc($user['notification_email'] ?? $user['email']) ?>"
                                   placeholder="Email untuk notifikasi"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="button" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                                    onclick="testEmail()">
                                <i class="fas fa-paper-plane mr-2"></i>Test
                            </button>
                        </div>
                        <small class="text-gray-600 mt-2 block">
                            <i class="fas fa-info-circle mr-1"></i>Biarkan kosong untuk menggunakan email akun utama: <?= esc($user['email']) ?>
                        </small>
                    </div>

                    <div class="mt-4 p-4 bg-white rounded border border-blue-200">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-check text-blue-600 mr-2"></i>
                            Notifikasi Email akan dikirim ke:
                        </p>
                        <p class="text-sm font-semibold text-blue-700 mt-2">
                            📧 <?= esc($user['notification_email'] ?? $user['email']) ?>
                        </p>
                    </div>
                </div>

                <!-- Notification Preferences -->
                <div class="border-l-4 border-purple-500 bg-purple-50 p-6 rounded-lg">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-sliders-h text-purple-600 mr-2"></i>Preferensi Notifikasi
                    </h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-3 bg-white rounded border border-purple-200 cursor-pointer hover:bg-purple-100 transition">
                            <input type="checkbox" name="notify_whatsapp" value="1" checked class="w-4 h-4 text-green-600 rounded">
                            <span class="ml-3 text-gray-700">
                                <i class="fab fa-whatsapp text-green-600 mr-2"></i>Terima notifikasi via WhatsApp
                            </span>
                        </label>

                        <label class="flex items-center p-3 bg-white rounded border border-purple-200 cursor-pointer hover:bg-purple-100 transition">
                            <input type="checkbox" name="notify_email" value="1" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="ml-3 text-gray-700">
                                <i class="fas fa-envelope text-blue-600 mr-2"></i>Terima notifikasi via Email
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t pt-6 flex gap-3 justify-end">
                    <a href="/" class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function testWhatsApp() {
    const phone = document.getElementById('phone_number').value;
    if (!phone) {
        alert('Silakan masukkan nomor WhatsApp terlebih dahulu');
        return;
    }
    
    fetch('/profile/test-whatsapp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ phone_number: phone })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✓ Pesan test WhatsApp sedang dikirim ke ' + phone);
        } else {
            alert('✗ Gagal mengirim pesan test: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim test message');
    });
}

function testEmail() {
    const email = document.getElementById('notification_email').value;
    if (!email) {
        alert('Email tidak valid');
        return;
    }
    
    fetch('/profile/test-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✓ Email test sedang dikirim ke ' + email);
        } else {
            alert('✗ Gagal mengirim email test: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim test email');
    });
}
</script>

</body>
</html>
