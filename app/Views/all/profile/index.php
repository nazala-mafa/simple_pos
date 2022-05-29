<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="mb-0"><?= $title ?></h3>
        </div>
        <div class="card-body">

          <?= view('template/message-block') ?>

          <form action="<?= site_url() ?>profile/update" method="post">
            <div class="form-group">
              <label for="username" class="form-label">Nama</label>
              <input class="form-control" type="text" name="username" id="username" required value="<?= user()->toArray()['username'] ?>">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control" required value="<?= user()->toArray()['email'] ?>">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="isi untuk mengubah password">
            </div>
            <div class="form-group">
              <label for="password_confirm">Password Confirm</label>
              <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="isi untuk mengubah password">
            </div>
            <input type="submit" value="Ubah" class="form-control btn btn-primary">
          </form>

        </div>
      </div>
    </div>
  </div>
</div>  
<?= $this->endSection() ?>