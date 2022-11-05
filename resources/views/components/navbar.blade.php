
<nav id="navbar-main" class="navbar navbar-dark navbar-expand-lg" style="z-index: 2;">
  <div class="container">
    <a id="brand" class="navbar-brand fw-bold" href="#">Sinau Hurip</a>
    <button id="navbwar" <?= ($aktif == 'beranda') ? 'onclick="navbar()"' : ''  ?> class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item me-4">
          <a class="nav-link <?= ($aktif == 'beranda') ? 'active' : '' ?>" aria-current="page" href="/">Beranda</a>
        </li>
      

        @auth

        <li class="nav-item me-4">
          <a class="nav-link <?= ($aktif == 'laporan') ? 'active' : '' ?>" href="/laporan">Data Laporan</a>
        </li>
        <li class="nav-item me-4">
          <form action="/logout" method="post" class="mt-2">
            @csrf
            <button type="submit" class="nav-link" id="log">Logout</button>
          </form>
        </li>
        

        @else

        <li class="nav-item me-4">
          <a class="nav-link <?= ($aktif == 'hilang') ? 'active' : '' ?>" href="/hilang">Data Hilang</a>
        </li>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link <?= ($aktif == 'ditemukan') ? 'active' : '' ?>" href="/ditemukan">Data Ditemukan</a>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal" role="button">Login</a>
        </li>

        @endauth
        
      </ul>
    </div>
  </div>
</nav>
