<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12">

      <?= view('template/message-block'); ?>
      
      <div class="card">
        <div class="card-header mb-0 d-flex justify-content-between">
          <h3 class="mb-0"><?= $title ?></h3>
          <a href="<?= site_url() ?>products/customers/new" class="btn btn-primary">Tambah Pelanggan</a>
        </div>
        <div class="card-body">

          <table id="table" class="display w-100">
            <thead>
              <tr>
                <th>No.</th>
                <th>Avatar</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Daftar Pada</th>
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
      ajax: '<?= site_url() ?>products/customers?json=1',
      columns: [
        { render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: function(dat){
            return `<img style="max-height:100px" src="<?= site_url() ?>uploads/imgs/<?=user_id()?>/customers/150/${dat.avatar}" alt="${dat.avatar}" />`
          },
          orderable: false },
        { data: "name" },
        { data: "phone" },
        { data: "address" },
        { data: "status" },
        { data: "created_at" },
        { data: function(data){
          return `
            <a href="<?= site_url() ?>products/customers/${data.id}" class="btn btn-success btn-sm btn-detail">detail</a>
            <a href="<?= site_url() ?>products/customers/edit/${data.id}" class="btn btn-warning btn-sm btn-edit">edit</a>
            <a href="<?= site_url() ?>products/customers/remove/${data.id}" data-name="${data.name}" class="btn btn-danger btn-sm btn-delete">delete</a>
          `;
        }}
      ],
      initComplete: function() {
        $('.btn-delete').click(function(){
          if( !confirm(`menghapus pelanggan ${$(this).data('name')}, lanjutkan?`) ){
            return false
          }
        })
      }
    })
  })
</script>
<?= $this->endSection() ?>