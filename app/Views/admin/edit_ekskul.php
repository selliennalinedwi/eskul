<h2 class="text-xl font-bold mb-4">Edit Ekskul</h2>

<form action="/admin/ekskul/edit/<?= $ekskul['id'] ?>" method="post" class="bg-white p-4 rounded shadow space-y-4">
    <div>
        <label>Title</label>
        <input type="text" name="title" value="<?= esc($ekskul['title']) ?>" class="w-full border p-2 rounded" required>
    </div>
    <div>
        <label>Description</label>
        <textarea name="description" class="w-full border p-2 rounded" required><?= esc($ekskul['description']) ?></textarea>
    </div>
    <div>
        <label>Capacity</label>
        <input type="number" name="capacity" value="<?= esc($ekskul['capacity']) ?>" class="w-full border p-2 rounded" required>
    </div>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update Ekskul</button>
</form>
