<?= $this->extend('template/layout') ?>

<?= $this->section('head') ?>
<style>
  .card {
    position: absolute;
    width: 40%;
    right: 50%;
    transform: translate(50%, 20%);
    text-align: center;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-body">
      <?= view('template/message-block') ?>
      <form class="form-signin" action="<?= route_to('register') ?>" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Isi Biodata</h1>
        <div class="mb-3">
          <label for="email" class="sr-only">Email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
        </div>
        <div class="mb-3">
          <label for="username" class="sr-only">Email</label>
          <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="sr-only">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
          <label for="pass_confirm" class="sr-only">Password</label>
          <input type="password" id="pass_confirm" name="pass_confirm" class="form-control" placeholder="Password Confirmation" required>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
      </form>
    </div>
  </div>
<?= $this->endSection() ?>