<h2 class="text-xl font-bold mb-4">Tambah Ekskul</h2>

<form action="/admin/ekskul/add" method="post" class="bg-white p-4 rounded shadow space-y-4">
    <div>
        <label>Title</label>
        <input type="text" name="title" class="w-full border p-2 rounded" required>
    </div>
    <div>
        <label>Description</label>
        <textarea name="description" class="w-full border p-2 rounded" required></textarea>
    </div>
    <div>
        <label>Capacity</label>
        <input type="number" name="capacity" class="w-full border p-2 rounded" required>
    </div>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Tambah Ekskul</button>
</form>
