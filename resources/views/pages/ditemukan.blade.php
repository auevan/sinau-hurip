@extends('layouts.main')
@section('container')

<section class="mt-3">
@include('components.laporan')
</section>

@include('components.footer')

<script type="text/javascript">
	document.getElementById('navbar-main').classList.add('bg-ijo');
	$(document).ready(function(){
      $(window).scroll(function() {
        if ($(document).scrollTop() > 90) { 
              document.getElementById('navbar-main').classList.add('fixed-top'); 
        }else{
        	document.getElementById('navbar-main').classList.remove('fixed-top'); 
        }
      });
    });
</script>
@endsection('container')