@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">
        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
       <!-- <div class="gcard_heading">
            <img src="https://statamic.vijaysoftware.com/garesource/img/vijay-icon-100x100.png" width="30px" alt="analytic icon">
            <span>GInsights - {{ __('Google Analytics Data') }}</span>
        </div>-->
        <?php 
		$baseUrl = asset('');
		$user_role = Auth::user()->super;
		
		?>
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/jquery-3.6.0.min.js"></script>
        
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/Chart.js"></script> 
        
        
        <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/css/jquery.dataTables.min.css">
      <!--  <link rel="stylesheet" href="../../../../resources/css/ga_style.css">-->
        <link rel="stylesheet" href="https://statamic.vijaysoftware.com/garesource/css/ga_style.css">
        <link rel="stylesheet" href="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	        
    <!-- Include Date Range Picker library -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/css/daterangepicker.css" />
    <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/daterangepicker.min.js"></script>
  
    <!--new-->

    <link rel="stylesheet" href="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/css/jquery-ui.css">
    <script src="<?php echo $baseUrl;?>vendor/vijaysoftware/ginsights/js/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <?php  
          use Illuminate\Support\Str;
    ?>            
	</header>    
	
    <body> 
    <!-- Data retreived from controller -->
    <?php 
     $data = json_decode($data, true); 
    //dd($data); 
   // dd($data['topcountries'][0]);  
     if($data != null)
     {
       // sleep(500); 
    ?>
    
    
    <div class="container" id="content">	  
        <div class="row  flex-auto">
        <div class="gcard_heading">
            <img src="https://statamic.vijaysoftware.com/garesource/img/vijay-icon-100x100.png" width="30px" alt="analytic icon">
            <span>GInsights Analytics</span>
        </div>
        
	    <div class="card ginsigts-con" id=""> 
       
		  <!-- Newly added -->
         
		     <div class="ginsights-calendar mx-0" id="calendar" style="">
                <label  id="dateLabel" class="px-2  "for="datepicker"><h2>Select date:</h2></label>  
                <form  id="dateForm" action="<?php env('APP_URL')?>" method="post" >
                    @csrf                
                    <input type="hidden" name="period" value="custom"/>
                                     
                    <input type="hidden" name="selectedid" value="<?php echo (($_REQUEST['selectedid']="")?$selectedid: $_REQUEST['selectedid'] ) ?>">
                    <input type="hidden" class="datepicker" id="datepicker1" name="dp1" value="{{$startDate}}">
                    <input type="hidden" class="datepicker" id="datepicker2" name="dp2" value="{{$endDate}}">
                    <input type="hidden" class="" id="drange" name="drange" value="">
                  
                        <div id="reportrange" class="d-flex align-items: center;" name ="rrange" style="background: #fff; cursor: pointer; padding: 7px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>                        
                        </div>
                        <button id="subbtn" type="submit" value="Submit" id="submit" class="btn-primary py-1 px-4 ml-2" >Submit</button>
                </form> 
            </div>  
                
		    <div class="ginsights-head-rt">
            <button id="pdfgen" class="btn-primary ml-2 mr-1">Generate PDF Report</button>
             <!--   <a href="#" class="btn-primary ml-2 mr-1">Generate PDF Report</a> -->
                <a href="?reset=true" class="ml-auto ggear"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
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
            ///sample code
            $prvsdates = json_decode($data['sessionsPrvs']['encodedDates']);
           // dd($prvsdates);
            $currentdates = json_decode($data['sessionsCurrent']['encodedDates']);           

            $prvssessions = json_decode($data['sessionsPrvs']['encodedSessions']);
            $currentsessions = json_decode($data['sessionsCurrent']['encodedSessions']);
              // Calculate the total
            //$totalsession = array_sum($currentsessions); 
            $totalsession = $data['totalsessions'];
            dd( $data['sessionPercent']);
            $sessionPercent =(float)  $data['sessionPercent'];
            //echo $data['totalsessions'];
            //echo $sessionPercent;
            
            if ($totalsession > 0) {
                $formattedTotal = $totalsession > 1000 ? number_format($totalsession / 1000, 1) . 'K' : $totalsession;
                echo '<div id="divtoSession" class="scard-score">' . $formattedTotal .  ' </div>';
            } else {
                echo '0';
            }
            
            //calculate session variation of total session
            $session_variation = ((array_sum($currentsessions)-array_sum($prvssessions))/array_sum($prvssessions))*100 ; 
           ?>
           
            <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
            
            
           
            <span class="arrow-<?php echo $sessionPercent < 0 ? 'down' : 'up'; ?>">
              
              <?php 
              if($sessionPercent < 0)
              {
                echo "↓" ;
              }
              else{
                echo "↑";
              }
              //dd(round(abs($sessionPercent)));
              echo round(abs($sessionPercent)).'%';
                ?>
            </span>
                  
            <?php //echo round(abs($session_variation), 2).'%';
                
                //calculating session variation daywise
                $variation = array();
                for($i=0;$i<count($prvssessions);$i++)
                { 
                    if (isset($prvssessions[$i]) && isset($currentsessions[$i])) {
                    
                        $variation[$i] = ((($currentsessions[$i] - $prvssessions[$i])/$prvssessions[$i]) * 100);
                    // echo "\n" . round(abs($variation[$i]),2) . "%\n"; 
                    }
                
                }            
                ?>     
                  
            </div>
            <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>    
        </div> 
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 scard_head " id="total_pageviews">
        
        <?php 
          print "\nTotal pageviews \n";

          
            $prvsdates = json_decode($data['pageviewsPrvs']['encodedDates']);
            $currentdates = json_decode($data['pageviewsCurrent']['encodedDates']);           

            $prvspgviews = json_decode($data['pageviewsPrvs']['encodedpageviews']);
            $currentpgviews =  json_decode($data['pageviewsCurrent']['encodedpageviews']);
            
        // Calculate the total
       // $totalpgviews = array_sum($currentpgviews); 
        $totalpgviews = $data['totalpgviews'];
        if ( $totalpgviews > 0) {
            $formattedpg =  $totalpgviews > 1000 ? number_format( $totalpgviews / 1000, 1) . 'K' : $totalpgviews;
            echo '<div  class="scard-score">' . $formattedpg . '</div>';
        } else {
            echo '0';
        }                
       // print $totalpgviews > 0 ? '<div class="scard-score">' . number_format($totalpgviews/1000,1).'K</div>': 0 ;
        
        //calculate session variation of total pgviews
        $pgviews_variation = ((array_sum($currentpgviews)-array_sum($prvspgviews))/array_sum($prvspgviews))*100 ; 
        $pgviewsPercent =(float) $data['pgviewsPercent'];
        ?>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
        <span class="arrow-<?php echo $pgviewsPercent < 0 ? 'down' : 'up'; ?>">
              
              <?php 
              if($pgviewsPercent < 0)
              {
                echo "↓" ;
              }
              else{
                echo "↑";
              }
              echo round(abs($pgviewsPercent)).'%';
                ?>
         </span>
       <?php
//echo round(abs($pgviews_variation), 2).'%';
   
     //calculating session variation daywise
     $variationpg = array();
     for($i=0;$i<count($prvspgviews);$i++)
     { 
         if (isset($prvspgviews[$i]) && isset($currentpgviews[$i])) {
            
             $variationpg[$i] = ((($currentpgviews[$i] - $prvspgviews[$i])/$prvspgviews[$i]) * 100);
            // echo "\n" . round(abs($variation[$i]),2) . "%\n"; 
         }
         
     }
        ?>
        </div>
        <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>
    </div> 
    <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 scard_head" id="total_users">
        <?php
        print "Total Users";      
       
        //$prvsdates = $data['totalusersPrvs']['dates'];
        //dd($prvsdates);
       // $currentdates = $data['totalusersCurrent']['dates'];           
        $prvstotalusers = $data['totalusersPrvs']['totalusers']; 
        $currenttotalusers = $data['totalusersCurrent']['totalusers']; 

      // Calculate the total
      //$totalusers = array_sum($currenttotalusers); 
      $totalusers = $data['totalusers'];
      
      if ( $totalusers> 0) {
        $formattedusers = $totalusers > 1000 ? number_format( $totalusers / 1000, 1) . 'K' : $totalusers;
        echo '<div  class="scard-score">' . $formattedusers . '</div>';
    } else {
        echo '0';
    }       
     // print $totalusers > 0 ? '<div class="scard-score">' . number_format($totalusers/1000,1).'K</div>' : 0;
      
      //calculate session variation of total pgviews
      $totalusers_variation = ((array_sum($currenttotalusers)-array_sum( $prvstotalusers))/array_sum($prvstotalusers))*100 ; 
      //echo $totalusers_variation < 0 ? 'negative-value' : 'positive-value';
      $totalusersPercent =(float) $data['totalusersPercent'] 
      ?>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
    
        <span class="arrow-<?php echo  $totalusersPercent < 0 ? 'down' : 'up'; ?>">
              
              <?php 
              if( $totalusersPercent < 0)
              {
                echo "↓" ;
              }
              else{
                echo "↑";
              }
              echo round(abs($totalusersPercent)).'%';
                ?>
                </span>
            </div>
            <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>
        </div> 

        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 scard_head" id="new_users">
            <?php
           print "New Users";    
          
          // $prvsdates = json_decode($data['newusersPrvs']['dates']);
          // $currentdates = json_decode($data['newusersCurrent']['dates']);    
             $prvsnewusers = $data['newusersPrvs']['newusers'];
             $currentnewusers = $data['newusersCurrent']['newusers'];
  
         // Calculate the total
         $newusers = array_sum($currentnewusers);    
         $newusers =$data['newusers'];              
         if ( $newusers> 0) {
            $formattedusers = $newusers > 1000 ? number_format( $newusers/ 1000, 1) . 'K' : $newusers;
            echo '<div class="scard-score">' . $formattedusers . '</div>';
        } else {
            echo '0';
        }       
         //  print $newusers > 0 ? '<div class="scard-score">' . number_format($newusers/1000,1).'K</div>': 0;
         
         //calculate session variation of total pgviews
         $newusers_variation = ((array_sum($currentnewusers)-array_sum( $prvsnewusers))/array_sum($prvsnewusers))*100 ; 
         $newusersPercent =(float) $data['newusersPercent']
         ?>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
        <span class="arrow-<?php echo $newusersPercent < 0 ? 'down' : 'up'; ?>">
              
              <?php 
              if($newusersPercent < 0)
              {
                echo "↓" ;
              }
              else{
                echo "↑";
              }
              echo round(abs($newusersPercent)).'%';
                ?>
                </span>
            </div>
            <div class="scard-compare">vs. Previous <?php echo  $interval;?>  Days</div>
        </div>

    </div>    
   
      <div id="tabs">
        <ul>
            <li> <a href="#tabs-1">Sessions </a></li>
            <li><a href="#tabs-2">Pageviews</a></li>
        </ul>
      <div id="tabs-1">
      <div class=" row card mt-2 mb-2">     
      <h2><b><i class='fa fa-user' ></i>&nbsp; Sessions </b></h2><br> 
      <div class="card flex" id="card2">       
            <?php       
                      
                    $encodedDates=json_encode($currentdates);
                    $array = json_decode($encodedDates, true);
                    $values = array_values($array);
                    $encodedString1 = json_encode($values); 
                    
                    $encodedSessions = json_encode($currentsessions); 
                    $array = json_decode($encodedSessions, true);
                    $values = array_values($array);
                    $encodedString2 = json_encode($values);

                    $encodedvariation=json_encode($variation);
                    $array = json_decode($encodedvariation, true);
                    $values = array_values($array);
                    $encodedvariations = json_encode($values);             
                    
                ?>    
                
                <canvas id="myChartsp" style="width:800px; height:300px;max-width:1200px;"></canvas>
                <!-- Script to create the chart -->
                <script>
                   
                    document.addEventListener("DOMContentLoaded", function() {
                        var ctx = document.getElementById("myChartsp").getContext("2d");
                        var dates = <?php echo $encodedString1; ?>;
                        var sessions = <?php echo $encodedString2; ?>;
                        var variations = <?php echo $encodedvariations; ?>;
                        var user_role="<?php echo $user_role;?>";
                        if(user_role=="0")
                    	{
                    	 $('.ggear ').css('display','none');	
                    	}
                        //console.log(dates);
                      //  console.log(variations);
                        // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                       /* var formattedDates = dates.map(function(date) {
                        return moment(date, 'YYYY/MM/DD').format('DD/MM/YYYY');
                        });*/
                        var formattedDates = dates.map(function(date) {
                        const momentDate = moment(date, 'YYYY/MM/DD');
                        const day = momentDate.format('D'); // Day of the month without leading zero
                        const month = momentDate.format('MMM'); // Abbreviated month name in uppercase

                        return day + ' ' + month;
                        });

                        new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: formattedDates,
                            datasets: [
                            {
                                label: "Sessions ",                                
                                data: sessions,                                                             
                                borderColor: "blue",
                                fill: false,                                
                            }                                                  
                            ]
                        },
                        options: {                                                         
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
                           
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    var value = tooltipItem.yLabel;
                                    var variation = variations[tooltipItem.index];

                                    // Use arrows for positive and negative variations
                                    var arrow = variation >= 0 ? '↑' : '↓';
                                    
                                     // Check if variation is a valid number before calling toFixed
                                     if (typeof variation === 'number' && !isNaN(variation)) {
                                            return datasetLabel + ': ' + value + ' \n ' + arrow + ' ' + variation.toFixed(2) + '%';
                                        } else {
                                            // Handle cases where variation is not a number
                                            console.warn('Invalid variation value at index', tooltipItem.index, ':', variation);
                                            return datasetLabel + ': ' + value + ' \n ' + arrow + ' N/A%';
                                        }

                                    //return datasetLabel + ': ' + value + ' \n ' + arrow + ' ' + variation.toFixed(2) + '%';
                                }
                            }
                        },
                        legend: {
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  e.stopPropagation();
                                }
                            }
                        }
                        
                        });
                    });
                </script>
                </div>

        </div>    
    </div>
    <div id="tabs-2">
        <div class=" row card mt-2 mb-2">     
            <h2><b> <i class='fas fa-eye'></i>&nbsp; Pageviews </b></h2><br> 
        <div class="card flex" id="card4">       
            <?php                               
           
           $encodedDates=json_encode($currentdates);          
           $array = json_decode($encodedDates, true);
           $values = array_values($array);
           $encodedpgd = json_encode($values);

           $encodedpageviews = json_encode($currentpgviews); 
           $array = json_decode($encodedpageviews, true);
           $values = array_values($array);
           $encodedpg = json_encode($values);
      
           $encodedvariationpg=json_encode($variationpg);
           $array = json_decode($encodedvariationpg, true);
           $values = array_values($array);
           $encodedvariationspg = json_encode($values);
        
            ?> 
                <canvas id="myChartpv" style="width:800px; height:300px;max-width:1200px;"></canvas>
                <!-- Script to create the chart -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var ctx = document.getElementById("myChartpv").getContext("2d");
                        var dates = <?php echo $encodedpgd; ?>;
                        var pageviews = <?php echo $encodedpg; ?>;
                       var variationspg = <?php echo $encodedvariationspg; ?>;
                         //  console.log(variationspg);  

                        // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                      /*  var formattedDates = dates.map(function(date) {
                        return moment(date, 'YYYY/MM/DD').format('DD/MM/YYYY');
                        });*/
                        var formattedDates = dates.map(function(date) {
                        const momentDate = moment(date, 'YYYY/MM/DD');
                        const day = momentDate.format('D'); // Day of the month without leading zero
                        const month = momentDate.format('MMM'); // Abbreviated month name in uppercase

                        return day + ' ' + month;
                        });
                       
                        new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: formattedDates,
                            datasets: [
                            {
                                label: "Pageviews ",                               
                                data: pageviews,
                                borderColor: "green",
                                fill: false,                                
                            }                            
                            ]
                        },
                        options: {
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
                           
                            tooltips: {
                                mode: 'label',
                                callbacks: {
                                    label: function (tooltipItem, data) {
                                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                        var value = tooltipItem.yLabel;
                                        var variation = variationspg[tooltipItem.index];

                                        // Use arrows for positive and negative variations
                                        var arrow = variation >= 0 ? '↑' : '↓';
                                        // Check if variation is a valid number before calling toFixed
                                        if (typeof variation === 'number' && !isNaN(variation)) {
                                            return datasetLabel + ': ' + value + ' \n ' + arrow + ' ' + variation.toFixed(2) + '%';
                                        } else {
                                            // Handle cases where variation is not a number
                                            console.warn('Invalid variation value at index', tooltipItem.index, ':', variation);
                                            return datasetLabel + ': ' + value + ' \n ' + arrow + ' N/A%';
                                        }
                                        //return datasetLabel + ': ' + value + ' \n ' +  arrow + ' ' + variation.toFixed(2) + '%';
                                    }
                                }
                            },
                            legend: {
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  e.stopPropagation();
                                }
                            }                    
                        }
                        });
                    });
                </script> 
            </div>    
        </div>
    </div>
    </div>

   
    <div class="row card-deck flex mt-2" id="top_referrals">             
        <div class="card sm:w-full md:w-full lg:w-1/2 m-2" id="card7">
        <?php                                   
				// Display the results								
				$encodeddevices = json_encode($data['deviceCategory']['deviceCategories']);
				$encodedsessions = json_encode($data['deviceCategory']['percentages']);
                echo '<h1><b>Top Devices </b></h1><br>';    
            ?>
          <canvas id="myChart" width="" height=""></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById("myChart").getContext("2d");
                               
                var deviceCategories = <?php echo $encodeddevices; ?>;
                var sessions = <?php echo $encodedsessions;  ?>;      
                console.log(deviceCategories);            
                    new Chart(ctx, {
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
                                  e.stopPropagation();
                                },
                                labels: {
                                generateLabels: (chart) => {

                                    const labels = [];
                                    const datasets = chart.data.datasets;
                                    for (let i = 0; i < datasets.length; i++) {                                        
                                    const dataset = datasets[i];
                                    //console.log(dataset );
                                    const dataValues = datasets[i].data.map(value => parseFloat(value));
                                   // console.log(labels);
                                   // console.log(dataValues );
                                   for (let j = 0; j < dataset.data.length; j++) {
                                        labels.push({
                                            text: `${chart.data.labels[j].charAt(0).toUpperCase()}${chart.data.labels[j].slice(1)}` + 
                                ` `+` ${dataset.data[j]}%`,
                                            fillStyle: dataset.backgroundColor[j],
                                            strokeStyle: dataset.backgroundColor[j],
                                        });
                                    }                                   
                                    }
                                    //console.log(labels);
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
                });			
            </script>
          </div> 
     <!-- </div> 
	  
	    // New vs returning visitors 
    <div class="row  mt-2" id="new_returning"> -->       
          <div class="card sm:w-full md:w-full lg:w-1/2 m-2 " id="new_returning">          
                 
            <?php                
              //   dd($data['visitors']['visitors']);             
				// Display the results
				echo '<h1><b>New Vs Returning visitors </b></h1><br>';
				
                $newvsreturnkey=array();
                $newvsreturnvalue=array();
                $newvsreturnpercentage=array();
                foreach ($data['visitors']['visitors'] as $visitor) {
                  if(!empty($visitor['visitorsvalue']) && $visitor['visitorsvalue'] !== '(not set)'){
                    $visitorinfo =[
                        'visitorsvalue' => $visitor['visitorsvalue'],
                        'count' =>  $visitor['count'] ,
                        'percentages' =>  $visitor['percentages']
                    ];
                    array_push($newvsreturnkey,$visitor['visitorsvalue']);
                    array_push($newvsreturnvalue,$visitor['count']);
                    array_push($newvsreturnpercentage,$visitor['percentages']);
                    }
                  }
                
				$encodedvisitors = json_encode($newvsreturnkey);			
                $encodedcount = json_encode($newvsreturnvalue);
                $encodedpercentage=json_encode($newvsreturnpercentage);
                //dd($encodedvisitors);     
            ?>
         
          <canvas id="newvsreturnchart" class= "chart-styles" style=""></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                var ctx1 = document.getElementById("newvsreturnchart").getContext("2d");
                var visitors = <?php echo $encodedvisitors; ?>;
                //console.log(visitors);
                var count = <?php echo $encodedcount;  ?>;
                var percentage = <?php echo $encodedpercentage;  ?>;
                //console.log(count);      
     
                    new Chart(ctx1, {
                        type: "doughnut",
                        data: {
                            labels: visitors,
                            datasets: [
                                {
                                    data: percentage,
                                    backgroundColor: ["#0099c6","#316395","#ffce56"]
                                }
                            ]
                        },
                        options: {                           
                            responsive: false,
                            legend: {
                                position: "right",
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  e.stopPropagation();
                                },
                                labels: {
                                generateLabels: (chart) => {

                                    const labels = [];
                                    const datasets = chart.data.datasets;
                                    for (let i = 0; i < datasets.length; i++) {                                        
                                    const dataset = datasets[i];
                                    console.log(dataset );
                                    const dataValues = datasets[i].data.map(value => parseFloat(value));
                                   // console.log(labels);
                                   // console.log(dataValues );
                                   for (let j = 0; j < dataset.data.length; j++) {
                                        labels.push({
                                            text: `${chart.data.labels[j].charAt(0).toUpperCase()}${chart.data.labels[j].slice(1)}` + 
                                ` `+` ${dataset.data[j]}%`,
                                            fillStyle: dataset.backgroundColor[j],
                                            strokeStyle: dataset.backgroundColor[j],
                                        });
                                    }                                   
                                    }
                                    //console.log(labels);
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
                });			
            </script>
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
                <?php
         //      dd($data['topreferrals'][0]);
                   /* if (isset($data['topreferrals']['topref'])) {
                        dd($data['topreferrals']);
                        foreach ($data['topreferrals']['topref'] as $key => $referrals): 
 dd($referrals);
                                    if($referrals['sessions'] > '1'){
                                        echo '<tr><td><i>' . $referrals['referrer'] . '</i></td><td align="center">&nbsp;' . $referrals['sessions'] . '</td></tr>';
                                    }
                                                
                        endforeach;           
                    }else{
                        echo "The 'rows' key is not present in the array.";
                        }*/
                        $count =0;
                        if (isset($data['topreferrals'][0])) {
                            foreach ($data['topreferrals'][0] as $entry) {     
                                // Loop through each key-value pair in the sub-array
                               //  if($entry['topcountries'] !== '(not set)' && $entry['topcountries']!== ' '){                        
                                  if($count < 10){
                                   // echo '<tr><td><i>' . $entry['topcountries'] . '</i></td><td align="center">&nbsp;' . $entry['totalusers'] . '</td></tr>';
                                   echo '<tr><td><i>' . htmlspecialchars($entry['referrer']) . '</i></td><td align="center">' . htmlspecialchars($entry['sessions']) . '</td></tr>'; 
                                   $count++;
                                   }
                                   
                            }
                                   
                        }else{
                            echo "The 'rows' key is not present in the array.";
                            }
                            ?>
                </tbody>
            </table>
            <script>
            $(document).ready(function() {

                $('#reportrange ranges ul li').on('click', function() {
                // Your click event handler code here
                alert('Clicked on dynamically generated element with id: ' + $(this).attr('id'));
            });
            
                $( "#tabs" ).tabs();
                $('#dataTable1').DataTable({
                    searching: false,
                    paging: false,
                    order: [
                        [1, 'desc']
                    ],

                });
                $('#dataTable2').DataTable();
				$('#ctdataTable').DataTable({
                    searching: false,
                    paging: false,
                    order: [
                        [1, 'desc']
                    ],
                });				
            
                var start='{{ $startDate }}';
                var end ='{{ $endDate }}';

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
                          
                           <p style="font-size: 35px;background-color:#ffff;"><i class="fa fa-refresh fa-spin"></i><span style="font-size: 35px; font-weight: bold; background-color:#ffff;">Loading...</span></p>   
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

                            


						var opt = {
						  margin:       0.2,
						  filename:     dateTimeString,
						  image:        { type: 'jpeg', quality: 0.98 },
                          html2canvas:  { scale: 2 },						 
						  jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        
						};
                        // Show the header element before generating the PDF
                        headerElement.style.visibility = 'visible';
                        baseUrlElement.style.visibility = 'visible';
                        dateRangeElement.style.visibility = 'visible';
                        hrElement.style.visibility = 'visible';

	
						// New Promise-based usage:
						//html2pdf().set(opt).from(element).save();	

                       html2pdf().set(opt).from(element).save().then(() => {
                        headerElement.style.visibility = 'hidden';
                        baseUrlElement.style.visibility = 'hidden';
                        dateRangeElement.style.visibility = 'hidden';
                        hrElement.style.visibility = 'hidden';

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
        </script>
		
        </div>
       	 <div class="card sm:w-full md:w-full lg:w-1/2 m-2" id="topcountries">
 <h1><b>Top Countries</b> </h1><br>
             <table id="ctdataTable" class="stripe">
                <thead>
                    <tr>
                    <th class="text-left">Top Countries</th>
                    <th>Users</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                //dd($data['topcountries'][0]);
                $count=0;
                    if (isset($data['topcountries'][0])) {
                        foreach ($data['topcountries'][0] as $entry) {     
                            // Loop through each key-value pair in the sub-array
                             if($entry['topcountries'] !== '(not set)' && $entry['topcountries']!== ' '){                        
                              if($count < 10){
                               // echo '<tr><td><i>' . $entry['topcountries'] . '</i></td><td align="center">&nbsp;' . $entry['totalusers'] . '</td></tr>';
                               echo '<tr><td><i>' . htmlspecialchars($entry['topcountries']) . '</i></td><td align="center">' . htmlspecialchars($entry['totalusers']) . '</td></tr>'; 
                               $count++;
                               }
                             }   
                        }
                       /* foreach ($data['topcountries']['topcountries'] as $key => $countries): 
                                
                                    if($countries['totalusers'] > '100'){
                                        echo '<tr><td><i>' . $countries['topcountries'] . '</i></td><td align="center">&nbsp;' . $countries['totalusers'] . '</td></tr>';
                                    }
                                                
                        endforeach; */          
                    }else{
                        echo "The 'rows' key is not present in the array.";
                        }         
                    ?>
                </tbody>
            </table>
</div>	
        </div>

        <div class="row mt-2">     
        <div class="card " id="most_visited_pages"> 
            <h1><b> Most Visited Pages</b></h1><br>
            <table id="dataTable2" class="stripe">
    <thead>
        <tr>
            <th class="text-left">Page Title</th>
            <th class="text-left">Pageviews</th>
        </tr>
    </thead>
    <tbody>
        <?php
		$i=0;      

		if (isset($data['mostvisitedpages'])) {
			foreach ($data['mostvisitedpages'] as $key => $visitedpages): 
					 
					  $i=0;
					  while ($i < count($visitedpages)) {
						if($visitedpages[$i]['pageviews'] >'0'){
							echo '<tr><td><i>' . $visitedpages[$i]['pageTitle'] . '&nbsp</td><td><center>' . $visitedpages[$i]['pageviews'] . '</i></center></td></tr>';
						}
				$i++;    
			 }                   
			endforeach;           
		}
		else{
			echo "No data available.";
         }
        ?>
        </tbody>
        </table>
    </div>
  </div>
  
   
</div>

<?php
     }
	 else{
        $totalsession = 0;
        $totalpgviews =0;
        $totalusers =0;
        $newusers =0;?>
        <div class="row mt-2">     
        <div class="card text-center " id=""> 
            <h2> No data available</h2><br>
        </div>
        </div>
     <?php
     }
  ?>
</body>
@stop