@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">           
		<?php 
			$baseUrl = asset('');		
		?>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
		<script src="<?php echo $baseUrl;?>/vendor/ginsights/js/jquery-3.6.0.min.js"></script>  
		<link rel="stylesheet" href="http://statamic.vijaysoftware.com/garesource/css/ga_style.css">
	</header>
    
	<body>   
		<div class="row card ">    
			<div class="p-2 ">
				<h2 class="text-center">Google Analytics account unavailable.</h2>
				<a href='<?php echo rtrim(env('APP_URL'),'/')?>/cp/utilities/analytics?reauth=true' class="text-center block w-full h-full"><button class="mt-6 bg-blue-700 text-white font-bold py-2 px-4 rounded ">Click here to reauthorize</button></a>			   
			</div> 				
		</div>
	</body>

@stop