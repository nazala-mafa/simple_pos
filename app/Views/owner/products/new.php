<?= $this->extend('template/layout-blank') ?>

<?= $this->section('content') ?>
  <form action="<?= site_url() ?>products/create" method="post" enctype="multipart/form-data" id="main-form">
    <div class="row">

      <div class="col-12 col-md-8">
        <div class="card">

          <div class="card-header mb-0 d-flex justify-content-between">
            <h2 class="mb-0"><?= $title ?></h2>
          </div>

          <div class="card-body">
            
            <div class="text-center">
              <div class="bg-img-10 <?= (session('errors.image'))? 'is-invalid': '' ?>" id="input-image-btn" style="cursor:pointer;background-image:url(<?= site_url() ?>assets/img/default-image.jpg)"></div>
              <input type="file" name="image" id="input-image" class="d-none">
              <div class="text-danger"> <?= session('errors.image') ?> </div>
            </div>
            <div class="form-group">
              <label for="name" class="form-label">Nama Barang *</label>
              <input type="text" id="name" name="name" placeholder="masukkan nama barang" class="form-control <?= (session('errors.name'))? 'is-invalid': '' ?>" value="<?= old('name') ?>">
              <div class="invalid-feedback"> <?= session('errors.name') ?> </div>
            </div>
            <div class="form-group">
              <label for="buy_price" class="form-label">Harga Beli Barang *</label>
              <input type="number" id="buy_price" name="buy_price" placeholder="masukkan harga barang" class="form-control <?= (session('errors.buy_price'))? 'is-invalid': '' ?>" value="<?= old('buy_price') ?>">
              <div class="invalid-feedback"><?= session('errors.buy_price') ?></div>
            </div>
            <div class="form-group">
              <label for="sell_price" class="form-label">Harga Jual Barang *</label>
              <input type="number" id="sell_price" name="sell_price" placeholder="masukkan harga barang" class="form-control <?= (session('errors.sell_price'))? 'is-invalid': '' ?>" value="<?= old('sell_price') ?>">
              <div class="invalid-feedback"><?= session('errors.sell_price') ?></div>
            </div>
            <div class="form-group">
              <label for="quantity" class="form-label">Kuantitas</label>
              <input type="number" id="quantity" name="quantity" placeholder="masukkan harga barang" class="form-control <?= (session('errors.quantity'))? 'is-invalid': '' ?>" value="<?= old('quantity') ?>">
              <div class="invalid-feedback"><?= session('errors.quantity') ?></div>
            </div>
            <div id="supplies_input">
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
            return `<div class="text-center"><input type="checkbox" value="${data.id}" name="categories_id[]"></div>`
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
  
  $('#quantity').on('keyup', function(){
    if( $('#supplies_input').children().length == 0 ) {
      $('#supplies_input').append(`
        <div class="form-group">
          <select name="supplier_id" id="supplier" class="form-control">
            <?php foreach($suppliers as $s): ?>
            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="row mb-3">
          <div class="col-4">
            <label for="amount" class="form-label">Total</label>
            <input type="number" name="amount" id="amount" class="form-control">
          </div>
          <div class="col-4">
            <label for="paid" class="form-label">Dibayar</label>
            <input type="number" name="paid" id="paid" class="form-control">
          </div>
          <div class="col-4">
            <label for="payment_status" class="form-label">Status</label>
            <select name="payment_status" id="payment_status" class="form-control">
              <option value="lunas">Lunas</option>
              <option value="bayar sebagian">Bayar Sebagian</option>
              <option value="uang muka">Uang Muka(DP)</option>
              <option value="belum bayar">Belum Bayar</option>
            </select>
          </div>
          <div class="col-12 mt-3">
            <label for="note" class="form-label">Catatan(opsional)</label>
            <textarea name="note" id="note" rows="4" class="form-control"></textarea>
          </div>
        </div>
      `)
      $('#buy_price').on('keyup', function(){
        $('#amount').val( parseInt($('#buy_price').val()) * parseInt($('#quantity').val()) )
        $('#paid').val( parseInt($('#buy_price').val()) * parseInt($('#quantity').val()) )
      })
    }
    $('#amount').val( parseInt($('#buy_price').val()) * parseInt($('#quantity').val()) )
    $('#paid').val( parseInt($('#buy_price').val()) * parseInt($('#quantity').val()) )
  })
</script>
<?= $this->endSection() ?>