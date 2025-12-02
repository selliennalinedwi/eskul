<h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

<?php if(session()->getFlashdata('success')): ?>
<div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<h2 class="text-xl font-semibold mb-2">Pendaftaran Ekskul</h2>
<table class="min-w-full bg-white rounded shadow mb-8">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-2">ID</th>
            <th class="p-2">Nama Siswa</th>
            <th class="p-2">Ekskul</th>
            <th class="p-2">Status</th> 
            <th class="p-2">Validasi AI</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($registrations as $reg): ?>
        <tr class="border-t">
            <td class="p-2"><?= $reg['id'] ?></td>
            <td class="p-2"><?= $reg['student_name'] ?></td>
            <td class="p-2"><?= $reg['ekskul_title'] ?></td>
            <td class="p-2"><?= ucfirst($reg['status']) ?></td>
            <td class="p-2">
                <?php if($reg['validation_status']=='valid'): ?>
                    <span class="text-green-600 font-bold">VALID</span>
                <?php elseif($reg['validation_status']=='invalid'): ?>
                    <span class="text-red-600 font-bold">INVALID</span>
                    <br><small><?= esc($reg['validation_message']) ?></small>
                <?php else: ?>
                    <span class="text-gray-600">PENDING</span>
                <?php endif; ?>
            </td>
            <td class="p-2 space-x-2">
                <a href="/admin/approve/<?= $reg['id'] ?>" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Approve</a>
                <a href="/admin/reject/<?= $reg['id'] ?>" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Reject</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2 class="text-xl font-semibold mb-2">Grafik Statistik Peserta Ekskul</h2>
<canvas id="chartEkskul" class="bg-white p-4 rounded shadow"></canvas>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartEkskul').getContext('2d');
const data = {
    labels: <?= json_encode(array_column($stats,'title')) ?>,
    datasets: [{
        label: 'Jumlah Peserta',
        data: <?= json_encode(array_column($stats,'count')) ?>,
        backgroundColor: [
            'rgba(99,102,241,0.7)',
            'rgba(16,185,129,0.7)',
            'rgba(239,68,68,0.7)',
            'rgba(251,191,36,0.7)'
        ],
        borderColor: [
            'rgba(99,102,241,1)',
            'rgba(16,185,129,1)',
            'rgba(239,68,68,1)',
            'rgba(251,191,36,1)'
        ],
        borderWidth: 1
    }]
};

const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend:{ display:false },
            title:{ display:true, text:'Jumlah Peserta Ekskul per Kelas'}
        },
        scales:{
            y:{ beginAtZero:true, stepSize:1 }
        }
    }
};

new Chart(ctx, config);
</script>
