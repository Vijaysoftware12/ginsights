@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">       
    <nav class="nav_style">	
    @include('statamic::partials.breadcrumb', [
        'url' => cp_route('utilities.index'),
        'title' => __('Utilities')
    ])
    <span class="breadcrumb" >&nbsp;&lt;&nbsp; </span>
    <div class="breadcrumb" > GInsights Analytics</div>
	
	
</nav>
        <?php 
		$baseUrl = asset('');
		$user_role = Auth::user()->super;
		
		?>
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/ginsights/js/jquery-3.6.0.min.js"></script>
        
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/ginsights/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/ginsights/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/ginsights/js/Chart.js"></script> 
        
        
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/ginsights/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="<?php echo $baseUrl;?>vendor/ginsights/css/jquery.dataTables.min.css">
      <!--  <link rel="stylesheet" href="../../../../resources/css/ga_style.css">-->
        <link rel="stylesheet" href="https://statamic.vijaysoftware.com/garesource/css/ga_style.css">
        <link rel="stylesheet" href="<?php echo $baseUrl;?>vendor/ginsights/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	        
    <!-- Include Date Range Picker library -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>vendor/ginsights/css/daterangepicker.css" />
    <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/ginsights/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/ginsights/js/daterangepicker.min.js"></script>
  
    <!--new-->

    <link rel="stylesheet" href="<?php echo $baseUrl;?>vendor/ginsights/css/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css">
    <script src="<?php echo $baseUrl;?>vendor/ginsights/js/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <?php  
        use Illuminate\Support\Str;
		use Symfony\Component\Yaml\Yaml;
    ?>  
    
	</header>    
	
    <body> 
	
    <!-- Data retreived from controller -->
    <?php 
     $data = json_decode($data, true);      
     if($data != null)
     {  		
		$rootPath = base_path();				
		$filePath = $rootPath . '/vendor/vijaysoftware/ginsights/src/content/webproperty.yaml';	
        $yamlString = file_get_contents($filePath);
		if (file_exists($filePath)) {
			$yamlData = Yaml::parse(file_get_contents($filePath));
			$selectedUrl = $yamlData['property_url'] ?? '';
		} 
    ?>
    
    
    <div class="container" id="content">	  
        <div class="row  flex-auto">
        <div class="gcard_heading mb-2">
            <img src="https://statamic.vijaysoftware.com/garesource/img/vijay-icon-100x100.png" width="30px" alt="analytic icon">
            <span>GInsights Analytics</span>			
			<div id="cachedUrlDisplay" class=" text-sm text-gray-700 ml-auto">
				<!-- Cached URL will be displayed here -->
				&nbsp; : <?= htmlspecialchars($selectedUrl); ?>
			</div>
        </div>
        
	    <div class="card ginsigts-con" id=""> 
       
		  <!-- Newly added -->         
		     <div class="ginsights-calendar mx-0" id="calendar" >
                <label  id="dateLabel" class="px-2  "for="datepicker"><h2>Select date:</h2></label>  
                <form  id="dateForm" action="<?php env('APP_URL')?>" method="post" >
                    @csrf                
                    <input type="hidden" id="period" name="period" value="custom"/>
                    
                    <input type="hidden" name="selectedid" value="<?php echo (($_REQUEST['selectedid']="")?$selectedid: $_REQUEST['selectedid'] ) ?>">
                    <input type="hidden" class="datepicker" id="datepicker1" name="dp1" value="{{$startDate}}">
                    <input type="hidden" class="datepicker" id="datepicker2" name="dp2" value="{{$endDate}}">
                    <input type="hidden" class="" id="drange" name="drange" value="">
                  
                        <div id="reportrange" class="daterange d-flex align-items: center;" name ="rrange">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>                        
                        </div>
                        <button id="subbtn" type="submit" value="Submit" id="submit" class="btn-primary py-1 px-4 ml-2" >Submit</button>
                </form> 
            </div>  
                
		    <div class="ginsights-head-rt">
            <button id="pdfgen" class="btn-primary ml-2 mr-1">Generate PDF Report</button>
             <!--   <a href="#" class="btn-primary ml-2 mr-1">Generate PDF Report</a> -->
             <a href="?reset=true" class="ml-auto ggear" title="GInsights Settings"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 01-.517.608 7.45 7.45 0 00-.478.198.798.798 0 01-.796-.064l-.453-.324a1.875 1.875 0 00-2.416.2l-.243.243a1.875 1.875 0 00-.2 2.416l.324.453a.798.798 0 01.064.796 7.448 7.448 0 00-.198.478.798.798 0 01-.608.517l-.55.092a1.875 1.875 0 00-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 01-.064.796l-.324.453a1.875 1.875 0 00.2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 01.796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 01.517-.608 7.52 7.52 0 00.478-.198.798.798 0 01.796.064l.453.324a1.875 1.875 0 002.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 01-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 001.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 01-.608-.517 7.507 7.507 0 00-.198-.478.798.798 0 01.064-.796l.324-.453a1.875 1.875 0 00-.2-2.416l-.243-.243a1.875 1.875 0 00-2.416-.2l-.453.324a.798.798 0 01-.796.064 7.462 7.462 0 00-.478-.198.798.798 0 01-.517-.608l-.091-.55a1.875 1.875 0 00-1.85-1.566h-.344zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                </svg></a> 
            </div>
	    </div>	
              
    </div>
	<!-- Export to pdf -->
    
      <div class="row card-deck mb-2 flex mt-2 pr-5 scard_head" id="total_sessions">        
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 " >  
            <?php print "\nTotal Sessions \n";
            //dd($data['interval']);            
            if(isset($data['interval'])){
            $interval= $data['interval'];
            }
           ?>
            <div id="divtoSession" class="scard-score"></div>
            <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
            <span id="id_ses_precent" class=""> </span>
            </div>
            <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>    
        </div> 
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 scard_head " id="total_pageviews">
        
        <?php 
          print "\nTotal pageviews \n";
         ?>
			<div id="divpgViews"  class="scard-score"></div>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
        <span id="id_pv_precent" class=""> </span>
        </div>
        <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>
		</div> 
    <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 scard_head" id="total_users">
        <?php
        print "Total Users";      
       ?>
		<div  id="divtotalUsers" class="scard-score"></div>	
  
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
		<span id="id_tu_precent" class=""></span>
        </div>
        <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>
        </div> 
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 scard_head" id="new_users">
            <?php
           print "New Users";?>
		<div id="divnewUsers" class="scard-score"></div>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
        <span id="id_nu_precent"class=""></span>
            </div>
            <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>
        </div>
		</div>    
   
    <div id="tabs" class="card"> 
	
	<h1><b> Page Views, Sessions, Unique visitors chart</b></h1><br>
	<canvas id="myChartsp" class="detail_graph" > </canvas>	
    </div>
   
    <div class="row card-deck flex mt-2" id="top_referrals"> 		
        <div class="card sm:w-full md:w-full lg:w-1/2 m-2 p-2" id="card7">	
		
        <?php  
		echo '<h1><b>Top Devices </b></h1><br>'; 
		?>
          <canvas id="myChart" width="" height=""></canvas>
          </div> 
          
          <div class="card sm:w-full md:w-full lg:w-1/2 m-2 p-2" id="new_returning">
		 
            <?php 
				echo '<h1><b>New vs Returning visitors </b></h1><br>';
            ?>         
          <canvas id="newvsreturnchart" class= "chart-styles" ></canvas>         
          </div> 
      </div> 

<div class="row mt-2">     
    <div class="card p-2" id="average_duration"> 
	<h1><b> Average Session Duration </b></h1><br>
	<div class="row  fullwidth"  id="chartContainer">
	<canvas id="myChartaverage" class="detail_graph" > </canvas>
	</div>
		 
    </div>
	</div>	  
    
        <div class="row card-deck flex mt-2">
        <div class="card sm:w-full md:w-full lg:w-1/2 m-2 p-2" id="card8">		
        <h1><b>Top Referrals</b> </h1><br>
            <table id="dataTable1" class="stripe">
                <thead>
                    <tr>
                    <th class="text-left">Referrals</th>
                    <th>Sessions</th>
                    </tr>
                </thead>
                <tbody>
               
                </tbody>
            </table>
            
		
        </div>
        
       	 <div class="card sm:w-full md:w-full lg:w-1/2 m-2 p-2" id="topcountries">
		
		<h1><b>Top Countries</b> </h1><br>
             <table id="ctdataTable" class="stripe">
                <thead>
                    <tr>
                    <th class="text-left">Top Countries</th>
                    <th>Users</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
			</div>	
        </div>

        <div class="row mt-2 pdfpagebreak" >     
        <div class="card " id="most_visited_pages"> 
		<div id="new_page" >
            <h1><b> Most Visited Pages</b></h1><br>
            <table id="dataTable3" class="stripe">
    <thead>
        <tr>
            <th class="text-left">Page Title</th>
            <th class="text-left">Pageviews</th>
        </tr>
    </thead>
    <tbody>
        
        </tbody>
        </table>
    </div>
  </div>
</div>
<?php
     }
	 else{
        ?>
        <div class="row mt-2">   
 <div class="row  flex-auto">
        <div class="gcard_heading mb-2">
            <img src="https://statamic.vijaysoftware.com/garesource/img/vijay-icon-100x100.png" width="30px" alt="analytic icon">
            <span>GInsights Analytics</span>
        </div>
        
	    <div class="card ginsigts-con" id=""> 
       
		  <!-- Newly added -->         
		     <div class="ginsights-calendar mx-0" id="calendar" >
                <label  id="dateLabel" class="px-2  "for="datepicker"><h2>Select date:</h2></label>  
                <form  id="dateForm" action="<?php env('APP_URL')?>" method="post" >
                    @csrf                
                    <input type="hidden" id="period" name="period" value="custom"/>
                    
                    <input type="hidden" name="selectedid" value="<?php echo (($_REQUEST['selectedid']="")?$selectedid: $_REQUEST['selectedid'] ) ?>">
                    <input type="hidden" class="datepicker" id="datepicker1" name="dp1" value="{{$startDate}}">
                    <input type="hidden" class="datepicker" id="datepicker2" name="dp2" value="{{$endDate}}">
                    <input type="hidden" class="" id="drange" name="drange" value="">
                  
                        <div id="reportrange" class="daterange d-flex align-items: center;" name ="rrange" >
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>                        
                        </div>
                        <button id="subbtn" type="submit" value="Submit" id="submit" class="btn-primary py-1 px-4 ml-2" >Submit</button>
                </form> 
            </div> 
	    </div>	
              
    </div>		
        <div class="card text-center " id=""> 
            <h2> No data available for this date range. Update your date range.</h2><br>
        </div>
        </div>
     <?php
     }
  ?>
