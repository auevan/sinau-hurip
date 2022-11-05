@if (Session::has('success')) 

<canvas id="myCanvas" class="d-none"></canvas>
<div id="titipBarcode" class="d-none">
	{!! QrCode::size(150)->generate(Request::url().Session::get('success')); !!}
</div>

<script type="text/javascript">
	fills = {}
	localStorage.removeItem(OLDFILLS)
  localStorage.removeItem(OLDGAMBAR)
</script>

<script type="module">
    function download(file, text) {
      
        //creating an invisible element
        var element = document.createElement('a');
        element.setAttribute('href',
        'data:text/plain;charset=utf-8, '
        + encodeURIComponent(text));
        element.setAttribute('download', file);
      
        // Above code is equivalent to
        // <a href="path of file" download="file name">
      
        document.body.appendChild(element);
      
        //onClick property
        element.click();
      
        document.body.removeChild(element);
      }

    // Import Canvg from the Skypack CDN
    import { Canvg } from 'https://cdn.skypack.dev/canvg';

    // Set an initialization variable to null
    let v = null;

    // Create a function that fires when the
    // web browser loads the file

      const canvas = document.querySelector('canvas');
      const ctx = canvas.getContext('2d');

      // Read the SVG string using the fromString method
      // of Canvg
      const sv = document.querySelector('#titipBarcode svg').outerHTML
      v = Canvg.fromString(ctx, sv);

      // Start drawing the SVG on the canvas
      v.start();

      // Convert the Canvas to an image
      var img = canvas.toDataURL("img/png");


    Swal.fire({
      imageUrl: img,
      title: 'Laporan Dibuat!',
      text: 'Simpan barcode dan laporan dengan mengizinkan akses cookie anda, konfirmasikan sekarang!', 
      confirmButtonText:'Tutup dan Konfirmasi',
      footer: '<i>Laporan anda akan segera periksa oleh admin!</i>',
      backrop : true,
      allowOutsideClick : false
    }).then((result) => {
      function download(){
        axios({
          url:img,
          method:'GET',
          responseType: 'blob'
      })
      .then((response) => {
          const url = window.URL
          .createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', 'image.jpg');
              document.body.appendChild(link);
              link.click();
          cookieBaru('<?=  Session::get('id_laporan') ?>')
      })
      }

      download()
    })



  </script>
@elseif (Session::has('failed'))
<script type="text/javascript">
	Swal.fire(
  'Gagal!',
  '<?=  Session::get('failed') ?>',
  'error'
)
</script>
@endif


@if (Session::has('ubah'))
<script type="text/javascript">
	Swal.fire(
  'Berhasil',
  '<?=  Session::get('ubah') ?>',
  'success'
)
</script>
@endif


