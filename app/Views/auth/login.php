<div class="max-w-md mx-auto mt-20 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login Ekskul Online</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if(isset($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <?php foreach($errors as $error): ?>
                <p><?= esc($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="/auth/login" method="post" class="space-y-4">
        <?= csrf_field() ?>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="<?= old('email') ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Login</button>
    </form>

    <p class="text-center mt-4">Belum punya akun? <a href="/auth/register" class="text-indigo-600 underline">Daftar sekarang</a></p>
</div>