</body>
<script>
	$(function(){
	
            $(document).ready(function() {
                $('#reportrange ul li').on('click', function() {
                // Your click event handler code here
                alert('Clicked on dynamically generated element with id: ' + $(this).attr('id'));
            });

            $('#reportrange').on('show.daterangepicker', function(ev, picker) {
                setTimeout(function() {
                    picker.container.find('.ranges li').each(function() {
                        $(this).on('click', function() {
                            console.log('List item clicked: ' + $(this).text());
                            if($(this).text()=="Last 30 days"){                         
                                $('#period').val('30');
                            }
                            if($(this).text()=="Last 7 days"){                         
                                $('#period').val('7');
                            }
                            if($(this).text()=="Last 14 days"){                         
                                $('#period').val('14');
                            }
                            if($(this).text()=="yesterday"){                         
                                $('#period').val('1');
                            }
                            if($(this).text()=="Custom Range"){                         
                                $('#period').val('custom');
                            }
                            if($(this).text()=="1"){                         
                                $('#period').val('1');
                            }
                           

                        });
                    });
                }, 0);
            });
            
                $( "#tabs" ).tabs();
            
                var start='{{ $startDate }}';
                var end ='{{ $endDate }}';

               // console.log(start+"- "+end);
                cb(moment(start, 'YYYY - MM - DD '), moment(end, 'YYYY - MM - DD'));               
                function cb(start, end, ranges) {          
                
                    $('#datepicker1').val(start.format('MMMM D, YYYY'));
                    $('#datepicker2').val(end.format('MMMM D, YYYY')); 
                    $('#drange').val(ranges);      
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    
                }

                $('#reportrange').daterangepicker({
                
                    
                    maxDate: moment(),
                    ranges: {
                        'Last 7 days': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
                        'Last 14 days': [moment().subtract(14, 'days'), moment().subtract(1, 'days')],
                        'Last 30 days': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
                        'yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        
                    }
                }, cb);
            
                // Display the default date range in the calendar
            // cb(moment().subtract(7, 'days'), moment().subtract(1, 'days'));
            			
            });

            $(function(){
                $('#subbtn').click(function(){
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
            
                function showdiv(){				
				$('#pdfgen').removeClass('hidediv').addClass('showdiv');
				$('#subbtn').removeClass('hidediv').addClass('showdiv');
                $('#reportrange').removeClass('hidediv').addClass('showdiv');
                $('#dateLabel').removeClass('hidediv').addClass('showdiv');
               
			}
            $(function(){
					$('#pdfgen').click(function(){					
					$('#subbtn').addClass('hidediv');
                    $('#reportrange').addClass('hidediv');
                    $('#dateLabel').addClass('hidediv');
					$(this).addClass('hidediv');
                    
                      // Hide DataTable pagination
                    $('#dataTable3_paginate').hide();
                    $('#dataTable3_info').hide(); // Hide summary text
                    $('#dataTable3_filter').hide(); 
                    $('#dataTable3_length').hide();
                    
                    
                     // Create and show the loading animation
                    var loadingElement = document.createElement('div');
                    loadingElement.id = 'loadingAnimation';
                    loadingElement.style.position = 'fixed';
                    loadingElement.style.top = '0';
                    loadingElement.style.left = '0';
                    loadingElement.style.width = '100%';
                    loadingElement.style.height = '100%';
                    loadingElement.style.backgroundColor = '#f0f0f0'; 
                    loadingElement.style.display = 'flex';
                    loadingElement.style.justifyContent = 'center';
                    loadingElement.style.alignItems = 'center';
                    loadingElement.style.zIndex = '9999';
                    loadingElement.style.color = '#000000';
                    loadingElement.style.fontSize = '30px';
                   // loadingElement.innerText = 'Generating Pdf.Please wait....';
                    document.body.appendChild(loadingElement);

                    // Check which tab is active and remove the other tab link
                        var activeTab = $('#tabs .ui-tabs-active a').attr('href');
                        var inactiveTabLink;
                        if (activeTab === '#tabs-1') {
                            inactiveTabLink = $('a[href="#tabs-2"]').parent();
                        } else {
                            inactiveTabLink = $('a[href="#tabs-1"]').parent();
                        }
                        inactiveTabLink.detach();


                     // Format the start date
                    var startDate = '{{ $startDate }}';
                    var startDateObj = new Date(startDate);
                    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    var formattedStartDate = months[startDateObj.getMonth()] + ' ' + startDateObj.getDate() + getOrdinalSuffix(startDateObj.getDate()) + ' ' + startDateObj.getFullYear();

            
                    // Format the end date
                    var endDate = '{{ $endDate }}';
                    var endDateObj = new Date(endDate);
                    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    var formattedEndDate = months[endDateObj.getMonth()] + ' ' + endDateObj.getDate() + getOrdinalSuffix(endDateObj.getDate()) + ' ' + endDateObj.getFullYear();

						   var element = document.getElementById('content');
                        // Create a temporary header element
                            var headerText = 'Overview Report';
                            var headerElement = document.createElement('div');
                            headerElement.innerText = headerText;
                            headerElement.classList.add('hidden-element'); // Apply a class to hide it initially
                            
                            // Apply CSS styling to the header element
                            headerElement.style.position = 'absolute';   // Position it absolutely
                            headerElement.style.top = '0';               // Align to the top
                            headerElement.style.right = '0';             // Align to the right
                            headerElement.style.margin = '10px';         // Add some margin for padding
                            headerElement.style.fontWeight = 'bold';  
                            headerElement.style.fontSize = '17px';
                            headerElement.style.visibility = 'hidden';   
                            
                            // Insert the header element at the top of the content
                            element.style.position = 'relative';         // Ensure the parent element is positioned relatively
                            element.appendChild(headerElement);

                            // Insert the header element at the top of the content
                            element.insertBefore(headerElement, element.firstChild);
                            
                        // Generate the current date and time string
                            var now = new Date();
                            var month = ('0' + (now.getMonth() + 1)).slice(-2);
                            var day = ('0' + now.getDate()).slice(-2);
                            var year = now.getFullYear();
                            var hours = ('0' + now.getHours()).slice(-2);
                            var minutes = ('0' + now.getMinutes()).slice(-2);
                            var seconds = ('0' + now.getSeconds()).slice(-2);
                            var dateTimeString = `GInsights_Report_${month}-${day}-${year}-${hours}.${minutes}.${seconds}.pdf`;
                             
                            var baseUrl = window.location.origin;

                            // Add base URL to the content just below the header
                            var baseUrlElement = document.createElement('a');
                            baseUrlElement.href = baseUrl;
                            baseUrlElement.innerText = baseUrl;
                            baseUrlElement.style.position = 'absolute';
                            baseUrlElement.style.top = '22px'; // Adjust the positioning as needed
                            baseUrlElement.style.right = '0';
                            baseUrlElement.style.margin = '10px';
                            baseUrlElement.style.fontSize = '12px';
                           // baseUrlElement.style.color = '#007bff'; // Set the color to a hyperlink color
                            element.appendChild(baseUrlElement);


                            // Create elements for start date and end date
                            var dateRangeElement = document.createElement('div');
                            dateRangeElement.innerText = formattedStartDate + " - " + formattedEndDate;
                            dateRangeElement.style.position = 'absolute';
                            dateRangeElement.style.top = '40px'; // Adjust the positioning as needed
                            dateRangeElement.style.right = '0';
                            dateRangeElement.style.margin = '10px';
                            dateRangeElement.style.fontSize = '12px';
                            dateRangeElement.style.color = '#666'; // Adjust the color as needed
                            element.appendChild(dateRangeElement);

                            // Create and insert a horizontal line element
                            var hrElement = document.createElement('hr');
                            hrElement.style.position = 'absolute';
                            hrElement.style.top = '60px'; // Adjust the positioning as needed
                            hrElement.style.right = '0';
                            hrElement.style.width = '100%';
                            hrElement.style.margin = '10px 0';
                            hrElement.style.border = '1px solid #ccc'; // Adjust the styling as needed
                            element.appendChild(hrElement);

                            // Create a vertical line
                            var verticalLines = [];
                            [250, 500, 755].forEach(left => {
                                var verticalLineElement = document.createElement('div');
                                verticalLineElement.style.position = 'absolute';
                                verticalLineElement.style.top = '65px';
                                verticalLineElement.style.left = `${left}px`;
                                verticalLineElement.style.height = '180px';
                                verticalLineElement.style.borderLeft = '1px solid #ccc';
                                verticalLineElement.style.margin = '10px 0';
                                element.appendChild(verticalLineElement);
                                verticalLines.push(verticalLineElement);
                            });
                                                


						var opt = {
						  margin:       0.2,
						  filename:     dateTimeString,
						  image:        { type: 'jpeg', quality: 0.98 },
                          html2canvas:  { scale: 2 },						 
						  jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape', putTotalPages: true,compress: true},
                          //pagebreak: { mode: 'avoid-all', before: '#page2el' } // Ensure there's a new page for certain elements
                         
						};
                        
						
                        // Show the header element before generating the PDF
                        headerElement.style.visibility = 'visible';
                        baseUrlElement.style.visibility = 'visible';
                        dateRangeElement.style.visibility = 'visible';
                        hrElement.style.visibility = 'visible';
                        verticalLines.forEach(line => line.style.visibility = 'visible');

                        function disableClicks(element1) {
                        const clickableElements = element1.querySelectorAll('a');
                        clickableElements.forEach(el => {
                            el.dataset.clickEvent = el.onclick;
                            el.onclick = null;
                            el.dataset.href = el.getAttribute('href');
                            el.setAttribute('href', 'javascript:void(0);');
                        });
                        }

                        function enableClicks(element1) {
                        const clickableElements = element1.querySelectorAll('a');
                        clickableElements.forEach(el => {
                            if (el.dataset.clickEvent) {
                            el.onclick = el.dataset.clickEvent;
                            delete el.dataset.clickEvent;
                            }
                            if (el.dataset.href) {
                            el.setAttribute('href', el.dataset.href);
                            delete el.dataset.href;
                            }
                        });
                        }
                        const element1 = document.getElementById('tabs');
                        disableClicks(element1);

	
						// New Promise-based usage:
						//html2pdf().set(opt).from(element).save();	

                      //  html2pdf().set(opt).from(element).save().then(() => {
                        html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
                        var totalPages = pdf.internal.getNumberOfPages();

                        for (var i = 1; i <= totalPages; i++) {
                            pdf.setPage(i);
                           // var footerText = String(i);
                            var footerText = 'Page ' + String(i) + ' of ' + String(totalPages);
                            pdf.setFontSize(10); // Set the font size for the footer
                            var pageHeight = pdf.internal.pageSize.getHeight();
                            var pageWidth = pdf.internal.pageSize.getWidth();
                            pdf.text(footerText, pageWidth - 0.2, pageHeight - 0.1, { align: 'right' });
                            //pdf.text(footerText, pdf.internal.pageSize.getWidth() - 1, pageHeight - 0.5, { align: 'right' });
                        }
                    }).save().then(() => {
                           
                        enableClicks(element);
                        headerElement.style.visibility = 'hidden';
                        baseUrlElement.style.visibility = 'hidden';
                        dateRangeElement.style.visibility = 'hidden';
                        hrElement.style.visibility = 'hidden';
                        verticalLines.forEach(line => line.style.visibility = 'hidden');

                           // Re-add the removed tab link
                           inactiveTabLink.appendTo('#tabs ul');

                             // Show DataTable pagination
                            $('#dataTable3_paginate').show();
                            $('#dataTable3_info').show(); // Show summary text
                            $('#dataTable3_filter').show(); 
                            $('#dataTable3_length').show();
                            


                        // Remove the header element after generating the PDF
                            element.removeChild(headerElement);
                            element.removeChild(baseUrlElement);
                            element.removeChild(dateRangeElement);
                            element.removeChild(hrElement);

                            
                             // Hide and remove the loading animation
                            document.body.removeChild(loadingElement);
                        }, 0);	
					
						setTimeout(showdiv,1);					
						
					});
                
				});
                
                function getOrdinalSuffix(day) {
                    if (day % 10 === 1 && day !== 11) {
                        return 'st';
                    } else if (day % 10 === 2 && day !== 12) {
                        return 'nd';
                    } else if (day % 10 === 3 && day !== 13) {
                        return 'rd';
                    } else {
                        return 'th';
                    }
                }
       
	
	
	
	
	
	var data = <?php echo json_encode($data); ?>;
   // console.log(data);
	var interval=0;
	if(data!=null){
	var interval= data.interval;
	  processData(data,interval);
	}
    $('#dataTable1_filter').hide();
    $('#ctdataTable_filter').hide();
   /* $('label[for="dataTable1"]').hide();
    $('input[type="search"][aria-controls="dataTable1"]').hide();
    $('label[for="ctdataTable"]').hide();
    $('input[type="search"][aria-controls="ctdataTable"]').hide();*/
   
	})
	
	function processData(resultData,interval)
    {	
	console.log(resultData);
		var dates =0;
        var sessions=0;
		//Total Sessions data
		var totalsessions=resultData['totalsessions'];
		if (totalsessions >= 1000) {
            totalsessions = (totalsessions / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
			$("#divtoSession").text(totalsessions);			
            }
			else{
				$("#divtoSession").text(totalsessions);
			}
			if(resultData.sessionPercent!=0){
			var sessionPercent=parseFloat(resultData.sessionPercent.replace(/,/g, ''));  
			}
			else{sessionPercent=0;}			
            var sessionpercClass=(sessionPercent < 0 )? 'negative-value' : 'positive-value';
            var sessionpercspanClass=(sessionPercent < 0 )? 'arrow-down' : 'arrow-up';
            var sessionpercspanColor=(sessionPercent < 0 )? 'red' : 'green';
            var sessionpercspanSymbol=(sessionPercent < 0 )?  '↓' :  '↑';
            //console.log(sessionPercent);
			$("#id_ses_precent").addClass(sessionpercClass);
            $("#id_ses_precent span").addClass(sessionpercspanClass);
           // $('#id_ses_precent span').css('color', sessionpercspanColor);           
			$("#id_ses_precent").text(sessionpercspanSymbol + Math.abs(sessionPercent).toFixed(1)+"%") .css("color", sessionpercspanColor);;			
			
			//Total Pageviews data
			var totalpgviews=resultData['totalpgviews'];
            if (totalpgviews >= 1000) {
                totalpgviews = (totalpgviews / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
            }
           if(resultData.pgviewsPercent!=0){
            var pgviewsPercent=parseFloat(resultData.pgviewsPercent.replace(/,/g, ''));
		   }
		   else{
			var pgviewsPercent=0;   
		   }
            var pgviewsPercentClass=(pgviewsPercent < 0) ? 'negative-value' : 'positive-value';
			var pgviewsPercentspanClass=(pgviewsPercent < 0 )? 'arrow-down' : 'arrow-up';
            var pgviewsPercentColor=(pgviewsPercent < 0 )? 'red' : 'green';
            var pgviewsPercentSymbol=(pgviewsPercent < 0 )?  '↓' :  '↑';			           
			$("#divpgViews").text(totalpgviews);
            $("#id_pv_precent").addClass(pgviewsPercentClass);
            $("#id_pv_precent span").addClass(pgviewsPercentspanClass);         
			$("#id_pv_precent").text(pgviewsPercentSymbol + Math.abs(pgviewsPercent).toFixed(1)+"%").css("color", pgviewsPercentColor);
			//$("#id_pv_precent").text(pgviewsPercentSymbol + Math.abs(roundedPgviewsPercent)+"%").css("color", pgviewsPercentColor);
			//Total users
			var totalusers=resultData['totalusers'];
            if (totalusers >= 1000) {
                totalusers = (totalusers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
             }
			 if(resultData.totalusersPercent!=0){
			var totalusersPercent=parseFloat(resultData.totalusersPercent.replace(/,/g, ''));
			 }
	else{totalusersPercent=0;}
            var totalusersPercentClass=(totalusersPercent < 0) ? 'negative-value' : 'positive-value';
            var totalusersPercentspanClass=(totalusersPercent < 0 )? 'arrow-down' : 'arrow-up';
            var totalusersPercentColor=(totalusersPercent < 0 )? 'red' : 'green';
            var totalusersPercentSymbol=(totalusersPercent < 0 )?  '↓' :  '↑';
            $("#divtotalUsers").text(totalusers);
            $("#id_tu_precent").addClass(totalusersPercentClass);
            $("#id_tu_precent span").addClass(totalusersPercentspanClass);           
            //$("#id_tu_precent").text(totalusersPercentSymbol + Math.abs(roundedtotalusersPercent)+"%").css('color', totalusersPercentColor);
			 $('#id_tu_precent').text(totalusersPercentSymbol + Math.abs(totalusersPercent).toFixed(1)+"%").css('color', totalusersPercentColor);
           
			//New Users Data
			var newUsers=resultData['newusers'];
            if (newUsers >= 1000) {
                newUsers = (newUsers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
            }
			if(resultData['newusersPercent']!=0){
            var newusersPercent=parseFloat(resultData['newusersPercent'].replace(/,/g, ''));
			}
			else{
				newusersPercent=0;
			}
			
            var newusersPercentClass=(newusersPercent < 0) ? 'negative-value' : 'positive-value';
            var newusersPercentspanClass=(newusersPercent < 0 )? 'arrow-down' : 'arrow-up';
            var newusersPercentColor=(newusersPercent < 0 )? 'red' : 'green';
            var newusersPercentSymbol=(newusersPercent < 0 )?  '↓' :  '↑';
			$("#divnewUsers").text(newUsers);
            $("#id_nu_precent").addClass(newusersPercentClass);
            $("#id_nu_precent span").addClass(newusersPercentspanClass);
            $('#id_nu_precent span').css('color', newusersPercentColor);
           // $('#id_nu_precent ').text(newusersPercentSymbol + Math.abs(roundednewusersPercent)+"%").css('color', newusersPercentColor);
			 $('#id_nu_precent').text(newusersPercentSymbol + Math.abs(newusersPercent).toFixed(1)+"%").css('color', newusersPercentColor);
			
			//Sessions graph
           

            var ctx = document.getElementById("myChartsp").getContext("2d");
            dates=resultData['sessionsCurrent']['encodedDates'];
			//console.log(dates);
            dates = dates.split(",");            
			var sessions =resultData['sessionsCurrent']['encodedSessions'];
			sessions = sessions.replaceAll(/\"/g,'')
            var sessions = sessions.substring(1, sessions.length-1);
            sessions = sessions.split(",");

            // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
            var formattedDates = dates.map(function(date) {
            const momentDate = moment(date, 'YYYY/MM/DD');
            const day = momentDate.format('D'); // Day of the month without leading zero
            const month = momentDate.format('MMM'); // Abbreviated month name in uppercase
			return day + ' ' + month;
             });
			 if(formattedDates== "Invalid date Invalid date"){						
				formattedDates="";
			}
			
			pg_view_dates = resultData['pageviewsCurrent']['encodedDates'];          
            pg_view_dates = pg_view_dates.split(",");
			var pageviews = resultData['pageviewsCurrent']['encodedpageviews'];
			pageviews = pageviews.replaceAll(/\"/g,'')
            pageviews = pageviews.substring(1, pageviews.length-1);
            pageviews = pageviews.split(",");
            // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
           /* var formattedDates = pg_view_dates.map(function(date) {
            const momentDate = moment(date, 'YYYY/MM/DD');
            const day = momentDate.format('D'); // Day of the month without leading zero
            const month = momentDate.format('MMM'); // Abbreviated month name in uppercase

            return day + ' ' + month;
            });*/
			//console.log(formattedDates);

			
			//data for unique users
					
						dates=resultData['uniqueusersCurrent']['encodedDates'];
                        dates = dates.split(",");
						//  var sessions = resultData['graphsessions']['encodedSessions'];
						var uniqueusers =resultData['uniqueusersCurrent']['encodedUsers'];
					
                        uniqueusers = uniqueusers.replaceAll(/\"/g,'')
                        var uniqueusers = uniqueusers.substring(1, uniqueusers.length-1);
                        uniqueusers = uniqueusers.split(",");

                        // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                      /*  var formattedDates = dates.map(function(date) {
                        const momentDate = moment(date, 'YYYY/MM/DD');
                        const day = momentDate.format('D'); // Day of the month without leading zero
                        const month = momentDate.format('MMM'); // Abbreviated month name in uppercase

                        return day + ' ' + month;
                        });*/		
					//data for unique users end
	//All in one graph					
	if(window.bar1) {
        window.bar1.destroy();
    }
	var canvas = document.getElementById("myChartsp");
	var ctx = canvas.getContext("2d");	
						
	window.bar1 = new Chart(ctx, {
    type: "line",
    data: {
        labels: formattedDates,
        datasets: [
            {
                label: "Pageviews ",
                data: pageviews,
                borderColor: "green",
                fill: false,
            },
			{
                label: "Sessions",
                data: sessions,
                borderColor: "blue",
                fill: false,
            },
            {
                label: "Unique Visitors",
                data: uniqueusers, 
                borderColor: "red",
                fill: false,
            }
        ]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    onClick(e, legendItem, legend) {
                        // Prevent the default behavior of the legend item click
                        //e.stopPropagation();
                    }
                }
            }
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    parser: 'DD/MM/YYYY',
                    tooltipFormat: 'DD/MM/YYYY',
                    unit: 'day',
                    displayFormats: {
                        day: 'DD/MM/YYYY'
                    }
                },
                ticks: {
                    maxTicksLimit: 10
                }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: "Count"
                },
                ticks: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        },
        legend: {
            onClick(e, legendItem, legend) {
                // Prevent the default behavior of the legend item click
                //e.stopPropagation();
            }
        }
    }
});

						
						//All in one graph ends
					
		//data for Average duration
			           
                        
						var averageMinutes=0;
						var averageSessions="";						
						var formattedTimes="";
						var formattedDates_avg="";
						if (resultData.averageSessionCurrent.encodedDates !== undefined && resultData.averageSessionCurrent.encodedDates !== null) {		  
						dates_avg=resultData['averageSessionCurrent']['encodedDates'];
						 // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                        dates_avg = dates_avg.split(",");
						 dates_avg = JSON.parse(resultData['averageSessionCurrent']['encodedDates']);
						var formattedDates_avg = dates_avg.map(function(date) {
                        const momentDate = moment(date, 'YYYY/MM/DD');
                        const day = momentDate.format('D'); // Day of the month without leading zero
                        const month = momentDate.format('MMM'); // Abbreviated month name in uppercase
                        return day + ' ' + month;
                        });
						if(formattedDates_avg== "Invalid date Invalid date"){						
						formattedDates_avg="";
						}
						
						  const averageSessions =JSON.parse( resultData['averageSessionCurrent']['encodedAverage']);
							averageMinutes = averageSessions.map(timeToMinutes);			
					// Parse each element and convert it to the desired format
					 formattedTimes = averageMinutes.map(formatTime);			
					//data for Average duration end
			
	}
				// Function to adjust the canvas height dynamically
        function adjustChartHeight() {
            var chartContainer  = document.getElementById('chartContainer');
            var canvas = document.getElementById('myChartaverage');
            // Adjust the canvas height based on the container height
            canvas.height = chartContainer.clientHeight;
        }

        // Call the function to set the initial height
        adjustChartHeight();
		 
		if (resultData.averageSessionCurrent.encodedAverage !== undefined && resultData.averageSessionCurrent.encodedAverage !== null) 
		{
			
           if (window.avg) {
			window.avg.destroy();
		}
		var canvas = document.getElementById("myChartaverage");
		var a_ctx = canvas.getContext("2d");
			
            window.avg= new Chart(a_ctx, {
                type: "line",
                data: {
                    labels: formattedDates_avg,
                    datasets: [                                
					{
						label: 'Average Session Duration (minutes)',
						data: formattedTimes, 
						borderColor: "orange",
						fill: false,
					}
                    ]
                    },
					options: {
                tooltips: {
                    callbacks: {
                        // Customize the tooltip label
                        label: function(tooltipItem, data) {
                            return 'Average Session Duration (minutes): '+tooltipItem.yLabel.toFixed(2); // Format with 2 decimal places
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            // Customize the y-axis label format
                            callback: function(value, index, values) {
                                return value.toFixed(2); // Format with 2 decimal places
                            }
                        }
                    }]
                },
        legend: {
            onClick(e, legendItem, legend) {
                // Prevent the default behavior of the legend item click
               // e.stopPropagation();
            }
        }
				}
                   /* options: {
						responsive: true,
						maintainAspectRatio: false,
						 hover: {
							mode: null  // Disable hover interaction
						},
                        plugins: {
                            legend: {
                              labels: {
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  //e.stopPropagation();
                                }
                              }
                            }, afterRender: function(chart) {
                        // Ensure the canvas is properly referenced
                        if (chart.canvas) {
                            var chartHeightavg = chart.canvas.clientHeight;
                            chart.canvas.style.height = chartHeightavg + 'px';
                        }
                    }
                          },
                            scales: {
                            x: {
                                type: 'time',
                                time: {
                                parser: 'DD/MM/YYYY',
                                tooltipFormat: 'DD/MM/YYYY',
                                unit: 'day',
                                displayFormats: {
                                    day: 'DD/MM/YYYY'
                                }
                                }
                               
                            },
							 y: {                    
						title: {
                        display: true,
                        text: 'Average Session Time (Minutes)'
                    }
                },
                            },
                            

                        }*/
            
                        });
						
                    }
                    else{	  					
                      	
	
			if (window.avg) {
					window.avg.destroy();
				}
	var canvas = document.getElementById("myChartaverage");
	var a_ctx = canvas.getContext("2d");
	
				window.avg= new Chart(a_ctx, {
                type: "line",
                data: {
                    labels: formattedDates_avg,
                    datasets: [                                
					{
						label: 'Average Session Duration (minutes)',
						data: [0], 
						borderColor: "orange",
						fill: false,
					}
                    ]
                    },
					options: {
                tooltips: {
                    callbacks: {
                        // Customize the tooltip label
                        label: function(tooltipItem, data) {
                            return 'Average Session Duration (minutes): '+tooltipItem.yLabel.toFixed(2); // Format with 2 decimal places
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            // Customize the y-axis label format
                            callback: function(value, index, values) {
                                return value.toFixed(2); // Format with 2 decimal places
                            }
                        }
                    }]
                },legend: {
            onClick(e, legendItem, legend) {
                // Prevent the default behavior of the legend item click
                //e.stopPropagation();
            }
        }
				}
				});
                    }
			//Average Duration graph End
			
			
			
			//Device Category chart
            if(window.device != undefined) {
            window.device.destroy();
            //var canvas = document.getElementById('deviceChart');
			var canvas = document.getElementById('myChart');
            canvas.width = Math.min(600, 400); // Set width to a maximum of 1200px
            canvas.height = Math.min(200, 200); // Set height to a maximum of 200px
            }

			//var ctx2 = document.getElementById("deviceChart").getContext("2d");
			var ctx2 = document.getElementById("myChart").getContext("2d");
			var deviceCategories = resultData['deviceCategory']['deviceCategories'] ;
            var sessions = resultData['deviceCategory']['percentages'] ;
           
            window.device = new Chart(ctx2, {
                    type: "doughnut",
                        data: {
                            labels: deviceCategories,
                            datasets: [
                            {
                                data: sessions,
                                backgroundColor: ["#FF6384", "#36A2EB","#FFC300","#9966FF","#4BC0C0","#000000"]

                            }
                            ]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: "right",
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                 // e.stopPropagation();
                                },
                                labels: {
                                generateLabels: (chart) => {

                                    const labels = [];
                                    const datasets = chart.data.datasets;
                                    for (let i = 0; i < datasets.length; i++) {                                        
                                    const dataset = datasets[i];
                                   
                                    const dataValues = datasets[i].data.map(value => parseFloat(value));
                                  
                                   for (let j = 0; j < dataset.data.length; j++) {
                                        labels.push({
                                            text: `${chart.data.labels[j].charAt(0).toUpperCase()}${chart.data.labels[j].slice(1)}` + 
                                ` `+` ${dataset.data[j]}%`,
                                            fillStyle: dataset.backgroundColor[j],
                                            strokeStyle: dataset.backgroundColor[j],
                                        });
                                    }                                   
                                    }
                                   
                                    return labels;
                                }                               
                                }
                            },
                            tooltips: {
                              callbacks: {
                                label: function(tooltipItem, data) {
                                    var dataset = data.datasets[tooltipItem.datasetIndex];
                                    var currentValue = dataset.data[tooltipItem.index];
                                    return currentValue + '%';
                                } 
                             }
                            }
                        },

                    });
				//Device Category chart End
					
		
				//new vs return chart
                if(window.visitor != undefined) {
                window.visitor.destroy();
                var canvas = document.getElementById('newvsreturnchart');
                canvas.width = Math.min(600, 400); // Set width to a maximum of 1200px
                canvas.height = Math.min(200, 200); // Set height to a maximum of 200px
				}

                var ctx1 = document.getElementById("newvsreturnchart").getContext("2d");
                const visitordata = resultData['visitors']['visitors'];
              
                const visitors_val = [];
                const count = [];
                const percentages = [];
				if (Array.isArray(visitordata) && visitordata.length > 0) {
                for (const visitor of visitordata) {
                if (visitor.visitorsvalue && visitor.visitorsvalue !== '(not set)') {
                visitors_val.push(visitor.visitorsvalue);
                percentages.push(visitor.percentages);
                }
                }
				}
                  
                window.visitor = new Chart(ctx1, {
                    type: "doughnut",
                    data: {
                        labels: visitors_val,
                        datasets: [
                            {
                                 data: percentages,
                                backgroundColor: ["#0099c6","#316395","#ffce56"]
                            }
                            ]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: "right",
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  //e.stopPropagation();
                                },
                                labels: {
                                generateLabels: (chart) => {

                                    const labels = [];
                                    const datasets = chart.data.datasets;
                                    for (let i = 0; i < datasets.length; i++) {                                        
                                    const dataset = datasets[i];
                                  
                                    const dataValues = datasets[i].data.map(value => parseFloat(value));
                                 
                                   for (let j = 0; j < dataset.data.length; j++) {
                                        labels.push({
                                            text: `${chart.data.labels[j].charAt(0).toUpperCase()}${chart.data.labels[j].slice(1)}` + 
                                ` `+` ${dataset.data[j]}%`,
                                            fillStyle: dataset.backgroundColor[j],
                                            strokeStyle: dataset.backgroundColor[j],
                                        });
                                    }                                   
                                    }
                                   
                                    return labels;
                                }                               
                                }
                            },
                            tooltips: {
                              callbacks: {
                                label: function(tooltipItem, data) {
                                    var dataset = data.datasets[tooltipItem.datasetIndex];
                                    var currentValue = dataset.data[tooltipItem.index];
                                    return currentValue + '%';
                                } 
                             }
                            }
                        }
                    });
					
					//new vs return chart End
					
			//Top referels
			 var $tableBody = $('#dataTable1 tbody');
			var count_ref = 0;

            if (resultData.topreferrals && resultData.topreferrals[0]) {
				
                $.each(resultData.topreferrals[0], function(index, entry) {
                    if (count_ref < 10) {
                        var $row = $('<tr></tr>');
                        $row.append('<td>' + $('<div>').text(entry.referrer).html() + '</td>');
                        $row.append('<td align="center">' + $('<div>').text(entry.sessions).html() + '</td>');
                        $tableBody.append($row);
                        count_ref++;
                    }
                });
            } else {
                $tableBody.append('<tr><td colspan="2">The \'rows\' key is not present in the array.</td></tr>');
            }
         
            if (resultData.topreferrals && resultData.topreferrals[0]) {				
			$('#dataTable1').dataTable({
			  lengthChange: false,
			  fixedHeader: true,
			  responsive: true,
			  paging: false,
			  order: [
                        [1, 'desc']
                    ],
			  
			  lengthMenu: [10],
			  initComplete: function() {
			console.log('@@@ init complete @@@');
       
			}
			});
        }
		//Top referels End		
		
		//Top countries 
			var $tableBody = $('#ctdataTable tbody');
