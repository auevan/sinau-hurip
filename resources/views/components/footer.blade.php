<div class="container-fluid text-white" style="background-image: linear-gradient(to top, #009933, #00e64d);">
	<div class="row justify-content-center pt-5">
		<div class="col-lg-5 col-10 mb-5">
	<?php if (!empty($profil['items'])){ ?>
		<div class="row justify-content-center">
			<div class="col-4">
				<img id="iconThum" src="<?= $profil['items'][0]['snippet']['thumbnails']['high']['url'] ?>" class="rounded-circle img-thumbnail">
			</div>
			<div class="col-6">
				<h3 id="chan" class="mt-4"><?= $profil['items'][0]['snippet']['title'] ?></h3>
				<i>
				<p id="subs" style="margin-top:-7px"><?= $profil['items'][0]['statistics']['subscriberCount'] ?> Subscribers</p>
				<p id="views" style="margin-top:-20px"><?= $profil['items'][0]['statistics']['viewCount'] ?> Views</p>
				</i>
			</div>
		</div>
	<?php }else{ ?>
		<div class="row justify-content-center">
			<div class="col-4">
				<img id="iconThum" src="assets/img/logo.jpg" class="rounded-circle img-thumbnail">
			</div>
			<div class="col-6">
				<h3 id="chan" class="mt-4">Sinau Hurip</h3>
				<i>
				<p id="subs" style="margin-top:-7px">Owner by :</p>
				<p id="views" style="margin-top:-20px">Sukaryo Adi Putro</p>
				</i>
			</div>
		</div>
	<?php } ?>
		</div>
		<div class="col-lg-5 col-10 mb-5">
			<p class="mb-3">Belajar Hidup Dari Kehidupan. Dengan Memanusiakan Manusia Lain. Karena ODGJ juga manusia seperti kita.</p>
			<p>Hubungi kami melalui media sosial dan nomor resmi kami. Hati-hati terhadap penipuan yang mengatasnamakan Tim Sinau Hurip!</p>
			<div class="d-flex fs-4 justify-content-center">
			<a class="nav-link link-sosmed" href="https://www.youtube.com/c/SinauHurip/" target="_blank"><i class="bi bi-youtube me-3"></i></a>
			<a class="nav-link link-sosmed" href="https://www.facebook.com/sinauhurip/" target="_blank"><i class="bi bi-facebook me-3"></i></a>
			<a class="nav-link link-sosmed" href="https://api.whatsapp.com/send?phone=6282137448886" target="_blank"><i class="bi bi-whatsapp me-3"></i></a>
			<a class="nav-link link-sosmed" href="https://www.instagram.com/sinauhurip/" target="_blank"><i class="bi bi-instagram me-3"></i></a>
			</div>
		</div>
	</div>
	<hr color="white" size="3%" style="opacity: 1;border-top: none;">
	<div class="row justify-content-center pb-4">
		<div class="col-10 text-center">
			© 2022 Sinau Hurip
		</div>
	</div>
</div>