<div class="container mb-5" <?= ($aktif == 'beranda') ? 'id="lapwor"'  : '' ?>>
	<div class="row justify-content-center mb-3" id="pencarian">
		<div class="col-10">
	<div class="accordion my-3" style="box-shadow: 1px 5px 10px #888888;">
  <div class="accordion-item rounded-0">
    <h2 class="accordion-header" id="headingThree">
      <button id="buatLapor" class="accordion-button rounded-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <strong class="ms-2"><i class="bi bi-file-earmark-text"></i> Buat Laporan</strong>
      </button>
    </h2>
    <form action="/" method="post">
    	@csrf
    <input id="halaman" type="hidden" name="asal"
    <?= 'value="'.request()->segment(1).'"';
    ?>
    >
    <?php
    		if (request()->segment(1) !== null) {
    			$hasilCari = $resultCari->toArray()['data'];
    		}
    ?>
    <input type="hidden" name="url" id="urlGambar" value="">
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body rounded-bottom">

      	<div id="preview" class="row justify-content-center mb-3">
      		<div class="col-6 text-center">
      			<img id="image-preview" class="img-thumbnail" alt="image preview" style="max-width:150px; display: none;" />
      		</div>
      	</div>

      	<div class="input-group mb-3">
				  <span class="input-group-text">Punya Foto?</span>
				  <select name="tanyaFoto"  id="select-tanyaFoto" class="form-select" required="" value="{{ old('tanyaFoto') }}" onchange="isianLama('select-tanyaFoto')">

				  	<option value="" selected>- Pilih -</option>
					  <option value="0">Tidak punya</option>
					  <option value="1">Punya</option>

					</select>
				</div>

				<div id="gbrPasien" class="input-group custom-file-button mb-3" style="display:none">
						<label class="input-group-text" for="inputGroupFile">Upload Foto</label>
						<input id="gambarODGJ" type="file" class="form-control" name="gambar" disabled="">
				</div>
        
				<div class="input-group mb-3">
				  <span class="input-group-text">Jenis Laporan</span>
				  <select name="laporan"  id="select-laporan" class="form-select" required="" value="{{ old('laporan') }}" onchange="isianLama('select-laporan')">

				  	<option value="" selected>- Pilih Laporan -</option>
					  <?php
					  	for ($i=0; $i < count($kategori_laporan); $i++) { 
					  		$v=$i+1;
					  		echo '<option value="'.$v.'">'.$kategori_laporan[$i].'</option>';
					  	}
					  ?>
					</select>
				</div>

      	<div class="input-group mb-3">
				  <span class="input-group-text" id="basic-addon1">Nama Pelapor</span>
				  <input id="namaPelapor" type="text" name="namaPelapor" class="form-control" placeholder="Masukkan nama anda" required="" value="{{ old('namaPelapor') }}" onchange="isianLama('namaPelapor')">
				</div>

				<div class="input-group mb-3">
				  <span id="nama-pasien" class="input-group-text" name="namaPasien">Nama</span>
				  <input id="input-nama-pasien" name="namaPasien" type="text" class="form-control" placeholder="Masukkan nama" required="" value="{{ old('namaPasien') }}" onchange="isianLama('input-nama-pasien')">
				</div>
				<div class="input-group mb-3">
				  <span class="input-group-text" id="basic-addon1">Jenis Kelamin</span>
				  <select id="jenKel" name="jenisKelamin" required="" class="form-select" onchange="isianLama('jenKel')">
				  	<option value="">- Pilih Jenis Kelamin -</option>
				  	<option value="1">Laki-laki</option>
				  	<option value="2">Perempuan</option>
				  </select>

				</div>

				<div class="input-group mb-3">
				  <span class="input-group-text" id="basic-addon1">Provinsi</span>
				  <select required="" id="select-prov" class="form-select" name="prov" onchange="isianLama('select-prov')">
						  <option value="" selected>- Pilih Provinsi -</option>
						  <?php
						  	foreach ($provinsi as $prov) {
						  		$pro = strtolower($prov->name); 
						  ?>
						  <option value="<?= ucwords($pro) ?>" id="<?= $prov->id ?>" ><?php
						  									echo ucwords($pro);  ?></option>
						  <?php } ?>
						</select>
				</div>
				<div id="kab" class="input-group mb-3">
				  <span class="input-group-text" id="basic-addon1">Kabupaten</span>
				  <select id="select-kab" class="form-select" required="" name="kab" disabled="" onchange="isianLama('select-kab')">
				  	<option value="" selected>- Pilih Kabupaten -</option>
						</select>
				</div>
				<div id="kec" class="input-group mb-3">
				  <span class="input-group-text" id="basic-addon1">Kecamatan</span>
				  <select id="select-kec" class="form-select" required="" name="kec" disabled="" onchange="isianLama('select-kec')">
				  	<option value="" selected>- Pilih Kecamatan -</option>
						</select>
				</div>
				<div id="desa" class="input-group mb-3">
				  <span class="input-group-text" id="basic-addon1">Desa/Kelurahan</span>
				  <select id="select-desa" class="form-select" required="" name="desa" disabled="" onchange="isianLama('select-desa')">
				  	<option value="" selected>- Pilih Desa/Kelurahan -</option>
						</select>
				</div>

				<div class="input-group mb-3">
				  <span class="input-group-text">Rincian</span>
				  <textarea id="rinciPasien" name="rincian" class="form-control" aria-label="With textarea" placeholder="Ketikkan informasi, ciri-ciri, dan tempat terakhir kali anda melihat ODGJ/Tunawisma secara rinci" required="" onchange="isianLama('rinciPasien')"></textarea>
				</div>

				<small><strong>*Dengan mencantumkan nomor, anda bersedia untuk mempublikasikan nomor telepon anda agar dapat dihubungi</strong></small>
				<div class="input-group mb-3 mt-2">
				  <span class="input-group-text" id="basic-addon1">No. Telp / WA</span>
				  <input id="nomorTelp" type="number" name="nomor" class="form-control" placeholder="Masukkan nomor anda" required="" value="{{ old('nomor') }}" onchange="isianLama('nomorTelp')">
				</div>

				<button type="submit" class="btn btn-outline-success w-100 mb-4">
					Laporkan
				</button>
