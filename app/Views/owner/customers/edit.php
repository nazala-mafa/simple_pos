<?= $this->extend('template/layout-blank') ?>

<?= $this->section('content') ?>
  <?= $this->include('template/message-block') ?>
  <form action="<?= site_url() ?>products/customers/update/<?=$id?>" method="post" enctype="multipart/form-data" id="main-form">
    <input type="hidden" name="id" value="<?=$id?>">
    <div class="row">

      <div class="col-12 col-md-12">
        <div class="card">

          <div class="card-header mb-0 d-flex justify-content-between">
            <h2 class="mb-0"><?= $title ?></h2>
          </div>

          <div class="card-body">
            
            <div class="text-center">
              <div class="bg-img-10 <?= (session('errors.image'))? 'is-invalid': '' ?>" id="input-image-btn" style="cursor:pointer;background-image:url('<?= site_url("uploads/imgs/".user_id()."/customers/150/".$data['avatar']) ?>')"></div>
              <input type="file" name="image" id="input-image" class="d-none">
              <div class="text-danger"> <?= session('errors.image') ?> </div>
            </div>
            <div class="form-group">
              <label for="name" class="form-label">Nama</label>
              <input type="text" id="name" name="name" placeholder="masukkan nama barang" class="form-control <?= (session('errors.name'))? 'is-invalid': '' ?>" value="<?= $data['name'] ?>" required>
              <div class="invalid-feedback"> <?= session('errors.name') ?> </div>
            </div>
            <div class="form-group">
              <label for="phone" class="form-label">Nomor Telepon</label>
              <input type="number" id="phone" name="phone" placeholder="masukkan harga barang" class="form-control <?= (session('errors.phone'))? 'is-invalid': '' ?>" value="<?= $data['phone'] ?>" required>
              <div class="invalid-feedback"><?= session('errors.phone') ?></div>
            </div>
            <div class="form-group">
              <label for="address" class="form-label">Alamat</label>
              <input type="text" id="address" name="address" placeholder="masukkan harga barang" class="form-control <?= (session('errors.address'))? 'is-invalid': '' ?>" value="<?= $data['address'] ?>" required>
              <div class="invalid-feedback"><?= session('errors.address') ?></div>
            </div>
            <div class="form-group">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="aktif"   <?=$data['status']=='aktif'?'selected':'';?> >Aktif</option>
                <option value="banned"  <?=$data['status']=='banned'?'selected':'';?> >Banned</option>
              </select>
              <div class="invalid-feedback"><?= session('errors.quantity') ?></div>
            </div>
            <div id="supplies_input">
            </div>
            <input type="submit" class="form-control btn-primary">
          
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
</script>
<?= $this->endSection() ?>