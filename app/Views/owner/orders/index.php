<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12">

      <?= view('template/message-block'); ?>
      
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h4 class="mb-0"><?= $title ?></h4>
          <a href="<?= site_url() ?>products/orders/new?sc=1" class="btn btn-primary">Tambah Penjualan</a>
        </div>
        <div class="card-body">
          <table id="table" class="display w-100">
            <thead>
              <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Dibayar</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>

    </div>
  </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  $(document).ready(function(){
    let datatable = $('#table').DataTable({
      ajax: '<?= site_url() ?>products/orders?json=1',
      columns: [
        { render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "created_at" },
        { data: "amount" },
        { data: "paid" },
        { data: "status" },
        { data: "note" },
        { orderable: false,
          data: function(data){
          return `
            <a href="<?= site_url() ?>products/orders/${data.id}" class="btn btn-success btn-sm">detail transaksi</a>
            <a href="<?= site_url() ?>products/orders/remove/${data.id}" class="btn btn-danger btn-sm delete-btn">hapus</a>
          `;
        }}
      ],
      drawCallback: function() {
        $('.delete-btn').click(function(){ if( !confirm('hapus data penjualan?') ) return false; })
      }
    })
  })
</script>
<?= $this->endSection() ?>
