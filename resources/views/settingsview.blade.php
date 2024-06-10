@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">
        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
		<?php 
		$baseUrl = asset('');		
		?>
        <script src="<?php echo $baseUrl;?>/vendor/ginsights/js/jquery-3.6.0.min.js"></script> 
		<script src="<?php echo $baseUrl;?>/vendor/ginsights/js/jquery-3.7.0.slim.js"></script> 
	    
	<!--	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.slim.js" integrity="sha512-docBEeq28CCaXCXN7cINkyQs0pRszdQsVBFWUd+pLNlEk3LDlSDDtN7i1H+nTB8tshJPQHS0yu0GW9YGFd/CRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://statamic.vijaysoftware.com/garesource/css/ga_style.css">
        <?php  
          use Illuminate\Support\Str;		 
		  use Symfony\Component\Yaml\Yaml;
        ?>        
	</header>
    
	<body>   
		<div class="row  mt-2 mb-2  ">    
			<div class="card flex ">
				<form  action="cp/utilities/analytics" method="post" id="idForm">
					@csrf      
					<h2 class="mb-1 text-xl">Google Authentication</h2>
				</form>			
			</div>
			<div class="card flex flex-col mb-4 ">	
				<h2 class="pb-1 mt-3 font-bold">Website Profile </h2><br>				
				<?php 
				$rootPath = base_path();				
				$filePath = $rootPath . '/vendor/vijaysoftware/ginsights/src/content/webproperty.yaml';				
				$yamlString = file_get_contents($filePath);
				  
				// Parse the YAML string to retrieve the data
				$data = Yaml::parse($yamlString);								
					if($data){				   
						$property_id = $data['property_id'];
					}
				//For reading gtag
				$filePath1 = $rootPath . '/vendor/vijaysoftware/ginsights/src/content/gtag.yaml';	
				$yamlString1 = file_get_contents($filePath1);
				$data1 = Yaml::parse($yamlString1);				
					if($data1){				   
						$gtag_id = $data1['gtag_id'];
					}				
				?>				
				<h3 class="">Active profile: <?php echo  $gtag_id;?></h3>
				
			</div>
			<div class="card flex flex-col ">	
				<h2 class="pb-4">Setup Wizard </h2>
				<h3 class="mb-10">Use our configuration wizard to set up Google Analytics </h3>				
				<a href='<?php echo env('APP_URL')?>/cp/utilities/analytics?reauth=true' class="block w-full h-full"><button class="bg-blue-700 text-white font-bold py-2 px-6 rounded w-1/2">Launch Setup Wizard</button></a>
			</div>
		
	</body>
@stop