<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h2 class="text-center">Selamat Datang di Dashboard asd</h2>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">

      <div class="card bg-default">
        <div class="card-body">
          <canvas id="pembelian" height="200"></canvas>
          <p class="text-gray">Total Pemasukan: <?= $data['total_pembelian'] ?></p>
        </div>
      </div>

      <div class="card bg-default">
        <div class="card-body">
          <canvas id="pemasukan_berdasarkan_items" height="200"></canvas>
          <p class="text-gray">Total Pemasukan: <?= $data['pemasukan_berdasarkan_items']['total'] ?></p>
        </div>
      </div>
      
    </div>
    <div class="col-12 col-md-6">

      <div class="card bg-default">
        <div class="card-body">
          <canvas id="penjualan" height="200"></canvas>
          <p class="text-gray">Total Pemasukan: <?= $data['total_pemasukan'] ?></p>
        </div>
      </div>         

      <div class="card bg-default">
        <div class="card-body">
          <canvas id="pemasukan_berdasarkan_kategori" height="200"></canvas>
          <p class="text-gray">Total Pemasukan: <?= $data['pemasukan_berdasarkan_kategori']['total'] ?></p>
        </div>
      </div>

    </div>
  </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<script>
const bulan = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ];
const tanggal = [];
for (let i = 0; i < <?= json_encode($data['pemasukan']) ?>.length; i++) {
  tanggal.push(i+1)
}
const date = new Date();

//Penjualan
const Penjualan = render_grafik({
  title       : "Penjualan Bulan "+bulan[date.getMonth()]+" (terbayar)",
  context     : document.getElementById('penjualan').getContext('2d'),
  datasets    : [
    { borderWidth:1, label: 'Penjualan :', data: <?= json_encode($data['pemasukan']) ?>, backgroundColor: [ 'rgba(54, 162, 235, 0.2)', ], borderColor: [ 'rgba(54, 162, 235, 1)', ] },
  ],
  labels      : tanggal,
  type        : 'line'
});

const Penjualan_berdasar_items = render_grafik({
  title       : "Penjualan Bulan "+bulan[date.getMonth()]+" Berdasarkan Produk",
  context     : document.getElementById('pemasukan_berdasarkan_items').getContext('2d'),
  datasets    : [
    { borderWidth:1, label: 'Produk', data: <?= json_encode($data['pemasukan_berdasarkan_items']['totals']) ?>, backgroundColor: [ 'rgba(54, 162, 235, 1)' ] },
  ],
  labels      : <?= json_encode($data['pemasukan_berdasarkan_items']['names']) ?>,
  type        : 'bar'
});

const Penjualan_berdasar_kategori_items = render_grafik({
  title       : "Penjualan Bulan "+bulan[date.getMonth()]+" Berdasarkan Kategori Produk",
  context     : document.getElementById('pemasukan_berdasarkan_kategori').getContext('2d'),
  datasets    : [
    { borderWidth:1, label: 'Produk', data: <?= json_encode($data['pemasukan_berdasarkan_kategori']['totals']) ?>, backgroundColor: [ 'rgba(54, 162, 235, 1)' ] },
  ],
  labels      : <?= json_encode($data['pemasukan_berdasarkan_kategori']['names']) ?>,
  type        : 'bar'
});



// Pembelian
const Pembelian = render_grafik({
  title       : "Pembelian Bulan "+bulan[date.getMonth()],
  context     : document.getElementById('pembelian').getContext('2d'),
  datasets    : [
    { borderWidth:1, label: 'Pembelian :', data: <?= json_encode($data['pengeluaran']) ?>, backgroundColor: [ 'rgba(54, 162, 235, 0.2)', ], borderColor: [ 'rgba(54, 162, 235, 1)', ] },
  ],
  labels      : tanggal,
  type        : 'line'
});

function render_grafik({title, context, labels, datasets, type}){
  return new Chart(context, {
    type: type,
    data: { labels, datasets },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: title
          }
        }
    }
  });
}

</script>
<?= $this->endSection() ?>