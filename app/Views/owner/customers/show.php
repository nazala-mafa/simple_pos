<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12 col-md-4">
      <div class="card">
        <div class="card-body">
          <img src="<?= site_url() ?>assets/img/customers/<?= $customer['avatar'] ?>" class="w-100" alt="">
        </div>
      </div>
    </div>
    <div class="col-12 col-md-8">

      <?= view('template/message-block'); ?>
      
      <div class="card">
        <div class="card-header mb-0 d-flex justify-content-between">
          <h3 class="mb-0"><?= $title ?></h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <table>
                <tbody>
                  <tr>
                    <td>Nama</td>
                    <td>: <?= $customer['name'] ?></td>
                  </tr>
                  <tr>
                    <td>Telepon</td>
                    <td>: <?= $customer['phone'] ?></td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td>: <?= $customer['address'] ?></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>: <?= $customer['status'] ?></td>
                  </tr>
                  <tr>
                    <td>Daftar Pada</td>
                    <td>: <?= $customer['created_at'] ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Log Transakasi</h4>
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
      ajax: '<?= site_url() ?>products/customers/<?= $customer['id'] ?>?json=1',
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
            <a href="<?= site_url() ?>products/orders/${data.id}" class="btn btn-success btn-sm btn-detail">detail transaksi</a>
          `;
        }}
      ]
    })
  })
</script>
<?= $this->endSection() ?>