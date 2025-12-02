<h1 class="text-2xl font-bold mb-4"><?= esc($item['title']) ?></h1>
<p class="text-gray-700 mb-4"><?= esc($item['description']) ?></p>
<p class="mb-4">Kapasitas: <?= esc($item['capacity']) ?> peserta</p>

<?php if(session()->has('user_id')): ?>
<form method="post" action="/ekskul/register" class="bg-gray-50 p-4 rounded shadow">
    <input type="hidden" name="ekskul_id" value="<?= esc($item['id']) ?>">
    <div class="mb-4">
        <label class="block mb-1">Nama Anda:</label>
        <input type="text" name="student_name" class="w-full border p-2 rounded" required>
    </div>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Daftar Ekskul</button>
</form>
<?php else: ?>
<p class="text-red-600">Silakan <a href="/auth/login" class="underline">login</a> untuk mendaftar.</p>
<?php endif; ?>
