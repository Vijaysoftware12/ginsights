@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">
        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
        <h1>{{ __('Connect Google Analytics to your website') }}</h1>
        <?php 
		$baseUrl = asset('');	
	 
		?>
        <script src="<?php echo $baseUrl;?>vendor/ginsights/js/jquery-3.6.0.min.js"></script> 
		<script src="<?php echo $baseUrl;?>vendor/ginsights/js/jquery-3.7.0.slim.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://statamic.vijaysoftware.com/garesource/css/ga_style.css">
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
					<input id ="selurl" name="selectedurl"  value="" type="hidden"/>
									
					<select id="view_id" class="fullwidth" name="view_id" >  
						<option value="select"  selected>--select--</option>
						
					<?php					
					foreach($newIds as $key => $value)
					{						
					   if($value['url']!='url1'){ ?>					 
					   <option mid = "<?php echo $value['mid']; ?>" value="<?php echo $value['id'];  ?>"><?php echo $value['url'];  ?></option>
					   
					<?php
					}
					  $selectedViewId = isset($_POST['view_id']);					  
					  $viewId =$selectedViewId;	
					 			  			  
					}
					?>					 
					</select>				 
         
					  <label for="textAreaField" class="py-4 "><h3>Google Profile tag id</h3></label> 
                      <div class="checkbox-container">
                        <textarea readonly name="gtag_id" id="gtag_id" rows="4" cols="50" class="p-1 bg-gray-300 border-gray-200"></textarea>
                        <div class="checkbox-label">
                            <input type="checkbox" id="gtag_checkbox" name="gtag_checkbox">
                            <label for="gtag_checkbox">Enable TrackingCode</label>
                        </div>
                        </div>
                                            
					  <div id="validationMessage" class="negative-value"></div>			
					  <?php
					 if(isset($_POST['gtag_id'])) {
					  $Gtag_id = $_POST['gtag_id']; 
					 }?>
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
			document.getElementById("gtag_id").readOnly = true;
				$('#view_id').on('change',function()
				{					
					$('#selid').val($(this).val());
					selected_Value = $(this).val();			
					localStorage.setItem('selectedValue', selected_Value);
					
					measurementid = $(this).find(':selected').attr('mid');	
					localStorage.setItem('mid_Value', measurementid);
					
					// Get the text (url)
					
					var selectedUrl = $('#view_id option:selected').text(); 
					// Store the selected URL in localStorage
					localStorage.setItem('selectedUrl', selectedUrl); 
					// Set the value of the 'selurl' textbox
					$('#selurl').val(selectedUrl);
					
					var	measurementidd= localStorage.getItem('mid_Value');
					if(selected_Value!="select"){					
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

					$('#submitButton').click(function(){


						var selectedValue = $('#view_id').val();
						
						if (selectedValue === 'select') {
						event.preventDefault(); // Prevent form submission

						// Display message below the textarea
						$('#validationMessage').text('Please select a website to view Google Analytics data.');
						
						// Optionally, you can style the message
						$('#validationMessage').css('color', 'red'); // Example styling

						return false;
                        
                        }
                        else {
                        // Hide the validation message if the selection is valid
                        $('#validationMessage').text('');
                         }

                    // Create and show the loading animation
                  
                    var loadingElement = document.createElement('div');
                    loadingElement.id = 'loadingAnimation';
                    loadingElement.style.position = 'fixed';
                    loadingElement.style.top = '0';
                    loadingElement.style.left = '0';
                    loadingElement.style.width = '100%';
                    loadingElement.style.height = '100%';
                    loadingElement.style.backgroundColor = 'rgba(0, 0, 0, 0.5)'; // Semi-transparent background
                    loadingElement.style.display = 'flex';
                    loadingElement.style.justifyContent = 'center';
                    loadingElement.style.alignItems = 'center';
                    loadingElement.style.zIndex = '9999';
                    // Remove color and font size properties as they're not needed for a modal
                    loadingElement.style.color = '#000000';
                    loadingElement.style.fontSize = '40px';

                    // Replace innerHTML with modal HTML
                    loadingElement.innerHTML = `
                        <div class="modal">
                            <div class="modal-content">
                          
                           <!--<p style="font-size: 35px;background-color:#ffff;">-->
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="200" height="200" style="shape-rendering: auto; display: block; background: transparent;" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g transform="translate(80,50)">
                            <g transform="rotate(0)">
                            <circle fill-opacity="1" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.875s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="-0.875s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g transform="translate(71.21320343559643,71.21320343559643)">
                            <g transform="rotate(45)">
                            <circle fill-opacity="0.875" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.75s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="-0.75s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g transform="translate(50,80)">
                            <g transform="rotate(90)">
                            <circle fill-opacity="0.75" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.625s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="-0.625s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g transform="translate(28.786796564403577,71.21320343559643)">
                            <g transform="rotate(135)">
                            <circle fill-opacity="0.625" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.5s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="-0.5s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g transform="translate(20,50.00000000000001)">
                            <g transform="rotate(180)">
                            <circle fill-opacity="0.5" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.375s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="-0.375s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g transform="translate(28.78679656440357,28.786796564403577)">
                            <g transform="rotate(225)">
                            <circle fill-opacity="0.375" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.25s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="-0.25s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g transform="translate(49.99999999999999,20)">
                            <g transform="rotate(270)">
                            <circle fill-opacity="0.25" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.125s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="-0.125s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g transform="translate(71.21320343559643,28.78679656440357)">
                            <g transform="rotate(315)">
                            <circle fill-opacity="0.125" fill="#1065a6" r="6" cy="0" cx="0">
                            <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="0s" type="scale" attributeName="transform"></animateTransform>
                            <animate begin="0s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
                            </circle>
                            </g>
                            </g><g></g></g><!-- [ldio] generated by https://loading.io --></svg>

                           <!--</p> -->  

                            <div class="loading-wheel"></div>
                            </div>
                        </div>
                    `;

                    // Append modal to body
                    document.body.appendChild(loadingElement);

                  
                    // Dynamically add CSS for the rotating wheel animation
                    var style = document.createElement('style');
                        style.textContent = `
                            @keyframes rotate {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                            .loading-wheel {
                            
                    border: none; /* Remove borders */
                    color: white; /* White text */
                    padding: 12px 24px; /* Some padding */
                    font-size: 16px; /* Set a font-size */
                            }
                        `;
                        document.head.appendChild(style);
                                    });




				});
		</script>
	</body>
@stop