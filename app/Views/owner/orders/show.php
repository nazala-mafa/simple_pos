<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
  <div class="row">
    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-header mb-0">
          <h3 class="mb-0"><?= $title ?></h3>
        </div>
        <div class="card-body">

          <table id="table" class="display w-100">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Kuantitas</th>
                <th>Harga Jual</th>
                <th>Catatan</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1;foreach( $order_detail as $o ): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $o['product_name'] ?></td>
                <td><?= $o['quantity'] ?></td>
                <td><?= number_format($o['price_unit']) ?></td>
                <td>
                  <button class="btn btn-primary btn-sm note-btn" data-note="<?= $o['note']? $s['note']: '-' ?>" data-product_name="<?= $o['product_name'] ?>">show</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card">
        <div class="card-header pb-0">
          <h4 class="mb-0">Status Barang Masuk</h4>
        </div>
        <div class="card-body pt-0">
          <form action="<?=site_url('/products/orders/update/'.$id)?>" method="post">
          <table>
            <input type="hidden" name="id" value="<?=$id?>" >
            <tbody>
              <tr>
                <td>Penerima</td>
                <td class="pl-3">: <?= $pelanggan['customer_name'] ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td class="pl-3">
                  <div class="input-group input-group-sm">
                    <span class="mr-1">:</span>
                    <select class="form-control " id="status" name="status">
                        <option <?=($pelanggan['status']=="lunas"?'selected':'')?> value="lunas">Lunas</option>
                        <option <?=($pelanggan['status']=="bayar sebagian"?'selected':'')?> value="bayar sebagian">Bayar Sebagian</option>
                        <option <?=($pelanggan['status']=="uang muka"?'selected':'')?> value="uang muka">Uang Muka(DP)</option>
                        <option <?=($pelanggan['status']=="belum bayar"?'selected':'')?> value="belum bayar">Belum Bayar</option>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Total</td>
                <td class="pl-3">
                  <div class="input-group input-group-sm">
                    <span class="mr-1">:</span>
                    <span class="mr-1 text-sm">Rp.</span>
                    <input type="text" class="form-control" value="<?= number_format((int)$pelanggan['amount'],0,'.','.') ?>" name="amount" readonly>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Dibayar</td>
                <td class="pl-3">
                  <div class="input-group input-group-sm">
                    <span class="mr-1">:</span>
                    <span class="mr-1 text-sm">Rp.</span>
                    <input type="text" class="form-control numeric" value="<?= number_format((int)$pelanggan['paid'],0,'.','.') ?>" name="paid">
                  </div>
                </td>
              </tr>
              <tr>
                <td>Catatan</td>
                <td class="pl-3">
                  <div class="input-group input-group-sm">
                    <span class="mr-1">:</span>
                    <textarea name="note" rows=4 class="text-sm form-control"><?= $pelanggan['note'] ?></textarea>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Diterima pada</td>
                <td class="pl-3">: <?= $pelanggan['created_at'] ?></td>
              </tr>
              <tr>
                <td>Diupdate pada</td>
                <td class="pl-3">: <?= ($pelanggan['updated_at'] == $pelanggan['created_at'])? '-tidak terjadi perubahan-': $pelanggan['updated_at'] ?></td>
              </tr>
            </tbody>
          </table>
          <button class="btn btn-primary btn-sm btn-block mt-3" type="submit">Klik untuk mengubah data</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  $(document).ready(function(){
    let datatable = $('#table').DataTable()
  })
  $('.note-btn').click(function(){
    Swal.fire({
      'title' : 'Catatan ' + $(this).data('product_name'),
      'html'  : $(this).data('note')
    })
  })
</script>
<?= $this->endSection() ?>