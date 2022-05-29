<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
<div class="container">
  
      <div class="card">
        <div class="card-header">
          <h3 class="mb-0"><?= $title ?></h3>
        </div>
        <div class="card-body">

          <table>
            <tbody>
              <tr>
                <td>Tanggal</td>
                <td class="pl-4">: <?= $data['created_at'] ?></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td class="pl-4">: <?= $data['name'] ?></td>
              </tr>
              <tr>
                <td>Telepon</td>
                <td class="pl-4">: <?= $data['phone'] ?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td class="pl-4">: <?= $data['address'] ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td class="pl-4">: <?= $data['status'] ?></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    
</div>
<?= $this->endSection() ?>