<h1 class="text-4xl font-extrabold mb-8 text-gray-900 text-center">Daftar Ekskul</h1>

<form action="/ekskul/search" method="get" class="mb-10 flex justify-center gap-3 flex-wrap">
    <input type="text" name="q" placeholder="Cari ekskul..." 
           class="w-full sm:w-1/2 p-4 rounded-2xl border border-gray-300 bg-white/90 backdrop-blur-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
    <button type="submit" 
            class="bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-purple-500 hover:to-indigo-500 text-white px-8 py-4 rounded-2xl shadow-xl font-semibold transform hover:scale-105 transition">
        Cari
    </button>
</form>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-8 rounded-lg shadow-md">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php foreach($ekskuls as $eks): ?>
        <div class="relative bg-gradient-to-br from-indigo-100 to-purple-100 p-6 rounded-3xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition duration-300">
            
            <!-- Badge Populer -->
            <?php if($eks['is_popular'] ?? false): ?>
            <span class="absolute top-4 right-4 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Populer</span>
            <?php endif; ?>
            
            <!-- Icon (Heroicons) -->
            <div class="text-indigo-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12 12 0 010 6.844L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l-6.16 3.422a12 12 0 010-6.844L12 14z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold mb-3 text-gray-900"><?= esc($eks['title']) ?></h2>
            <p class="text-gray-700 mb-6"><?= esc(substr($eks['description'],0,120)) ?>...</p>
            <a href="/ekskul/<?= esc($eks['slug']) ?>" 
               class="inline-block bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-purple-500 hover:to-indigo-500 text-white px-6 py-3 rounded-full shadow-md font-semibold transition transform hover:scale-105">
               Lihat Detail
            </a>
        </div>
    <?php endforeach; ?>
</div>