var count_cnt = 0;

// Assuming resultData.topcountries[0] contains an array of country data
if (resultData.topcountries && resultData.topcountries[0]) {
    $.each(resultData.topcountries[0], function(index, entry) {
        if (entry.topcountries !== '(not set)' && entry.topcountries !== ' ') {
            if (count_cnt < 10) {
                if (entry.topcountries !== "") {
                    // Convert the country name to ISO country code (you might need a mapping function here)
                    var countryCode = getCountryCode(entry.topcountries); // Function to map country names to ISO codes
                    
                    // Create table row with flag icon and country name
                    var $row = $('<tr></tr>');
                    $row.append('<td>' + '<span class="fi fi-' + countryCode.toLowerCase() + '"></span> ' + $('<div>').text(entry.topcountries).html() + '</td>');
                    $row.append('<td align="center">' + $('<div>').text(entry.totalusers).html() + '</td>');
                    
                    $tableBody.append($row);
                    count_cnt++;
                }
            }
        }
    });
} else {
    $tableBody.append('<tr><td colspan="2">The \'rows\' key is not present in the array.</td></tr>');
}

$('input[type="search"][aria-controls="ctdataTable"]').hide();

if (resultData.topcountries && resultData.topcountries[0]) {
    $('#ctdataTable').dataTable({
        lengthChange: true,
        fixedHeader: true,
        responsive: true,
        paging: false,
        order: [
            [1, 'desc']
        ],
        lengthMenu: [10],
        initComplete: function() {
            // console.log('@@@ init complete @@@');
        }
    });
}