</form>
      </div>
    </div>
  </div>
</div>

			<div class="card rounded-0 rounded-top" style="box-shadow: 1px 5px 10px #888888;">
			  <div class="card-body">
			  	@auth
			  	<div class="row justify-content-center mt-3">
				 	<div class="col-10">
				 		<div class="btn-group mb-3 d-flex justify-content-center" role="group" aria-label="Basic outlined example">
				 		<button id="ubahN" type="button" class="btn btn-success"
				 	onclick="ubahNone()"	>Mode User</button>
				 		<button id="ubahM" type="button" class="btn btn-outline-primary" onclick="ubahModal()">Mode Admin</button>
				 		</div>
				 	</div>
				 </div>
				 @endauth
			    <p class="mb-4 px-3 mt-2" style="font-weight: bold;">
				Masukkan nama orang yang anda <?php if (request()->segment(1) == null or request()->segment(1) == 'laporan') {
					echo 'cari atau temukan';
				}elseif(request()->segment(1) == 'ditemukan'){
					echo 'temukan';
				}elseif(request()->segment(1) == 'hilang'){
					echo 'cari';
				}  ?> pada kolom dibawah ini 
				<?php if (request()->segment(1) == null) {?>
				dan klik <i class="bi bi-search"></i> untuk memulai pencarian!
				<?php }else{ echo "!";} ?>
				</p>
				
					<?php

					if ($aktif == 'beranda'){
						echo '<form class="d-inline" action="/" method="get">';
					}

					?>
				 
			
				<div class="input-group">
					<div class="form-floating">
						  <input type="text" class="form-control" id="cari" placeholder="Pencarian" name="keyword" value="{{ request('keyword') }}">
						  <label for="floatingInput">Pencarian</label>
					 </div>
					 <?php if ($aktif == 'beranda'){
					 	if (!empty($_GET['kategoriLaporan'])) {
					 		$katg = $_GET['kategoriLaporan'];
					 	}else{
					 		$katg = 'all';
					 	}

					 	?>
					 	
					  <select name="kategoriLaporan" class="form-select pe-4" style="max-width: 5px;" value="request('kategoriLaporan')" >
						  <option value="all" <?= ($katg == 'all') ? 'selected' : '' ?>>Semua</option>
						  <option value="1" <?= ($katg == '1') ? 'selected' : '' ?>>Kehilangan</option>
						  <option value="2" <?= ($katg == '2') ? 'selected' : '' ?>>Penemuan</option>
						</select>
						<button type="submit" class="btn btn-outline-success" style="z-index:0"><i class="bi bi-search mx-2"></i></button>
					<?php }else if ($aktif == 'ditemukan'){ ?>
						<input type="hidden" name="kategoriLaporan" value="2">
					<?php }else if ($aktif == 'hilang'){ ?>
						<input type="hidden" name="kategoriLaporan" value="1">
					<?php } ?>
					<?php

					if ($aktif == 'beranda'){
						echo '</form>';
					}

					?>
				</div>
			  </div>
			  <?php if ($hasilCari !== '') {

			  	if (count($hasilCari) !== 0) {
			  	?>
			  <?php if ($aktif == 'beranda'): ?>
			  <p class="mb-4 px-3 ms-3" style="font-weight: bold;font-style: italic;">
				Hasil Pencarian :
				</p>
			<?php endif; ?>

				<div class="row justify-content-center mb-4" id="hwasil">
					<div class="col-10 table-responsive">
						<table id="tbl" class="table table-bordered table-hover">
							<thead>
							<tr style="font-weight: bold;">
								<th class="text-center">Nama</th>
								<th class="text-center">Rincian</th>
								@auth
								<th class="text-center">Konfirmasi</th>
								@endauth
							</tr>
							</thead>
							<tbody id="bodyRes">
							<?php
							  $urut = 1;
								foreach ($hasilCari as $hasil) {
							?>
							<tr>
								<td>
									<table>
										<tr>
											<td>
												<?php

													if ($hasil['gambar'] !== null) {
														echo '<img src="assets/tmp/'.$hasil['gambar'].'.jpg" class="img-thumbnail me-3 max-60">';
													}else{
														echo '<img src="https://source.unsplash.com/50x50?human" class="img-thumbnail me-3 max-60">';
													}

												?>
											</td>
											<td>{{ $hasil['nama_pasien'] }}</td>
										</tr>
									</table>
								</td>
								<td class="text-center"><div class="mt-2">
									<button <?= $urut == 1 ? 'id="detail1"' : '' ?> class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $hasil['id'] }}" data-status="{{ $hasil['status'] }}" data-nama="{{ $hasil['nama_pasien'] }}" data-jenis="{{ $hasil['jenis_laporan'] }}" data-pelapor="{{ $hasil['nama_pelapor'] }}" data-kelamin ="{{ $hasil['jenis_kelamin'] }}" data-alamat ="{{ $hasil['alamat'] }}" data-rincian ="{{ $hasil['rincian'] }}" data-telp ="{{ $hasil['telepon'] }}" data-gm="{{ $hasil['gambar'] }}">Selengkapnya</button>
								</div> </td>
								@auth
								<td class="text-center">
									<div class="mt-2">
										<?= ($hasil['status'] == '1') ? '<i class="bi bi-check-circle-fill" style="color:#008000"></i>' : '<i class="bi bi-x-circle-fill" style="color:#ff0000"></i>' ?>
									</div>
								</td>
								@endauth
							</tr>
						<?php $urut+=1; } ?>
						  </tbody>
						</table>
					</div>
				</div>
			<?php }else{
			?>
			<div class="row justify-content-center mb-4">
					<div class="col-11">
						<div class="alert alert-danger">
							Tidak ada hasil pencarian yang cocok!
						</div>
					</div>
			</div>
			<?php
						} } ?>


			<?php if (request()->segment(1) !== null): ?>
				<div class="row justify-content-center mb-4">
					<div class="col-10 d-flex justify-content-center" id="paginate">
						{{ $resultCari->links() }}
					</div>
				</div>
			<?php endif ?>


			</div>

		</div>
	</div>
