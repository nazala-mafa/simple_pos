<?= $this->extend('template/layout') ?>

<?= $this->section('head') ?>
<style>
  .card {
    position: absolute;
    width: 40%;
    right: 50%;
    transform: translate(50%, 40%);
    text-align: center;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-body">
      <?= view('template/message-block') ?>
      <form class="form-signin" action="<?= route_to('login') ?>" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Silahkan Masuk</h1>
        <label for="login" class="sr-only">Email atau Username</label>
        <input type="text" id="login" name="login" class="form-control" placeholder="Email address" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me" name="remember"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
      </form>
    </div>
  </div>
<?= $this->endSection() ?>