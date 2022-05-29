<?= $this->extend('template/layout') ?>

<?= $this->section('head') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header mb-0 d-flex justify-content-between">
          <h3 class="mb-0">Pengaturan Barang</h3>
          <div>
            <a href="<?= site_url() ?>products/new" class="btn btn-primary" id="add-product">Tambah Barang</a>
            <a href="<?= site_url() ?>products/category" class="btn btn-primary">Setting Kategori</a>
          </div>
        </div>
        <div class="card-body">
          
        <table id="table" class="display" style="width:100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>Gambar</th>
              <th>Kategori</th>
              <th>Kuantitas</th>
              <th>Status</th>
              <th>Harga Jual</th>
              <th>Terjual</th>
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
$(document).ready(function() {
    let datatable = $('#table').DataTable( {
      ajax: '<?= site_url('products') ?>?json=1',
      columns: [
        { render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { "data": "name" },
        { 
          "data": function(dat){
            return `<img style="max-width:100px" src="<?= site_url() ?>uploads/imgs/<?=user_id()?>/products/150/${dat.image}" alt="${dat.image}" />`
          },
          'orderable': false
        },
        { "data": function(dat){
          return dat.categories.join(', ')
        }},
        { "data": "quantity" },
        { "data": "status" },
        { "data": "sell_price" },
        { "data": "sold" },
        { "orderable": false,
          "render": function(_, __, row, ___){
          return `
          <a href="<?= site_url() ?>products/edit/${row.id}" class="btn btn-sm btn-primary">Edit</a>
          <button data-id="${row.id}" class="btn btn-sm btn-danger btn-delete">Hapus</btn>
          `
        } }
      ],
      drawCallback: function() {
        $('.btn-delete').click(function(){
          if( !confirm(`menghapus pelanggan ${$(this).data('name')}, lanjutkan?`) ) return false;
          deleteProduct( $(this).data('id') )
        })
      }
    } );

    function deleteProduct(id) {
      $.post('<?= site_url() ?>products/delete/'+id, {}, res=>{
        if(res) datatable.ajax.reload()
      }, 'json')
    }
})
</script>
<?= $this->endSection() ?>