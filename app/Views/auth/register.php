<div class="max-w-md mx-auto mt-20 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Register Ekskul Online</h2>

    <?php if(isset($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <?php foreach($errors as $error): ?>
                <p><?= esc($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="/auth/register" method="post" class="space-y-4">
        <?= csrf_field() ?>
        <div>
            <label class="block mb-1">Username</label>
            <input type="text" name="username" value="<?= old('username') ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="<?= old('email') ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirm" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Daftar</button>
    </form>

    <p class="text-center mt-4">Sudah punya akun? <a href="/auth/login" class="text-indigo-600 underline">Login di sini</a></p>
</div>
