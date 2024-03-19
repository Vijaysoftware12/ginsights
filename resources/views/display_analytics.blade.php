@section('title', Statamic::crumb(__('Analytics'), __('Utilities')))
@extends('statamic::layout')
@section('content')

<header class="mb-3">

        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
        <h1>{{ __('Analytics Data') }}</h1>
        
        <script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	    <script src="https://code.jquery.com/jquery-3.7.0.slim.js" integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@^2.29.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../../vendor/analytics/ga-addon/resources/css/ga_style.css"/>
        <?php  
          use Illuminate\Support\Str;
        ?>
        
</header>
    
<body>    
    
<div class="container" >
    <div class="row card-deck mb-2  flex  ">
        <div class="card w-1/2 calendar_card">
        <div id="nocalendar">
            <form method="post" action="<?php env('APP_URL')?>">
            @csrf
          
            <label for="period" class="font-semibold">Select a period:</label>
            <input type="hidden" name="selectedid" value="<?php echo $_REQUEST['selectedid'] ?>"/>
            <select name="period" id="period" >
            
                <option value="7" @if(isset($_REQUEST['period']) && $_REQUEST['period'] == '7') selected @endif>7 days ago</option>
                <option value="30" @if(isset($_REQUEST['period']) && $_REQUEST['period'] == '30') selected @endif>30 days ago</option>
                <option value="yesterday" @if(isset($_REQUEST['period']) && $_REQUEST['period'] == 'yesterday') selected @endif>Yesterday</option>
                <option value="custom" @if(isset($_REQUEST['period']) && $_REQUEST['period'] == 'custom') selected @endif>Custom Date Range</option>
            </select>
            <input type="submit" value="Submit" class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            </form>
            
        </div>
        <div id="calendar" style="visibility:hidden">
            <form  id="dateForm" action="<?php env('APP_URL')?>" >
            @csrf
            <label for="datepicker"><h2>Select date:</h2></label> 
            <input type="hidden" name="selectedid" value="<?php echo $_REQUEST['selectedid'] ?>"/>
            <input type="date" class="datepicker" id="datepicker" name="dp" value="{{$selectedDate}}" />
            <input type="submit" value="Submit"/>
        
            </form>
        </div>
        </div>
        <div class="card w-1/2 ml-2 day_card"> 
      
        
        @if (isset($selectedDate) === '7daysAgo')
            <h2 class ="p-2" >Analytics data 7 days ago</h2>
            @else
            <h3 class ="p-2" >Analytics data from : {{ date('d-m-Y', strtotime($selectedDate)) }} to Today</h3>
            
            @endif  

        </div>
    </div>
    <div class=" row card-deck  flex  ">
                <div class="card w-1/2 "><h2 ><i class='fa fa-user' ></i>   &nbsp;Sessions</h2></div>
                <div class="card w-1/2 "><h2 ><i class='fas fa-eye'></i> &nbsp;Pageviews</h2></div>  
    </div>     
    <div class=" row card flex">         
            <?php    
                 /*   $sessions = $sessions_pageviews['totalsForAllResults']['ga:sessions'];
                   $pageviews = $sessions_pageviews['totalsForAllResults']['ga:pageviews'];
                    $users = $sessions_pageviews['totalsForAllResults']['ga:users'];
                  $avgSessionDuration = $sessions_pageviews['totalsForAllResults']['ga:avgSessionDuration'];
                                      
                    $dates = [];
                    $sessions = [];
                    $pageviews = [];
                    $today = date('Y-m-d');
                    
                    //echo $selectedDate;echo $today;
                   $timeDiff = strtotime($today) - strtotime($selectedDate);
                   
                    // Calculate the time difference in seconds
                   $daysDiff = round($timeDiff / (60 * 60 * 24));                  
                    
                    foreach ($sessions_pageviews['rows'] as $row) {
                        $dates[] = $row[0];
                        $sessions[] = $row[1];
                        $pageviews[] = $row[2];
                    } 
                    $pastDaysDates = array_slice($dates, -$daysDiff);
                    $pastDaysSessions = array_slice($sessions, -$daysDiff);
	                $pastDayspageviews = array_slice($pageviews, -$daysDiff); 
                    
                    $encodedDates = json_encode($pastDaysDates);
                    //echo $encodedDates;
                    
                    $encodedSessions = json_encode($pastDaysSessions);
                    $encodedPageviews = json_encode($pastDayspageviews);*/
                ?>   
        
        <canvas id="myChartsp" style="width:800px; height:300px;max-width:1200px;"></canvas>
        <!-- Script to create the chart -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var ctx = document.getElementById("myChartsp").getContext("2d");
                        var dates = <?//php echo $encodedDates; ?>;
                        var sessions = <?//php echo $encodedSessions; ?>;
                        var pageviews = <?//php echo $encodedPageviews; ?>;
                        
                                        // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                        var formattedDates = dates.map(function(date) {
                        return moment(date, 'YYYY/MM/DD').format('DD/MM/YYYY');
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
                                
                            },
                            {
                                label: "Pageviews",
                                data: pageviews,
                                borderColor: "green",
                                fill: false
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
                            }
                        }
                        });
                    });
                </script> 
                                        
    </div>    

    <div class=" row card-deck mb-5  flex mt-2 pr-5 session_card" > 
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 " >  
            <?php print "\nTotal Sessions \n"; 
           //$totalsession=array_sum($sessions);          
           //print '<div>' . number_format($totalsession/1000,1).'K</div>';?>
           
        </div>
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 pgview_card">
        <?php print "\nPageviews \n"; 
       // $totalpageviews=array_sum($pageviews)?>
        <?php//print '<div>' . number_format($totalpageviews/1000,1). 'K</div>';?>
            
        </div>
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 users_card" >
        <?php print "\nTotal Users \n"; ?>
            <?php// print '<div>' .number_format($users/1000,1). 'K</div>';?>
            
        </div>
        <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 avgsession_card" >
        //<?php print "\nAvg Session  \n"; ?>
            <?php// print '<div>' .round($avgSessionDuration). ' s</div>';?> 
            
        </div> 
          
    </div>

    <div class="row card-deck mb-5  flex pr-5">        
        <div class="card w-1/2 mr-2 top_devices_card1" id="card4">  
            <?php                
                $deviceCategories = [];
                $percentages = [];                   
                  // Display the results
                  echo '<h1><b>Top Devices </b></h1><br>';
                  echo '<table>';
                  echo '<tr><th >Device Category &nbsp; </th><th>Sessions &nbsp; </th><th>Percentage</th></tr>';
                  
                  $totalSessions = 0;                 
                  
                  if (empty($deviceCatgeory)) {
                    echo 'No data available.';
                } else {      
                 
                  foreach ($deviceCatgeory->getRows() as $row) {
                   $totalSessions += $row->getMetricValues()[0]->getValue();
                  }
  
                  
                  foreach ($deviceCatgeory->getRows() as $row) {
                    
                    $devices = $row->getDimensionValues()[0]->getValue();
                    //total sessions
                    $sessions = $row->getMetricValues()[0]->getValue();
                   
                    // Calculate the percentage difference
                     $percentage = ($sessions/ $totalSessions)*100;
                    echo '<tr>';
                    echo '<td>' . $devices . '</td>';
                    echo '<td>' . $sessions . '</td>';
                    echo '<td>' . number_format($percentage, 2) . '%' . '</td>'; // Format the percentage with two decimal places
                    echo '</tr>';  
                    $deviceCategories[] = $devices;
                    $sessions = array($sessions);
                    $sessions_array[] = $sessions;                
                    $percentages[] = number_format($percentage, 2);
                    
                    
                    $chartData = [
                      'deviceCategories' => $deviceCategories,
                      'sessions' => $sessions_array
                  ];
                  $encodedChartData = json_encode($chartData);
                //  print_r($encodedChartData); 
                  }
                } 
                echo '</table>';            
            ?>
        </div> 
        <div class="card w-1/2 ml-1 top_devices_card2">
             
             <canvas id="myChart" style=""></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var ctx = document.getElementById("myChart").getContext("2d");
                //  var deviceCategories = <?php  ?>;
                //  var sessions = <?php  ?>;
                var chartData = <?php echo $encodedChartData; ?>;
                var deviceCategories = chartData.deviceCategories;
                var sessions = chartData.sessions;

                    
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
                                position: "right"
                            }
                        }
                    });
                });			
            </script>
        </div> 
    </div>

    <div class="row mb-4">     
        <div class="card most_visited_pages_card" id="card2" > 
            <h1><b> Most Visited Pages</b></h1><br>
            <table id="dataTable1" class="stripe">
    <thead>
        <tr>
            <th>Page Title</th>
            <th>Pageviews</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($mostvisitedpages)) {
            echo 'No data available.';
        } else {
            foreach ($mostvisitedpages as $row) {
                $pageTitle = $row[0];
                $pageviews = $row[1];
                if($pageviews >10){
                // echo 'Page: ' . $pagePath . ', Pageviews: ' . $pageviews . '<br>';
                echo '<tr><td><i>' . $pageTitle . '&nbsp</td><td>' . number_format($pageviews) . '</i></td></tr>';
                }  
            }                  
        }
        echo '<tr><td><i>' . $pageTitle . '</i></td><td>' . number_format($pageviews) . '</td></tr>';
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#dataTable1').DataTable();
        $('#dataTable2').DataTable();
        $('#period').on('change',function()
        {
            if($(this).val()=='custom'){
                $('#calendar').css("visibility", "visible");
                $('#nocalendar').css("visibility", "hidden");
                  
            }
            
        });
                     
    });
