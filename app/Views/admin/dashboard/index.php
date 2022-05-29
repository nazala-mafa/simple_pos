<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h2 class="text-center">Selamat Datang di Dashboard</h2>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card bg-default">
        <div class="card-body">
          <canvas id="myChart" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = render_grafik_penjualan_n_pembelian(<?= json_encode($pemasukan) ?>, <?= json_encode($pengeluaran) ?>, "Cashflow");

function render_grafik_penjualan_n_pembelian(penjualan, pembelian, title){
  return new Chart(ctx, {
    type: 'line',
    data: { 
        labels: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
        datasets: [{
            label: 'Penjualan :',
            data: penjualan,
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
            ],
            borderWidth: 1
        },
        {
            label: 'Pembelian :',
            data: pembelian,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        }]
    },
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