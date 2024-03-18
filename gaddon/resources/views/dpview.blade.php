@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

	<header class="mb-3">
        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
        <div class="gcard_heading">
            <img src="https://statamic.vijaysoftware.com/garesource/img/vijay-icon-100x100.png" width="30px" alt="analytic icon">
            <span>GInsights - {{ __('Google Analytics Data') }}</span>
        </div>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	    <script src="https://code.jquery.com/jquery-3.7.0.slim.js" integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@^2.29.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
      <!--  <link rel="stylesheet" href="../../../../resources/css/ga_style.css">-->
        <link rel="stylesheet" href="https://statamic.vijaysoftware.com/garesource/css/ga_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	        
    <!-- Include Date Range Picker library -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js"></script>
  
    <!--new-->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <?php  
          use Illuminate\Support\Str;
    ?>            
	</header>    
	
    <body> 
    <!-- Data retreived from controller -->
    <?php 
     $data = json_decode($data, true); 
     //dd($data); 
     if($data != null)
     { 
    ?>
    
    
    <div class="container" id="content">
	  
        <div class="row  flex-auto">
        
	    <div class="card ginsigts-con" id=""> 
       
		  <!-- Newly added -->
         
		     <div class="ginsights-calendar mx-0" id="calendar" style="">
                <label class="px-2  "for="datepicker"><h2>Select date:</h2></label>  
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
                        <input type="submit" value="Submit" class="btn-primary py-1 px-4 ml-2" >
                </form> 
            </div>  
                
		    <div class="ginsights-head-rt">
                <a href="#" class="btn-primary ml-2 mr-1">Generate PDF Report</a>
                <a href="?reset=true" class="ml-auto "> 
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
           // dd($data);
            
            ///sample code
            $prvsdates = json_decode($data['sessionsPrvs']['encodedDates']);
            $currentdates = json_decode($data['sessionsCurrent']['encodedDates']);           

            $prvssessions = json_decode($data['sessionsPrvs']['encodedSessions']);
            $currentsessions = json_decode($data['sessionsCurrent']['encodedSessions']);
              // Calculate the total
            $totalsession = array_sum($currentsessions);                  
            print $totalsession > 0 ?'<div id="divtotSession" class="scard-score">' . number_format($totalsession/1000,1).'K</div>': 0;
            
            //calculate session variation of total session
            $session_variation = ((array_sum($currentsessions)-array_sum($prvssessions))/array_sum($prvssessions))*100 ; 
           ?>
            <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
                <span class="arrow-<?php echo $session_variation < 0 ? 'down' : 'up'; ?>" style="color: <?php echo $session_variation< 0 ? 'red' : 'green'; ?>"><?php echo $session_variation < 0 ? '↓' : '↑'; ?></span> 
                  
            <?php echo round(abs($session_variation), 2).'%';
                
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
        </div> 
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 scard_head " id="total_pageviews">
        
        <?php 
          print "\nTotal pageviews \n";

          
            $prvsdates = json_decode($data['pageviewsPrvs']['encodedDates']);
            $currentdates = json_decode($data['pageviewsCurrent']['encodedDates']);           

            $prvspgviews = json_decode($data['pageviewsPrvs']['encodedpageviews']);
            $currentpgviews =  json_decode($data['pageviewsCurrent']['encodedpageviews']);

        // Calculate the total
        $totalpgviews = array_sum($currentpgviews);                  
        print $totalpgviews > 0 ? '<div class="scard-score">' . number_format($totalpgviews/1000,1).'K</div>': 0 ;
        
        //calculate session variation of total pgviews
        $pgviews_variation = ((array_sum($currentpgviews)-array_sum($prvspgviews))/array_sum($prvspgviews))*100 ; 
        ?>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
        <span class="arrow-<?php echo $pgviews_variation < 0 ? 'down' : 'up'; ?>" style="color: <?php echo $pgviews_variation < 0 ? 'red' : 'green'; ?>"><?php echo $pgviews_variation < 0 ? '↓' : '↑'; ?></span>        
       <?php
        echo round(abs($pgviews_variation), 2).'%';
   
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
      $totalusers = array_sum($currenttotalusers);                  
      print $totalusers > 0 ? '<div class="scard-score">' . number_format($totalusers/1000,1).'K</div>' : 0;
      
      //calculate session variation of total pgviews
      $totalusers_variation = ((array_sum($currenttotalusers)-array_sum( $prvstotalusers))/array_sum($prvstotalusers))*100 ; 
      //echo $totalusers_variation < 0 ? 'negative-value' : 'positive-value';
      
      ?>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
            <span class="arrow-<?php echo $totalusers_variation < 0 ? 'down' : 'up'; ?>" style="color: <?php echo $totalusers_variation < 0 ? 'red' : 'green'; ?>"><?php echo $totalusers_variation < 0 ? '↓' : '↑'; ?></span>
                <?php echo round(abs($totalusers_variation), 2).'%';
                ?>
            </div>
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
         print $newusers > 0 ? '<div class="scard-score">' . number_format($newusers/1000,1).'K</div>': 0;
         
         //calculate session variation of total pgviews
         $newusers_variation = ((array_sum($currentnewusers)-array_sum( $prvsnewusers))/array_sum($prvsnewusers))*100 ; 
         ?>
        <div id="divsessionPerc" class="ml-auto flex justify-end negative-value">
            <span class="arrow-<?php echo $newusers_variation < 0 ? 'down' : 'up'; ?>" style="color: <?php echo $newusers_variation < 0 ? 'red' : 'green'; ?>"><?php echo $newusers_variation < 0 ? '↓' : '↑'; ?></span>

            <?php echo round(abs($newusers_variation), 2).'%';?>
            </div>
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
                                    return datasetLabel + ': ' + value + ' \n ' + arrow + ' ' + variation.toFixed(2) + '%';
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

                        // Sort the dates in chronological order
                        formattedDates.sort(function(a, b) {
                            return moment(a, 'DD/MM/YYYY').toDate() - moment(b, 'DD/MM/YYYY').toDate();
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
                                        
                                        return datasetLabel + ': ' + value + ' \n ' +  arrow + ' ' + variation.toFixed(2) + '%';
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
          <div class="card sm:w-full md:w-full lg:w-1/2 m-2" id="card6">                  
            <?php                
                              
				// Display the results
				echo '<h1><b>Top Devices </b></h1><br>';
				echo '<table>';
				echo '<tr><th >Device Category &nbsp; </th><th>Sessions &nbsp; </th><th>Percentage</th></tr>';
			   
				$i=0;
					foreach ($data['deviceCategory']['deviceCategories'] as $key => $category):      
					
						echo '<tr>';              
						$sessionCount =0;
						
						echo '<td>' . $category  . '</td>';
						
						$sessionCount = $data['deviceCategory']['sessions'];
						$devicepercentage =$data['deviceCategory']['percentages'];           
							echo '<td>' .  $sessionCount[$i] . '</td>';           
							echo '<td>' . $devicepercentage[$i]  . '%</td>';
							$i++;
							echo '</tr>';
					endforeach;   
				   
				echo '</table>';  

				$encodeddevices = json_encode($data['deviceCategory']['deviceCategories']);
				$encodedsessions = json_encode($data['deviceCategory']['percentages']);
                     
            ?>
          </div>  
        <div class="card sm:w-full md:w-full lg:w-1/2 m-2" id="card7">
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
      </div> 
	  
	    <!--  New vs returning visitors -->
    <div class="row  mt-2" id="new_returning">        
          <div class="card " id="card7">          
                 
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
         
          <canvas id="newvsreturnchart" class= "chart-styles" style="width:500px; height:250px;"></canvas>
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
                                    backgroundColor: ["#ff6384","#cc65fe","#ffce56"]
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
    
        <div class="row mt-2">
        <div class="card p-2" id="card8">
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
                
                    if (isset($data['topreferrals']['topref'])) {
                        foreach ($data['topreferrals']['topref'] as $key => $referrals): 
                                
                                    if($referrals['sessions'] > '1'){
                                        echo '<tr><td><i>' . $referrals['referrer'] . '</i></td><td align="center">&nbsp;' . $referrals['sessions'] . '</td></tr>';
                                    }
                                                
                        endforeach;           
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
                $('#dataTable1').DataTable();
                $('#dataTable2').DataTable();            
            
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
        </script>
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