</script>
        </div>
    </div>
    <div class="row card-deck mb-4">    
        <div class="card top_referrals_card" id="card3">  
            
            <h1><b>Top Referrals</b> </h1><br>
            <table id="dataTable2" class="stripe">
                <thead>
                    <tr>
                        <th>Referrals</th>
                        <th>Sessions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($topreferrals['rows'])) {
                        foreach ($topreferrals['rows'] as $row) {
                            $referrer = $row[0];
                            $sessions = $row[1];  
                            if($sessions>100){
                                echo '<tr><td><i>' . $referrer . '</i></td><td align="center">&nbsp;' . number_format($sessions) . '</td></tr>';
                            }                     
                        }
                    }else{
                        echo "The 'rows' key is not present in the array.";

                    }        
                    ?>
                </tbody>
            </table>
            
        </div> 
        </div>

</div>  

<!--<div class="container card-deck mb-5  flex pr-5 " id="card1" style="" > 
 
</div> 
<div class="container row card-deck">
<ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
    <li class="mr-2">
        <a href="#" aria-current="page" class="inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Profile</a>
    </li>
    <li class="mr-2">
        <a href="#" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Dashboard</a>
    </li>
    <li class="mr-2">
        <a href="#" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Settings</a>
    </li>
    <li class="mr-2">
        <a href="#" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Contacts</a>
    </li>
    <li>
        <a class="inline-block p-4 text-gray-400 rounded-t-lg cursor-not-allowed dark:text-gray-500">Disabled</a>
    </li>
</ul>

</div>-->
    </div>
</body>
@stop