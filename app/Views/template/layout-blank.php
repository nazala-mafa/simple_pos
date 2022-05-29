<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title><?= isset($title)?$title:'Copywriting Generator' ?></title>
  <!-- Favicon -->
  <link rel="icon" href="/assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="/assets/template/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="/assets/template/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="/assets/css/argon.css?v=1.2.0" type="text/css">
  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" type="text/css">
  <!-- Common -->
  <link rel="stylesheet" href="/assets/css/common.css" type="text/css">
  
  <?= $this->renderSection('head') ?>
</head>

<body>

  <!-- Main content -->
  <div class="main-content" id="panel">

    <?php if( logged_in() ): ?>
      <?= $this->include('template/header') ?>
      <div class="container-fluid mt--6">
        <?= $this->renderSection('content') ?>
      </div>
    <?php else: ?>
        <?= $this->renderSection('content') ?>
    <?php endif; ?>


  </div>
  
  <?= $this->include('template/footer') ?>
  <!-- Core -->
  <script src="/assets/template/jquery/distt_/jquery.min.js"></script>
  <script src="/assets/template/bootstrap/distt_/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/template/js-cookie/js.cookie.js"></script>
  <script src="/assets/template/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="/assets/template/jquery-scroll-lock/distt_/jquery-scrollLock.min.js"></script>
  <!-- Argon JS -->
  <script src="/assets/js/argon.js?v=1.2.0"></script>
  <?= $this->renderSection('script') ?>
  <!-- Datatables -->
  <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/assets/js/script.js"></script>
</body>

</html>