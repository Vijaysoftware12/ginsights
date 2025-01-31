@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">           
	<?php 
		$baseUrl = asset('');		
	?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>      
		<script src="<?php echo $baseUrl;?>vendor/ginsights/js/jquery-3.6.0.min.js"></script>
		       
		<link rel="stylesheet" href="http://statamic.vijaysoftware.com/garesource/css/ga_style.css">
	</header>
    
	<body>   
		<div class="row card ">    
			<div class="p-2 ">
				<h2 class="text-center">Please Authorize Your Google Account For Analytics Data</h2>	   
			   <div class="p-3 text-center ">
			   <a href="<?php echo env('APP_URL')?>/cp/utilities/analytics?reauth=true" class="">
                   <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-3.6 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                       Click here
                   </button>
               </a> 
			   </div>
			</div> 
		</div>
		<script>
			$(function(){

				localStorage.removeItem('selectedValue');
				localStorage.removeItem("resultData");
			});
	    </script>

	</body>

@stop