</div>

<script type="text/javascript" src="assets/library/crop/ijaboCropTool.min.js"></script>
<script type="text/javascript">
	//IMAGE

$('#gambarODGJ').ijaboCropTool({
      preview : '#image-preview',
      setRatio:1,
      allowedExtensions: ['jpg', 'jpeg','png'],
      buttonsText:['POTONG','BATAL'],
      buttonsColor:['#30bf7d','#ee5155', -15],
      processUrl:'/crop',
      withCSRF:['_token','{{ csrf_token() }}'],
      onSuccess:function(message, element, status){
         document.getElementById("image-preview").style.display = "inline-block";
         document.getElementById('gbrPasien').style.display="none"
         document.getElementById('urlGambar').value=message
         $('#gambarODGJ').prop( "required", false )
         localStorage.setItem(OLDGAMBAR, message)
      },
      onError:function(message, element, status){
         $('.ijabo-cropper-closeBtn').click()
         Swal.fire(
            'Gagal!',
            'Pastikan foto ( jpg, jpeg, png ) berukuran dibawah 2MB!',
            'error'
        );
      }
  })
</script>

<?php

	if (!empty($_GET['keyword']) OR !empty($_GET['kategoriLaporan'])) {
?>

<script type="text/javascript">
	const element = document.getElementById("pencarian");
	element.scrollIntoView();
</script>


<?php
	}

	if (!empty($_GET['buka']) && $_GET['buka'] == 1 && !empty($_GET['keyword']) && !empty($_GET['kategoriLaporan'])) {
?>

<script type="text/javascript">
	$(document).ready(function(){
		if( $('#detail1').length )        
		{
		     $('#detail1').click()
		}
	});
</script>

<?php
}

?>