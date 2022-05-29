<?= $this->extend('template/layout-blank') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12 col-md-8">

      <form action="<?= site_url() ?>products/supplies/create" method="post" id='form'>

        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Daftar Barang</h3>
          </div>
          <div class="card-body" id="form-body">
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Info Pasokan</h3>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <select name="supplier_id" id="supplier" class="form-control">
                <?php foreach( $suppliers as $s ): ?>
                <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="row mb-3">
              <div class="col-4">
                <label for="status" class="form-label">Status Pasokan</label>
                <select class="form-control" id="status" name="status">
                  <option value="lunas">Lunas</option>
                  <option value="bayar sebagian">Bayar Sebagian</option>
                  <option value="uang muka">Uang Muka(DP)</option>
                  <option value="belum bayar">Belum Bayar</option>
                </select>
              </div>
              <div class="col-4">
                <label for="amount" class="form-label">Total Harga</label>
                <input class="form-control" type="number" name="amount" id="amount" required>
              </div>
              <div class="col-4">
                <label for="paid" class="form-label">Dibayar</label>
                <input class="form-control" type="number" name="paid" id="paid" required>
              </div>
            </div>
            <div class="form-group">
              <label for="note" class="form-label">Catatan Pasokan(opsional)</label>
              <textarea id="note" name="note" class="form-control" rows="4"></textarea>
            </div>
          </div>
        </div>
        
        <input type="submit" id="add-supplies" class="d-none">
      </form>
    </div>
  
    <div class="col-12 col-md-4">
      <button class="btn btn-info w-100 mb-3" id="x-add-supplies">Tambah Barang Masuk</button>
      <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h4 class="mb-0">Pilih Barang</h4>
          <div class="input-group input-group-sm" style="width:40%">
            <input type="text" class="form-control" id="search-input" placeholder="cari barang">
          </div>
        </div>
        <div class="card-body">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="ready-products">
            <label class="form-check-label" for="ready-products">
              hanya tampilkan barang kosong
            </label>
          </div>
          <table id="table" class="display w-100">
            <thead>
              <tr>
                <td>Nama Barang</td>
                <td>Tersedia</td>
                <td>Aksi</td>
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
      ajax    : '<?= site_url() ?>products?json=1',
      columns : [
        { data  : "name" },
        { data  : "quantity" },
        { orderable : false,
          data  : function(data) {
            return `<button class="btn btn-primary btn-sm add-btn" data-data='${JSON.stringify(data)}'>tambahkan</button>`
        }}
      ],
      initComplete: function(){
        $('.add-btn').click(function(){
          addBtnHandle( $(this).data('data') )
        })
      },
      scrollY: "350px",
      paging: false,
      dom: 't<"bottom"i>'
    })

    //pencarian tabel
    $('#search-input').on('keyup', function(){
      datatable.search($(this).val()).draw();
    });

    //hanya tampilkan produk yang tersedia
    $('#ready-products').on('change', function() {
      if( this.checked ) {
        datatable.column(1).search('^[0]',true).draw(); //regex selain 0
      } else {
        datatable.column(1).search('').draw();
      }
    })

    //menambah input produk ke form
    function addBtnHandle(data) {
      $('#form-body').append( formInputHtml(data.name, data.id, data.buy_price) )
      $('.form-close-btn').on('click', function(){
        $(this).parent().parent().remove()
      })
      setKeyup()
    }
  })

  //memindah submit form
  $('#x-add-supplies').click(function(){
    $('#add-supplies').click()
  })

  //event pada form yang baru ditambahkan
  let amount = {}
  function setKeyup() {
    $('.prod-quantity').on('keyup', function(){
      let total = $(this).val() * $(this).parent().next().children()[0].value;
      amount[ $(this).data('id') ] = total;
      $('#amount').val( getAmount() )
    })
    $('.prod-price').on('keyup', function(){
      let total = $(this).val() * $(this).parent().prev().children()[0].value;
      amount[ $(this).data('id') ] = total;
      $('#amount').val( getAmount() )
      $('#paid').val( getAmount() )
    })
  }
  function formInputHtml(name, id, buy_price) {
    return `
        <div class="border border-primary rounded p-2 mb-3">
          <div class="d-flex justify-content-between">
            <h3 class="mb-2">${name}</h3>
            <button class="btn btn-warning btn-sm text-white form-close-btn h-100">close</button>
          </div>
          <input type="hidden" name="supply_detail[${id}][product_id]" value="${id}">
          <div class="row">
            <div class="col-4">
              <input type="number" class="form-control prod-quantity" data-id="${id}" name="supply_detail[${id}][quantity]" placeholder="kuantitas" required>
            </div>
            <div class="col-4">
              <input type="number" class="form-control prod-price" data-id="${id}" name="supply_detail[${id}][buy_price_unit]" placeholder="harga beli" value="${buy_price}" required>
            </div>
            <div class="col-4">
              <input type="number" class="form-control" name="supply_detail[${id}][sell_price_unit]" placeholder="harga jual" required>
            </div>
          </div>
          <div class="form-group">
            <textarea name="supply_detail[${id}][note]" rows="2" class="form-control mt-3" placeholder="catatan(opsional)"></textarea>
          </div>
        </div>
    `
  }
  function getAmount() {
    return Object.values(amount).reduce((a, b) => a + b, 0)
  }
</script>
<?= $this->endSection() ?>

<?php 