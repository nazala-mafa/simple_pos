<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)" style="padding:1rem">
          <img src="<?= site_url() ?>assets/img/brand/blue.png" class="navbar-brand-img" style="max-height:3rem" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="<?= site_url() ?>">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
          </ul>
          <!-- Generator -->
          <hr class="my-3">
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Pengaturan</span>
          </h6>
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('products') ?>">
                <i class="ni ni-settings text-purple"></i>
                <span class="nav-link-text">Daftar Barang</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('products/suppliers') ?>">
                <i class="ni ni-delivery-fast text-gray"></i>
                <span class="nav-link-text">Pemasok</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('products/supplies') ?>">
                <i class="ni ni-box-2 text-orange"></i>
                <span class="nav-link-text">Persediaan</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('products/customers') ?>">
                <i class="ni ni-basket text-green"></i>
                <span class="nav-link-text">Pelanggan</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('products/orders') ?>">
                <i class="ni ni-cart text-blue"></i>
                <span class="nav-link-text">Penjualan</span>
              </a>
            </li>
          </ul>
          
          <!-- Auth -->
          <hr class="my-3">
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Autentikasi</span>
          </h6>
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="/profile">
                <i class="ni ni-single-02 text-blue"></i>
                <span class="nav-link-text">Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout">
                <i class="ni ni-user-run text-red"></i>
                <span class="nav-link-text">Logout</span>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav d-md-none" style="position:absolute;bottom:0;background:var(--blue)" id="collapseSide">
            <li class="nav-item">
              <a class="nav-link text-white" href="javascript:void(0)">
                <i class="ni ni-bold-left"></i>
                <span class="nav-link-text fw-bold">Collapse</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>