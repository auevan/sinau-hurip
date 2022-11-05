$(document).ready(function(){

  $(document).on("scrollstop",function(){
    alert("Stopped scrolling!");
  });  

  $("#cari").keyup(function(){
    var asal = $("#halaman").val()
    var key = $("#cari").val()
    let result = ''
    if (asal !== "") {
      $.ajax({
              type: 'GET',
              url: '/caripasien',
              data: {key:key,
                    asal:asal},
              success: function(data) {
                var hasil = JSON.parse(data)
                if (hasil.jml !== 0) {
                $.each(hasil.result, function(i, d) {
                  if (d.gambar == null) {
                    url1 = 'https://source.unsplash.com/50x50?human'
                    url2 = 'https://source.unsplash.com/50x50?human'
                  }else{
                    url1 = d.gambar
                    url2 = 'assets/tmp/'+d.gambar+'.jpg'
                  }
                   result+=(`
                    <tr>
                      <td>
                        <table>
                          <tr>
                            <td>
                              <img src="${url2}" class="img-thumbnail me-3 max-60">
                            </td>
                            <td>${d.nama_pasien}</td>
                          </tr>
                        </table>
                      </td>
                      <td class="text-center"><div class="mt-2">
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="${ d.id }" data-id="${ d.status }" data-nama="${d.nama_pasien}" data-jenis="${d.jenis_laporan}" data-pelapor="${d.nama_pelapor}" data-kelamin ="${d.jenis_kelamin}" data-alamat ="${d.alamat}" data-rincian ="${d.rincian}" data-telp ="${d.telepon}" data-gm="${url1}">Selengkapnya</button>
                      </div> </td>
                    </tr>
                    `)
                   $('#tbl').removeClass('d-none')
                   $('#ingat').addClass('d-none')
                   $('#bodyRes').html(result)
                });
                }else{
                  alert = `
                    <div id="ingat" class="col-11">
                      <div class="alert alert-danger">
                        Tidak ada hasil pencarian yang cocok!
                      </div>
                    </div>
                    <div class="col-10">
                    <table id="tbl" class="table table-bordered table-hover d-none">
                    <thead>
                    <tr style="font-weight: bold;">
                      <th class="text-center">Nama</th>
                      <th class="text-center">Rincian</th>
                    </tr>
                    </thead>
                    <tbody id="bodyRes">
                    </tbody>
                    </div>
                  `
                  $('#hwasil').html(alert)
                  $('#paginate').addClass('d-none')  
                }
                if (hasil.key == "") {
                  $('#paginate').removeClass('d-none')
                }else{
                  $('#paginate').addClass('d-none')   
                }
                }
      })
    }
  });

  $("#select-prov").change(function(){
    var prov = $("#select-prov option:selected").attr('id')
    $.ajax({
              type: 'POST',
              url: 'assets/ajax/alamat.php',
              data: {prov:prov},
              success: function(data) {
                $('#select-kab').prop( "disabled", false )
                $('#select-kab').html(data)
              }
      })
  });

  $("#select-kab").change(function(){
    var kab = $("#select-kab option:selected").attr('id')
    $.ajax({
              type: 'POST',
              url: 'assets/ajax/alamat.php',
              data: {kab:kab},
              success: function(data) {
                $('#select-kec').prop( "disabled", false )
                $('#select-kec').html(data)
              }
      })
  });

  $("#select-kec").change(function(){
    var kec = $("#select-kec option:selected").attr('id')
    $.ajax({
          type: 'POST',
          url: 'assets/ajax/alamat.php',
          data: {kec:kec},
          success: function(data) {
            $('#select-desa').prop( "disabled", false )
            $('#select-desa').html(data)
          }
      })
  });

  $("#select-laporan").change(function(){
    var nama = $('#nama-pasien')
    var laporan = $('#select-laporan').val()
    var inputNama = $('#input-nama-pasien')
    if(laporan == 1 || laporan == 2){
      nama.html('Nama ODGJ')
      inputNama.attr("placeholder", "Masukkan nama ODGJ");
    }else if(laporan == 3 || laporan == 4){
      nama.html('Nama Tunawisma')
      inputNama.attr("placeholder", "Masukkan nama tunawisma");
    }
  });

  $("#select-tanyaFoto").change(function(){
    var konfir = $("#select-tanyaFoto").val()
    
    if (konfir == '1') {
      document.getElementById('gbrPasien').style.display="flex"
      $('#gambarODGJ').prop( "disabled", false )
      $('#gambarODGJ').prop( "required", true )
    }else{
      document.getElementById('gbrPasien').style.display="none"
      document.getElementById("image-preview").style.display = "none";
      $('#gambarODGJ').prop( "disabled", true )
      $('#gambarODGJ').prop( "required", false )
      document.getElementById('urlGambar').value=""
    }
  });



});


