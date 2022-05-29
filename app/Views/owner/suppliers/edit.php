<?= $this->extend('template/layout-blank') ?>

<?= $this->section('content') ?>
  <?= $this->include('template/message-block') ?>
  <form action="<?= site_url() ?>products/suppliers/update/<?=$id?>" method="post">

    <input type="hidden" name="id" value="<?=$id?>">

    <div class="card">

      <div class="card-header mb-0 d-flex justify-content-between">
        <h2 class="mb-0"><?= $title ?></h2>
      </div>

      <div class="card-body">
        
        <div class="form-group">
          <label for="name" class="form-label">Nama Pemasok</label>
          <input type="text" id="name" name="name" class="form-control <?= (session('errors.name'))? 'is-invalid': '' ?>" value="<?= $data['name'] ?>" required>
          <div class="invalid-feedback"> <?= session('errors.name') ?> </div>
        </div>
        <div class="form-group">
          <label for="phone" class="form-label">Nomor Telepon</label>
          <input type="number" id="phone" name="phone" class="form-control <?= (session('errors.phone'))? 'is-invalid': '' ?>" value="<?= $data['phone'] ?>" required>
          <div class="invalid-feedback"><?= session('errors.phone') ?></div>
        </div>
        <div class="form-group">
          <label for="address" class="form-label">Alamat</label>
          <input type="text" id="address" name="address" class="form-control <?= (session('errors.address'))? 'is-invalid': '' ?>" value="<?= $data['address'] ?>" required>
          <div class="invalid-feedback"><?= session('errors.address') ?></div>
        </div>
        <div class="form-group">
          <label for="status" class="form-label">Status</label>
          <select name="status" id="status" class="form-control">
            <option value="aktif" <?= $data['status']=="aktif"?"selected":""; ?> >Aktif</option>
            <option value="banned" <?= $data['status']=="banned"?"selected":""; ?> >Banned</option>
          </select>
          <div class="invalid-feedback"><?= session('errors.quantity') ?></div>
        </div>
        <input type="submit" class="form-control btn-primary">
      
      </div>
      
    </div>
  </form>
<?= $this->endSection() ?>
