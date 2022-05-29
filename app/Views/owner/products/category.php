<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header mb-0 d-flex justify-content-between">
          <h3 class="mb-0">Pengaturan Barang</h3>
          <div>
            <button class="btn btn-primary" id="add-category">Tambah Kategory</button>
          </div>
        </div>
        <div class="card-body">
          
        <table id="table" class="display" style="width:100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kategory</th>
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
  // index
    let datatable = $('#table').DataTable( {
      "ajax": '<?= site_url() ?>products/category' + '?json=1',
      "columns": [
        { render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { "data": "name" },
        { "orderable": false,
          "render": function(_, __, row, ___){
          return `
          <btn class="btn btn-sm btn-primary btn-edit" data-dat='${JSON.stringify(row)}'>Edit</btn>
          <btn class="btn btn-sm btn-danger btn-delete" data-dat='${row.id}'>Hapus</btn>
          `
        } }
      ],
      "drawCallback": function() {
        $('.btn-edit').click(function(){
          let data = $(this).data('dat');
          updateCategory(data)
        })
        $('.btn-delete').click(function(){
          deleteCategory( $(this).data('dat') )
        })
      }
    } );
  // delete handle
    function deleteCategory(id) {
      $.ajax({
        url: '<?= site_url() ?>products/category/'+id,
        type: 'DELETE',
        success: function(res){
          if(res) datatable.ajax.reload();
        }
      })
    }
  // category create handle
    $('#add-category').click(()=>{
      Swal.fire({
        input: 'text',
        inputLabel: 'Tambah Kategori',
        inputPlaceholder: 'Masukkan nama kategori'
      }).then(data=>{
        if(!data.isConfirmed) return;
        $.ajax({
          url: '<?= site_url() ?>products/category',
          method: 'POST',
          data: {name:data.value},
          dataType: 'json',
          success: function(res){
            if( !res.status ) return;
            datatable.ajax.reload()
          }
        })
      })
    })
  // category edit handle
    function updateCategory(data) {
      Swal.fire({
        input       : 'text',
        inputLabel  : 'Edit Kategori',
        inputValue  : data.name,
        showCancelButton  : true
      }).then(inputData=>{
        if(!inputData.isConfirmed) return;
        $.ajax({
          url       : '<?= site_url() ?>products/category/'+data.id,
          method    : 'PUT',
          data      : JSON.stringify({ name: inputData.value }),
          dataType  : 'json',
          success: function(res){
            if( !res ) return;
            datatable.ajax.reload()
          }
        })
      })
    }
})
</script>
<?= $this->endSection() ?>
