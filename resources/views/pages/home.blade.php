@extends('layouts.main')
@section('container')




<div id="carouselExampleIndicators" class="carousel slide naikNavbar-def" data-bs-ride="true" style="z-index: 1;" nav="main">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/img/slide-1.jpg" alt="Slide 1" class="d-block w-100">
    </div>
    <div class="carousel-item">
      <img src="assets/img/slide-2.jpg" class="d-block w-100" alt="Slide 2">
    </div>
    <div class="carousel-item">
      <img src="assets/img/slide-3.jpg" class="d-block w-100" alt="Slide 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

@include('components.laporan')

<hr class="mt-5" color="#00cc44" size="7%" style="opacity: 1;border-top: none;">

<div class="container-fluid" style="background-image: linear-gradient(to bottom right, #009933, #00e64d);margin-top: -10px;">
  <div class="row justify-content-center py-5">

    <?php foreach ($dataTerbaru as $new) : ?>
    <div class="col-lg-3 col-10 mb-3">
    <div class="card">
      <div class="card-body" style="padding: 5px;">
        <?php

        if ($new['gambar'] !== null) {
          echo '<img src="assets/tmp/'.$new['gambar'].'.jpg" class="img-thumbnail me-3 w-100">';
        }else{
          echo '<img src="https://source.unsplash.com/500x500?human" class="img-thumbnail me-3 w-100">';
        }

        ?>
        <p class="px-2 mt-3">

          <?php if($new['jenis_laporan'] == '1' OR $new['jenis_laporan'] == '3') {
             ?>
          <span class="px-4 py-2" style="background-color:#008000;color:#ffff;border-radius: 5px;">Ditemukan</span>
        <?php }else{ ?>
          <span class="px-4 py-2" style="background-color:#ace600;color:#000000;border-radius: 5px;">Dicari</span>
        <?php } ?>
          <table class="table">
            <tbody>
              <tr>
                <td>{{ ($new['jenis_laporan'] == '1' OR $new['jenis_laporan'] == '3') ? 'Nama ODGJ' : 'Nama Tunawisma'}}</td>
                <td>:</td>
                <td>{{ $new['nama_pasien'] }}</td>
              </tr>
              <tr>
                <td>Gender</td>
                <td>:</td>
                <td>{{ ($new['jenis_kelamin'] == '1') ? 'Laki-laki' : 'Perempuan' }}</td>
              </tr>
              <tr>
                <td colspan="3"><button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#detailModal" data-nama="{{ $new['nama_pasien'] }}" data-jenis="{{ $new['jenis_laporan'] }}" data-pelapor="{{ $new['nama_pelapor'] }}" data-kelamin ="{{ $new['jenis_kelamin'] }}" data-alamat ="{{ $new['alamat'] }}" data-rincian ="{{ $new['rincian'] }}" data-telp ="{{ $new['telepon'] }}" data-gm="{{ $new['gambar'] }}">Selengkapnya</button></td>
              </tr>
            </tbody>
           </table>
        </p>
      </div>
    </div>
    </div>
    <?php endforeach; ?>
    </div>
  </div>

<hr class="mb-5" color="#00cc44" size="7%" style="opacity: 1;border-top: none; margin-top: 7px;">


<div class="container">
	<div class="row justify-content-center mb-4">
		<div class="col-lg-6 col-10 mb-5">
			<div class="card">
				<div class="card-body" style="box-shadow: 1px 5px 10px #888888;">
					<div class="ratio ratio-16x9">
				  <iframe id="youtubeLatest" src="https://www.youtube.com/embed/<?= $videoId ?>?rel=0" title="YouTube video" allowfullscreen></iframe>
				</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-10 mb-5">
			<div class="card" style="box-shadow: 1px 5px 10px #888888;">
			  <div class="card-body">
			  	<div class="ratio ratio-16x9">
				  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.766690757322!2d110.84268181384641!3d-6.798215068375748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70c58094d2669b%3A0x8eb67853864717ad!2sMas%20Adi%20SINAU%20HURIP!5e0!3m2!1sid!2sid!4v1666499670777!5m2!1sid!2sid" title="YouTube video" allowfullscreen></iframe>
				  </div>
			  </div>
			</div>
		</div>
	</div>
</div> 

<script type="text/javascript">
  $('.nav-link').addClass('text-shadow');
  $('#brand').addClass('text-shadow');

  $(document).ready(function(){
      $(window).scroll(function() {
        if ($(document).scrollTop() > 90) { 
              document.getElementById('navbar-main').classList.add('bg-ijo'); 
              document.getElementById('navbar-main').classList.add('fixed-top'); 
        } else {
              document.getElementById('navbar-main').classList.remove('bg-ijo');
              document.getElementById('navbar-main').classList.remove('fixed-top'); 

        }
        
      });
    });

  function navbar() {
      var element = document.querySelector('[nav="main"]');
      var nav = document.getElementById("navbar-main");
      var lap = document.getElementById("lapwor");
      element.classList.toggle("naikNavbar");
      element.classList.toggle("naikNavbar-def");
      nav.classList.toggle("bg-trans");
      lap.classList.toggle("naikJuga");
  }
</script>

@include('components.footer')
@endsection('container')

