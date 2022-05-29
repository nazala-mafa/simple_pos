<?= $this->extend('template/layout-blank') ?>

<?= $this->section('content') ?>
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h2 class="mb-2">Pembelian untuk pelanggan :</h2>
          <table>
            <tbody>
              <tr>
                <td>Nama</td>
                <td class="pl-4">: <?= $customer['name'] ?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td class="pl-4">: <?= $customer['address'] ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-8">

      <form action="<?= site_url() ?>products/orders/create" method="post" id='form'>

        <!-- Pelanggan -->
        <input type="hidden" name="customer_id" value="<?= $customer['id'] ?>">

        <!-- Form Input Produk -->
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Daftar Barang</h3>
          </div>
          <div class="card-body" id="form-body">
          </div>
        </div>

        <!-- Info Penjualan -->
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Info Penjualan</h3>
          </div>
          <div class="card-body">
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

        <input type="submit" id="add-orders" class="d-none">
      </form>

    </div>

    <!-- Side Pilih Barang -->

    <div class="col-12 col-md-4">

      <div class="card">
        <div class="card-header pb-0">
          <h3 class="mb-0">Pilih Barang</h3>
        </div>
        <div class="card-body">
          <input type="text" id="search-input" class="form-control mb-3" placeholder="cari produk">
          <div class="form-check ml-3">
            <input class="form-check-input" type="checkbox" value="1" id="ready-products">
            <label class="form-check-label" for="ready-products">
              hanya tampilkan barang tersedia
            </label>
          </div>
          <table id="productsTable" class="display w-100">
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

      <button class="btn btn-primary w-100" id="add-orders-btn">Pesan Sekarang</button>

    </div>

  </div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  $(document).ready(function(){
    //memindah submit form
    $('#add-orders-btn').click(function(){
      $('#add-orders').click()
    })

    //render tabel produk
    let datatable = $('#productsTable').DataTable({
      ajax    : '<?= site_url() ?>products?json=1',
      columns : [
        { data  : "name" },
        { data  : "quantity" },
        { orderable : false,
          data  : function(data) {
            let disabled = (data.quantity==0)? 'disabled': '';
            return `<button class="btn btn-primary btn-sm add-btn" data-data='${JSON.stringify(data)}' ${disabled}>tambahkan</button>`
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
        datatable.column(1).search('[^0]',true).draw(); //regex selain 0
      } else {
        datatable.column(1).search('').draw();
      }
    })

    //menambah input produk ke form
    function addBtnHandle(data) {
      $('#form-body').append( formInputHtml(data.name, data.id, data.sell_price, data.quantity) )
      $('.form-close-btn').on('click', function(){
        $(this).parent().parent().remove()
      })
      setKeyup()
    }

    //event pada form yang baru ditambahkan
      let amount = {}
      function setKeyup() {
        $('.prod-quantity').on('keyup', function(){
          let total = $(this).val() * $(this).parent().next().children()[1].value;
          $(this).parent().next().next().children()[1].value = total;
          amount[ $(this).data('id') ] = total;
          $('#amount').val( getAmount() )
          $('#paid').val( getAmount() )
        })
        $('.prod-price').on('keyup', function(){
          let total = $(this).val() * $(this).parent().prev().children()[1].value;
          $(this).parent().next().children()[1].value = total;
          amount[ $(this).data('id') ] = total;
          $('#amount').val( getAmount() )
          $('#paid').val( getAmount() )
        })
      }
      function formInputHtml(name, id, sell_price, quantity) {
        if( $(`#form-body #input-${id}`)[0] ) return false;
        return `
            <div class="border border-primary rounded p-2 mb-3" id="input-${id}">
              <div class="d-flex justify-content-between">
                <h3 class="mb-2">${name}</h3>
                <button class="btn btn-warning btn-sm text-white form-close-btn h-100">close</button>
              </div>
              <input type="hidden" name="order_detail[${id}][product_id]" value="${id}">
              <div class="row">
                <div class="col-4">
                  <label class="form-label" for="ku${id}">Kuantitas</label>
                  <input type="number" id="ku${id}" class="form-control prod-quantity" data-id="${id}" name="order_detail[${id}][quantity]" 
                  onKeyUp="if(this.value>${quantity}){this.value='${quantity}';}else if(this.value<0){this.value='0';}" required>
                </div>
                <div class="col-4">
                  <label class="form-label" for=hj"${id}">Harga Jual</label>
                  <input type="number" id=hj"${id}" class="form-control prod-price" name="order_detail[${id}][sell_price_unit]" value="${sell_price}" required>
                </div>
                <div class="col-4">
                  <label class="form-label" for="tot${id}">Total</label>
                  <input type="number" id="tot${id}" class="form-control" disabled>
                </div>
              </div>
              <div class="form-group">
                <textarea name="order_detail[${id}][note]" rows="2" class="form-control mt-3" placeholder="catatan(opsional)"></textarea>
              </div>
            </div>
        `
      }
      function getAmount() {
        return Object.values(amount).reduce((a, b) => a + b, 0)
      }
  })
</script>
<?= $this->endSection() ?>