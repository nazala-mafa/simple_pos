<?= $this->extend('template/layout-blank') ?>

<?= $this->section('content') ?>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h1 class="mb-2 text-center text-white"><?= $title ?></h1>
      <div class="row">

        <?php foreach( $customers as $c ): ?>
        <div class="col-6 col-sm-4 col-md-3">
          <div class="card">
            <div class="card-body">
              <img src="<?= site_url() ?>uploads/imgs/<?=user_id()?>/customers/300/<?= $c['avatar'] ?>" alt="" class="w-100">
              <table>
                <tbody>
                  <tr>
                    <td>Nama</td>
                    <td>: <?= $c['name'] ?></td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td>: <?= $c['address'] ?></td>
                  </tr>
                </tbody>
              </table>
              <a href="<?= site_url() ?>products/orders/new?c_id=<?= $c['id'] ?>" class="btn btn-primary w-100">Pilih</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</div>  
<?= $this->endSection() ?>