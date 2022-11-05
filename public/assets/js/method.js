const OLDFILLS = "laporan"
const OLDGAMBAR = 'gambarLamaUrl'

function keyCookieCek(kunci) {
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    c = ca[i]
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
      key = c.split("=")
      if (key[0] == kunci) {
        return true
      }else{
        return false
      }
    }
  }
}

function hitungCookie() {
  let hasil = 0;
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    c = ca[i]
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
      key = c.toString().split("=")
      spes = key[0].split("_")
      if (spes[0] == 'idLaporan') {
        hasil+=1
      }
    }
  }
  return hasil
}


function cookieBaru(isi){
  let jml = hitungCookie()

  if (jml == 0) {
    var expires = (new Date(Date.now()+ 86400*30*12*50*1000)).toUTCString();
document.cookie = "idLaporan_1="+isi+"; expires=" + expires + ";path=/;";
  }else{
    baru = jml+1
    newSekali = baru.toString()
    nama = 'idLaporan_'+newSekali
    var expires = (new Date(Date.now()+ 86400*30*12*50*1000)).toUTCString();
document.cookie = nama+"="+isi+"; expires=" + expires + ";path=/;";
  }
}


function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}



function refreshCookie() {
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
          c = ca[i]
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
            key = c.toString().split("=")
            spes = key[0].split("_")
            if (spes[0] == 'idLaporan') {
                var expires = (new Date(Date.now()+ 86400*30*12*50*1000)).toUTCString();
document.cookie = key[0]+"="+getCookie(key[0])+"; expires=" + expires + ";path=/;";
            }
          }
        }
}

refreshCookie()


function pilihKab(isi = false){
  var prov = $("#select-prov option:selected").attr('id')
  $.ajax({
            type: 'POST',
            url: 'assets/ajax/alamat.php',
            data: {prov:prov},
            success: function(data) {
              $('#select-kab').prop( "disabled", false )
              $('#select-kab').html(data)
              if (fills['select-kab'] !== undefined) {
                  $('#select-kab').val(fills['select-kab'])
                  $('#select-kec').prop( "disabled", false )
                  if (fills['select-kec'] == undefined) {
                    pilihKec()
                  }else{
                    pilihKec(true)
                  }
              }

            }
    })
};

function pilihKec(isi = false){
    var kab = $("#select-kab option:selected").attr('id')
    $.ajax({
              type: 'POST',
              url: 'assets/ajax/alamat.php',
              data: {kab:kab},
              success: function(data) {
                $('#select-kec').html(data)
                if (fills['select-kec'] !== undefined) {
                  $('#select-kec').val(fills['select-kec'])
                  $('#select-desa').prop( "disabled", false )
                  if (fills['select-desa'] == undefined) {
                    pilihDesa()
                  }else{
                    pilihDesa(true)
                  }
                }

              }
      })
}

function pilihDesa(isi = false){
  var kec = $("#select-kec option:selected").attr('id')
  $.ajax({
        type: 'POST',
        url: 'assets/ajax/alamat.php',
        data: {kec:kec},
        success: function(data) {
          $('#select-desa').html(data)
          if (fills['select-desa'] !== undefined) {
              $('#select-desa').val(fills['select-desa'])
          }
        }
    })
};

function ubahModal(){
  // $('#jenis-laporan').prop( "disabled", false )
  // $('#pasien').prop( "readonly", false )
  // $('#nama-pelapor').prop( "readonly", false )
  // $('#kelamin').prop( "disabled", false )
  // $('#alamat').prop( "readonly", false )
  // $('#rincian').prop( "readonly", false )
  // $('#noTelp').prop( "readonly", false )
  $('#ubahN').removeClass('btn-success')
  $('#ubahN').addClass('btn-outline-success')
  $('#ubahM').removeClass('btn-outline-primary')
  $('#ubahM').addClass('btn-primary')
  $('#aksiModal').removeClass('d-none')
}

function ubahNone(){
  // $('#jenis-laporan').prop( "disabled", true )
  // $('#pasien').prop( "readonly", true )
  // $('#nama-pelapor').prop( "readonly", true )
  // $('#kelamin').prop( "disabled", true )
  // $('#alamat').prop( "readonly", true )
  // $('#rincian').prop( "readonly", true )
  // $('#noTelp').prop( "readonly", true )
  $('#ubahN').addClass('btn-secondary')
  $('#ubahN').removeClass('btn-outline-secondary')
  $('#ubahM').addClass('btn-outline-primary')
  $('#ubahM').removeClass('btn-primary')
  $('#aksiModal').addClass('d-none')
}

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