//MODAL

  const detailModal = document.getElementById('detailModal')
  detailModal.addEventListener('show.bs.modal', event => {
  
  const button = event.relatedTarget

  const isi_id = button.getAttribute('data-id')
  const isi_status = button.getAttribute('data-status')
  const isi_pasien = button.getAttribute('data-nama')
  const isi_jenis = button.getAttribute('data-jenis')
  const isi_pelapor = button.getAttribute('data-pelapor')
  const isi_kelamin = button.getAttribute('data-kelamin')
  const isi_alamat = button.getAttribute('data-alamat')
  const almt = isi_alamat.split(",")
  const alamt = almt[0] + ", " + almt[1] + ', ' + almt[2] + ', '+almt[3];
  const isi_rincian = button.getAttribute('data-rincian')
  const isi_tlp = button.getAttribute('data-telp')
  const isi_gb = button.getAttribute('data-gm')

  const modalTitle = detailModal.querySelector('.modal-title')
  const modalGm = detailModal.querySelector('#modal_gmbr')
  const jenisLaporan = detailModal.querySelector('#jenis-laporan')
  const pelapor = detailModal.querySelector('#nama-pelapor')
  const jenisKelamin = detailModal.querySelector('#kelamin')
  const alamats = detailModal.querySelector('#alamat')
  const rincian = detailModal.querySelector('#rincian')
  const tlp = detailModal.querySelector('#noTelp')
  modalTitle.textContent = `Data ${isi_pasien}`

  if (isi_gb == "") {
    modalGm.src = 'https://source.unsplash.com/100x100?human'
  }else{
    modalGm.src = 'assets/tmp/'+isi_gb+'.jpg'
  }
  pasien.value = isi_pasien
  jenisLaporan.value = isi_jenis
  pelapor.value = isi_pelapor
  jenisKelamin.value = isi_kelamin
  alamats.value = alamt
  rincian.value = isi_rincian
  tlp.value = isi_tlp

  if(isi_status == '0'){
    $('#konfirModal').html('Konfirmasi')
  }else{
    $('#konfirModal').html('Sembunyikan')
  }

  $('#konfirModal').prop( "href", `konfirmasi/?id=${isi_id}` )
  $('#hpsModal').prop( "href", `hapus/?id=${isi_id}` )

  })



var url = window.location.href
var pisahUrl = url.split('/')



//METHOD

$(document).ready(function(){
  if (localStorage.getItem(OLDFILLS) || localStorage.getItem(OLDGAMBAR)) {
    Swal.fire({
      title: 'Lanjutkan pengisian laporan?',
      icon: 'info',
      showDenyButton: true,
      backrop : true,
      allowOutsideClick : false,
      confirmButtonText: 'Ya',
      denyButtonText: `Tidak`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
          fills = {}

          if (dataFromLocal = localStorage.getItem(OLDFILLS)) {
            const element = document.getElementById("pencarian");
            element.scrollIntoView();
            $('#buatLapor').click()

            fills = JSON.parse(dataFromLocal)
            
            for(let key in fills){
              autoIsi(key, fills[key])
            }
          }

          if (imgFromLocal = localStorage.getItem(OLDGAMBAR)) {
            document.getElementById("image-preview").style.display = "inline-block";
             document.getElementById('gbrPasien').style.display="none"
             document.getElementById('urlGambar').value=localStorage.getItem(OLDGAMBAR)
             $(document).ready(function(){
               document.getElementById("image-preview").src="assets/tmp/"+localStorage.getItem(OLDGAMBAR)+".jpg"
               $('#gambarODGJ').prop( "required", false )
             });
          }
      } else if (result.isDenied) {
        fills = {}
        localStorage.removeItem(OLDFILLS)
        localStorage.removeItem(OLDGAMBAR)
      }
    })
  }

});


if (dataFromLocal = localStorage.getItem(OLDFILLS)) {
  fills = JSON.parse(dataFromLocal)
}else{
  fills = {}
}



  function isianLama(isi) {
    if (typeof(Storage) !== "undefined") {
      var fill = document.getElementById(isi).value
      fills[isi] = fill

      localStorage.setItem(OLDFILLS, JSON.stringify(fills))
    }
  }


  function autoIsi(id, isi) {
      if (document.getElementById(id).disabled == true) {
        document.getElementById(id).disabled = false  
        if (id == 'select-kab') {
          pilihKab();
        }
      }else{
        if (id == 'select-prov') {
          $(document).ready(function(){
            pilihKab(true);
          });
        }
        document.getElementById(id).value=isi
      }
  }





