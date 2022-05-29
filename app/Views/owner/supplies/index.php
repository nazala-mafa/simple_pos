<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12">

      <?= view('template/message-block'); ?>
      
      <div class="card">
        <div class="card-header mb-0 d-flex justify-content-between">
          <h3 class="mb-0"><?= $title ?></h3>
          <a href="<?= site_url() ?>products/supplies/new" class="btn btn-primary">Tambah Barang</a>
        </div>
        <div class="card-body">

          <table id="table" class="display w-100">
            <thead>
              <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Penerima</th>
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
      ajax: '<?= site_url() ?>products/supplies?json=1',
      columns: [
        { render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "created_at" },
        { data: "name" },
        { data: "status" },
        { data: "note" },
        { data: function(data){
          return `
            <a href="<?= site_url() ?>products/supplies/${data.id}" class="btn btn-success btn-sm btn-detail">detail</a>
          `;
        }}
      ],
      drawCallback: function() {
        
      }
    })
  })
</script>
<?= $this->endSection() ?>