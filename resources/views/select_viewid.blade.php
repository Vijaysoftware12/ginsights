@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">
        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
        <h1>{{ __('Connect Google Analytics to your website') }}</h1>
        
        <script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	    <script src="https://code.jquery.com/jquery-3.7.0.slim.js" integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@^2.29.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="http://statamic.vijaysoftware.com/garesource/css/ga_style.css">
        <?php  
          use Illuminate\Support\Str;
        ?>        
	</header>
    
	<body>   
		<div class="row  mt-2 max-w-sm w-full lg:max-w-full lg:flex  ">    
			<div class="w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
				<form  action="../utilities/analytics" method="post" id="idForm">
					@csrf
					<h3 class="mb-2">Select a website to view Google Analytics data</h3>
					<input id ="selid" name="selectedid"  value="" type="hidden"/>
					<?php
					//$newIds = json_decode($newIds, true); 
					//if(Empty($newIds)){ 
					?>
						<!--<script>alert("No analytics account");</script> -->
					<?php
					//}
								  
					?> 
					<select id="view_id" name="view_id" >  
						<option value="select">--select--</option>
					<?php
					
					foreach($newIds as $key => $value)
					{ 				
						
					 if($value['url']!='url1'){ ?>
					 
					   <option mid="<?php echo $value['mid']; ?>" value="<?php echo $value['id'];  ?>"><?php echo $value['url'];  ?></option>
					   
					<?php
					}
					  $selectedViewId = isset($_POST['view_id']);					  
					  $viewId =$selectedViewId;	
					 				  			  
					}
					?>					 
					</select>				 
         
					  <label for="textAreaField" class="py-4 "><h3>Google tag id for your profile </h3></label> 
					  <textarea name="gtag_id" id="gtag_id" rows=""  cols="" class="p-1 bg-gray-300 border-gray-200" style="" text="" >
					  </textarea>				
					  <?php $Gtag_id = isset($_POST['gtag_id']); ?>
					  <div class="row ">
					  <input type="submit" value="Submit" id="submitButton" class="mt-4 bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
					  </div>

				</form>			
			</div> 
		</div>
		<script>

		 $(document).ready(function(){
				
			var selected_Value;
			var measurementid;
			
				$('#view_id').on('change',function()
				{
					
					$('#selid').val($(this).val());
					selected_Value = $(this).val();			
					localStorage.setItem('selectedValue', selected_Value);
					
					measurementid = $(this).find(':selected').attr('mid');	
					localStorage.setItem('mid_Value', measurementid);
					
					var	measurementidd= localStorage.getItem('mid_Value');
					if(selected_Value!="select"){

					// Set the value in the textbox

					document.getElementById("gtag_id").value = measurementidd;
					}
					else{
						document.getElementById("gtag_id").value='';
					}
				});
				var cachedValue = localStorage.getItem('selectedValue');	
					if (cachedValue !== null) {
					$('#view_id').val(cachedValue);
					$('#selid').val(cachedValue);
					
					localStorage.setItem('my_key', 'my_value');
					}
					const dropdown = document.getElementById('view_id');
					const submitButton = document.getElementById('submitButton');
					updateOptions();
					function updateOptions() {
					 const hasOptions = dropdown.options.length > 1;
					 submitButton.disabled = !hasOptions;
					}

				});
		</script>
	</body>
@stop