// Example function to map country names to ISO codes
function getCountryCode(countryName) {
    var countryCodes = {
        'Afghanistan' : 'af',
    'Albania' : 'al',
    'Algeria' : 'dz',
    'Andorra' : 'ad',
    'Angola' : 'ao',
    'Antigua and Barbuda' : 'ag',
    'Argentina' : 'ar',
    'Armenia' : 'am',
    'Australia' : 'au',
    'Austria' : 'at',
    'Azerbaijan' : 'az',
    'Bahamas' : 'bs',
    'Bahrain' : 'bh',
    'Bangladesh' : 'bd',
    'Barbados' : 'bb',
    'Belarus' : 'by',
    'Belgium' : 'be',
    'Belize' : 'bz',
    'Benin' : 'bj',
    'Bhutan' : 'bt',
    'Bolivia' : 'bo',
    'Bosnia and Herzegovina' : 'ba',
    'Botswana' : 'bw',
    'Brazil' : 'br',
    'Brunei' : 'bn',
    'Bulgaria' : 'bg',
    'Burkina Faso' : 'bf',
    'Burundi' : 'bi',
    'Cabo Verde' : 'cv',
    'Cambodia' : 'kh',
    'Cameroon' : 'cm',
    'Canada' : 'ca',
    'Central African Republic' : 'cf',
    'Chad' : 'td',
    'Chile' : 'cl',
    'China' : 'cn',
    'Colombia' : 'co',
    'Comoros' : 'km',
    'Congo (Congo-Brazzaville)' : 'cg',
    'Costa Rica' : 'cr',
    'Croatia' : 'hr',
    'Cuba' : 'cu',
    'Cyprus' : 'cy',
    'Czech Republic' : 'cz',
    'Democratic Republic of the Congo' : 'cd',
    'Denmark' : 'dk',
    'Djibouti' : 'dj',
    'Dominica' : 'dm',
    'Dominican Republic' : 'do',
    'Ecuador' : 'ec',
    'Egypt' : 'eg',
    'El Salvador' : 'sv',
    'Equatorial Guinea' : 'gq',
    'Eritrea' : 'er',
    'Estonia' : 'ee',
    'Eswatini' : 'sz',
    'Ethiopia' : 'et',
    'Fiji' : 'fj',
    'Finland' : 'fi',
    'France' : 'fr',
    'Gabon' : 'ga',
    'Gambia' : 'gm',
    'Georgia' : 'ge',
    'Germany' : 'de',
    'Ghana' : 'gh',
    'Greece' : 'gr',
    'Grenada' : 'gd',
    'Guatemala' : 'gt',
    'Guinea' : 'gn',
    'Guinea-Bissau' : 'gw',
    'Guyana' : 'gy',
    'Haiti' : 'ht',
    'Honduras' : 'hn',
    'Hungary' : 'hu',
    'Iceland' : 'is',
    'India' : 'in',
    'Indonesia' : 'id',
    'Iran' : 'ir',
    'Iraq' : 'iq',
    'Ireland' : 'ie',
    'Israel' : 'il',
    'Italy' : 'it',
    'Ivory Coast' : 'ci',
    'Jamaica' : 'jm',
    'Japan' : 'jp',
    'Jordan' : 'jo',
    'Kazakhstan' : 'kz',
    'Kenya' : 'ke',
    'Kiribati' : 'ki',
    'Kuwait' : 'kw',
    'Kyrgyzstan' : 'kg',
    'Laos' : 'la',
    'Latvia' : 'lv',
    'Lebanon' : 'lb',
    'Lesotho' : 'ls',
    'Liberia' : 'lr',
    'Libya' : 'ly',
    'Liechtenstein' : 'li',
    'Lithuania' : 'lt',
    'Luxembourg' : 'lu',
    'Madagascar' : 'mg',
    'Malawi' : 'mw',
    'Malaysia' : 'my',
    'Maldives' : 'mv',
    'Mali' : 'ml',
    'Malta' : 'mt',
    'Marshall Islands' : 'mh',
    'Mauritania' : 'mr',
    'Mauritius' : 'mu',
    'Mexico' : 'mx',
    'Micronesia' : 'fm',
    'Moldova' : 'md',
    'Monaco' : 'mc',
    'Mongolia' : 'mn',
    'Montenegro' : 'me',
    'Morocco' : 'ma',
    'Mozambique' : 'mz',
    'Myanmar (Burma)' : 'mm',
    'Namibia' : 'na',
    'Nauru' : 'nr',
    'Nepal' : 'np',
    'Netherlands' : 'nl',
    'New Zealand' : 'nz',
    'Nicaragua' : 'ni',
    'Niger' : 'ne',
    'Nigeria' : 'ng',
    'North Korea' : 'kp',
    'North Macedonia' : 'mk',
    'Norway' : 'no',
    'Oman' : 'om',
    'Pakistan' : 'pk',
    'Palau' : 'pw',
    'Panama' : 'pa',
    'Papua New Guinea' : 'pg',
    'Paraguay' : 'py',
    'Peru' : 'pe',
    'Philippines' : 'ph',
    'Poland' : 'pl',
    'Portugal' : 'pt',
    'Qatar' : 'qa',
    'Romania' : 'ro',
    'Russia' : 'ru',
    'Rwanda' : 'rw',
    'Saint Kitts and Nevis' : 'kn',
    'Saint Lucia' : 'lc',
    'Saint Vincent and the Grenadines' : 'vc',
    'Samoa' : 'ws',
    'San Marino' : 'sm',
    'Sao Tome and Principe' : 'st',
    'Saudi Arabia' : 'sa',
    'Senegal' : 'sn',
    'Serbia' : 'rs',
    'Seychelles' : 'sc',
    'Sierra Leone' : 'sl',
    'Singapore' : 'sg',
    'Slovakia' : 'sk',
    'Slovenia' : 'si',
    'Solomon Islands' : 'sb',
    'Somalia' : 'so',
    'South Africa' : 'za',
    'South Korea' : 'kr',
    'South Sudan' : 'ss',
    'Spain' : 'es',
    'Sri Lanka' : 'lk',
    'Sudan' : 'sd',
    'Suriname' : 'sr',
    'Sweden' : 'se',
    'Switzerland' : 'ch',
    'Syria' : 'sy',
    'Taiwan' : 'tw',
    'Tajikistan' : 'tj',
    'Tanzania' : 'tz',
    'Thailand' : 'th',
    'Timor-Leste' : 'tl',
    'Togo' : 'tg',
    'Tonga' : 'to',
    'Trinidad and Tobago' : 'tt',
    'Tunisia' : 'tn',
    'Türkiye' : 'tr',
    'Turkmenistan' : 'tm',
    'Tuvalu' : 'tv',
    'Uganda' : 'ug',
    'Ukraine' : 'ua',
    'United Arab Emirates' : 'ae',
    'United Kingdom' : 'gb',
    'United States' : 'us',
    'Uruguay' : 'uy',
    'Uzbekistan' : 'uz',
    'Vanuatu' : 'vu',
    'Vatican City' : 'va',
    'Venezuela' : 've',
    'Vietnam' : 'vn',
    'Yemen' : 'ye',
    'Zambia' : 'zm',
    'Zimbabwe' : 'zw',
        // Add other countries as needed
    };
    return countryCodes[countryName] || 'unknown'; // Default to 'unknown' if country is not found
}
			//Top countries End
			
			//Most Visited Pages
			var $tableBody = $('#dataTable3 tbody');
            if (resultData['mostvisitedpages']) {
				
                $.each(resultData['mostvisitedpages'], function(key, visitedpages) {
                    var i = 0;
                    var rowCount = 0;
                    while (i < visitedpages.length) {
                            var $row = $('<tr></tr>');
                            $row.append('<td>' + $('<div>').text(visitedpages[i].pageTitle).html() + '&nbsp</td>');
                            $row.append('<td align="center"><i>' + $('<div>').text(visitedpages[i].pageviews).html() + '</i></td>');
                            $tableBody.append($row);
                              // Add page break class if rowCount exceeds 20
                            if (rowCount % 15 === 0 && rowCount > 0) {
                                $row.addClass('pdfpagebreak');
                            }
                        
                        i++;
                        rowCount++;
                    }
                });
            } else {
                $tableBody.append('<tr><td colspan="2">No data available.</td></tr>');
            }
            if (resultData['mostvisitedpages']) {
			$('#dataTable3').dataTable({
			  lengthChange: true,
			  fixedHeader: true,
			  responsive: true,
			  paging: true,
			  order: [
                        [1, 'desc']
                    ],
			  
			  lengthMenu: [25, 50, 75, 100],
			  initComplete: function() {
			console.log('@@@ init complete @@@'); 
			
			}
			});
        }
			//Most Visited Pages End
			// Convert time strings to total minutes
     function timeToMinutes(timeStr) {
        var parts = timeStr.split(':').map(Number);
        if (parts.length === 2) {  // MM:SS format				
            return parts[0] + parts[1]/60 ;
			
        } else if (parts.length === 3) {  // HH:MM:SS format		
            return parts[0] * 60 + parts[1] + parts[2]/60 ;
        }
        return 0;
    }
	
	// Function to convert minutes to a formatted time string
function formatTime(minutes) {
    var totalSeconds = minutes * 60;
    var hours = (Math.floor(totalSeconds / 3600)).toFixed(2);
    var remainingSeconds = totalSeconds % 3600;
    var mins = Math.floor(remainingSeconds / 60);
    var seconds = Math.round(remainingSeconds % 60);

   if (hours > 0) {
	   return ((hours*60)+mins)+"."+seconds;
    } else {
			if((seconds.toString().replace(/\D/g, '').length)==1){				
				 return mins+".0"+seconds;
			}
			else{
			
        return mins+"."+seconds;
			}
    }
}
	}
</script>
@stop