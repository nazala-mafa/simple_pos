<?= $this->extend('template/layout-blank') ?>

<?= $this->section('content') ?>
  <form action="<?= site_url() ?>products/update/<?= $id ?>" method="post" enctype="multipart/form-data" id="main-form">
    <div class="row">

      <div class="col-12 col-md-8">
        <div class="card">

          <div class="card-header mb-0 d-flex justify-content-between">
            <h2 class="mb-0"><?= $title ?></h2>
          </div>

          <div class="card-body">
            
            <div class="text-center">
              <div class="bg-img-10 <?= (session('errors.image'))? 'is-invalid': '' ?>" id="input-image-btn" style="cursor:pointer;background-image:url('<?= site_url() ?>uploads/imgs/<?=user_id()?>/products/150/<?= $data['image'] ?>')"></div>
              <input type="file" name="image" id="input-image" class="d-none">
              <div class="text-danger"> <?= session('errors.image') ?> </div>
            </div>
            <div class="form-group">
              <label for="name" class="form-label">Nama Barang *</label>
              <input type="text" name="name" placeholder="masukkan nama barang" class="form-control <?= (session('errors.name'))? 'is-invalid': '' ?>" value="<?= $data['name'] ?>">
              <div class="invalid-feedback"> <?= session('errors.name') ?> </div>
            </div>
            <div class="form-group">
              <label for="status">Status Barang</label>
              <select name="status" class="form-control" id="status" value="<?= $data['status'] ?>">
                <option value="draft">Draft</option>
                <option value="ready stock">Ready Stock</option>
                <option value="sold out">Sold Out</option>
              </select>
            </div>
            <div class="form-group">
              <label for="buy_price" class="form-label">Harga Beli Barang *</label>
              <input type="number" id="buy_price" name="buy_price" placeholder="masukkan harga barang" class="form-control <?= (session('errors.buy_price'))? 'is-invalid': '' ?>" value="<?= $data['buy_price'] ?>">
              <div class="invalid-feedback"><?= session('errors.buy_price') ?></div>
            </div>
            <div class="form-group">
              <label for="sell_price" class="form-label">Harga Jual Barang *</label>
              <input type="number" id="sell_price" name="sell_price" placeholder="masukkan harga barang" class="form-control <?= (session('errors.sell_price'))? 'is-invalid': '' ?>" value="<?= $data['sell_price'] ?>">
              <div class="invalid-feedback"><?= session('errors.sell_price') ?></div>
            </div>
            <div class="form-group">
              <label for="quantity" class="form-label">Banyak Barang</label>
              <input type="number" id="quantity" name="quantity" placeholder="masukkan banyak barang" class="form-control" value="<?= $data['quantity'] ?>">
            </div>
            <input type="submit" class="form-control btn-primary">
          
          </div>
          
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Kategori</h3>
          </div>
          <div class="card-body">
            
            <div class="input-group input-group-sm mb-3">
              <input type="text" class="form-control" placeholder="tambah kategori">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="add-category-btn">Tambah</button>
              </div>
            </div>
            
            <table id="table" class="display" style="width:100%">
            </table>

          </div>
        </div>
      </div>
      
    </div>
  </form>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    let is_actived_warning = false
    $('#quantity, #sell_price, #buy_price').on('keydown', function(){
      if(!is_actived_warning) {
        is_actived_warning = true
        Swal.fire('Merubah Harga Jual atau Banyak Barang akan menyebabkan data analisa tidak valid!')
        return false;
      }
    })
  // handle upload image
    $('#input-image-btn').click(function(){
      $('#input-image').click()
    })
    $('#input-image').change(function(){
      var file = this.files[0];
      $('#input-image-btn').css('background-image',`url('${ URL.createObjectURL(file)} ')`)
    })
  // table category
    $(document).ready(function(){
      let datatable = $('#table').DataTable( {
        ajax: '<?= site_url() ?>products/category?json=1',
        columns: [
          { orderable: false,
            data: function(data){
              let checked = ( <?= isset($data['categories'])? json_encode($data['categories']): '[]' ?>.includes(data.id) )? 'checked': '';
              return `<div class="text-center">
                <input type="checkbox" value="${data.id}" name="categories_id[]" ${checked}>
              </div>`
          }},
          { data: "name" },
        ],
        dom: 't'
      } )

    // add category handle
      $('#add-category-btn').click(function(){
        let data = $(this).parent().prev().val()
        $.post('<?= site_url() ?>products/category', {name: data}, res=>{
          if(!res.status) return;
          datatable.ajax.reload()
        }, 'json')
      })
    })

  </script>
<?= $this->endSection() ?>