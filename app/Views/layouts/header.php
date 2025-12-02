<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Ekskul Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-gradient-to-b from-indigo-600 to-indigo-800 text-white shadow-lg fixed h-full z-30">
        <div class="p-6 border-b border-indigo-700">
            <h1 class="text-2xl font-bold">EkskulOnline</h1>
            <p class="text-indigo-200 text-sm">Sistem Terpadu</p>
        </div>

        <nav class="p-4">
            <ul class="space-y-2">
                <!-- Public/Student Navigation -->
                <li>
                    <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="/ekskul" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-star"></i>
                        <span>Daftar Ekskul</span>
                    </a>
                </li>

                <?php if(session()->get('isLoggedIn')): ?>
                    <!-- Student/Guru Navigation -->
                    <?php if(session()->get('role') === 'siswa' || session()->get('role') === 'guru'): ?>
                        <li>
                            <a href="/profile/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-user-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                        </li>
                    
                    <?php endif; ?>

                    <!-- Guru Navigation -->
                    <?php if(session()->get('role') === 'guru'): ?>
                        <li class="border-t border-indigo-700 pt-4 mt-4">
                            <span class="px-4 py-2 text-indigo-200 text-xs font-semibold uppercase tracking-wide">Menu Guru</span>
                        </li>
                        <li>
                            <a href="/guru/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Dashboard Guru</span>
                            </a>
                        </li>
                        <li>
                            <a href="/early-warning" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Early Warning</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Admin Navigation -->
                    <?php if(session()->get('role') === 'admin'): ?>
                        <li class="border-t border-indigo-700 pt-4 mt-4">
                            <span class="px-4 py-2 text-indigo-200 text-xs font-semibold uppercase tracking-wide">Menu Admin</span>
                        </li>
                        <li>
                            <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-chart-line"></i>
                                <span>Dashboard Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/ekskuls" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-star"></i>
                                <span>Kelola Ekskul</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-users"></i>
                                <span>Kelola Pengguna</span>
                            </a>
                        </li>
                        <li>
                            <a href="/early-warning" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Early Warning</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/reports" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-file-alt"></i>
                                <span>Laporan</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Logout -->
                    <li class="border-t border-indigo-700 pt-4 mt-4">
                        <div class="px-4 py-2">
                            <p class="text-indigo-200 text-sm">Halo, <span class="font-semibold"><?= session()->get('user_name') ?></span></p>
                        </div>
                    </li>
                    <li>
                        <a href="/auth/logout" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-600 transition">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Guest Navigation -->
                    <li>
                        <a href="/auth/login" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    <li>
                        <a href="/auth/register" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-user-plus"></i>
                            <span>Register</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64 overflow-auto">
        <!-- Mobile Menu Toggle -->
        <div class="lg:hidden bg-indigo-600 text-white p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">EkskulOnline</h1>
            <button id="mobile-menu-toggle" class="text-white focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Content Area -->
        <div class="p-8">
