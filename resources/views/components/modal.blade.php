<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog"> 
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-10 text-center mb-3">
            <img id="modal_gmbr" src="" class="img-thumbnail me-3 max-100">
          </div>
        </div>
        @auth
   
        <div id="aksiModal" class="btn-group mb-3 d-flex justify-content-center d-none" role="group" aria-label="Basic outlined example">
      
          <a id="hpsModal" href="" type="button" class="btn btn-outline-danger">Hapus</a>
          <a id="konfirModal" href="" type="button" class="btn btn-outline-success">Konfirmasi</a>
          
        </div>
        @endauth
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Jenis Laporan</span>
          <select id="jenis-laporan" class="form-select" aria-label="Default select example" disabled="">

            <option selected>- Pilih Laporan -</option>
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
          <input readonly id="nama-pelapor" type="text" class="form-control" placeholder="Masukkan nama anda">
        </div>

        <div class="input-group mb-3">
          <span id="nama-pasien" class="input-group-text" id="basic-addon1">Nama</span>
          <input readonly id="pasien" type="text" class="form-control" placeholder="Masukkan nama">
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Jenis Kelamin</span>
          <select disabled="" id="kelamin" required="" class="form-select">
            <option value="">- Pilih Jenis Kelamin -</option>
            <option value="1">Laki-laki</option>
            <option value="2">Perempuan</option>
          </select>

        </div>

        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Alamat</span>
          <input readonly id="alamat" type="text" class="form-control" placeholder="Alamat">
          
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Rincian</span>
          <textarea readonly id="rincian" class="form-control" aria-label="With textarea" placeholder="Ketikkan informasi, ciri-ciri, dan tempat terakhir kali anda melihat ODGJ/Tunawisma secara rinci"></textarea>
        </div>

        <div class="input-group mb-3 mt-2">
          <span class="input-group-text" id="basic-addon1">No. Telp / WA</span>
          <input id="noTelp" type="number" name="nomor" class="form-control" placeholder="Masukkan nomor anda" required="" readonly="">
      </div>
      </div>

      <div class="modal-footer">
        <!-- <a href="" id="saveModal" class="btn btn-success d-none">Simpan</a> -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>



<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Login Admin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/login" method="post">
        @csrf
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-10">
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Username</span>
              <input type="text" class="form-control" placeholder="Masukkan username" aria-label="Username" aria-describedby="basic-addon1" required="" value="{{ old('') }}" name="username" autofocus="">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Password</span>
              <input type="password" class="form-control" placeholder="Masukkan Password" aria-label="Username" aria-describedby="basic-addon1" required="" value="{{ old('password') }}" name="password">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" >Login</button>
      </div>
      </form>
    </div>
  </div>
</div>