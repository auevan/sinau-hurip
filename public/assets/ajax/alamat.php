<?php

if(!empty($_POST)){
	if (!empty($_POST['prov'])) {
		$prov = $_POST['prov'];
		$api_url = 'https://emsifa.github.io/api-wilayah-indonesia/api/regencies/'.$prov.'.json';
		$json_data = file_get_contents($api_url);
		$kabupaten = json_decode($json_data);
		echo '<option value="" selected>- Pilih Kabupaten -</option>';
		foreach ($kabupaten as $kab) :
		$k = strtolower($kab->name);
?>
	<option value="<?= ucwords($k)?>" id="<?= $kab->id ?>"><?php
	 echo ucwords($k) ?></option>
<?php 
	endforeach;
	}elseif (!empty($_POST['kab'])) {
		$kab = $_POST['kab'];
		$api_url = 'https://emsifa.github.io/api-wilayah-indonesia/api/districts/'.$kab.'.json';
		$json_data = file_get_contents($api_url);
		$kecamatan = json_decode($json_data);
		echo '<option value="" selected>- Pilih Kecamatan -</option>';
		foreach ($kecamatan as $kec) :
		$k = strtolower($kec->name);
?>
	<option value="<?= ucwords($k)?>" id="<?= $kec->id ?>"><?php
	 echo ucwords($k) ?></option>
<?php
	endforeach;
	}elseif (!empty($_POST['kec'])) {
		$kec = $_POST['kec'];
		$api_url = 'https://emsifa.github.io/api-wilayah-indonesia/api/villages/'.$kec.'.json';
		$json_data = file_get_contents($api_url);
		$desa = json_decode($json_data);
		echo '<option value="" selected>- Pilih Desa/Kelurahan -</option>';
		foreach ($desa as $d) :
	$k = strtolower($d->name);
?>
	<option value="<?= ucwords($k)?>" id="<?= $d->id ?>"><?php
	 echo ucwords($k) ?></option>
<?php
	endforeach;
	}
}
?>