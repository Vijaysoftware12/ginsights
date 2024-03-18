<header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<link rel="stylesheet" href="/resources/css/ga_style.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</header>
<!--<input type="text" name="_token" id="token" value="{{ csrf_token() }}"> -->
<script>
//alert("111s");
var propertyid="<?php echo $property_id;?>";
    var refreshtoken="<?php echo $refresh_token;?>";

               $.ajax({
                    type:"POST",
                    dataType: 'json',
                    url:"http://statamic.vijaysoftware.com/public/apipost",
                    data:{ 
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                         
                        
                    },
                   
                    
                    success: function(resultData) {     
                        $('#authorizedView').css('display', 'block');
                        $('#loader').css('display','none');
                       // alert('30');
                        console.log(resultData[0]);
                       // document.cookie = "resultObj = " + resultData
                      // window.location.href = "{{ route('dashboard')}}";
                      var totalsessions=resultData[0]['sessions'];
                      var sessionPercent=resultData[0]['sessionPercent'];
                      var sessionpercClass=(sessionPercent < 0 )? 'negative-value' : 'positive-value';
                      var sessionpercspanClass=(sessionPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var sessionpercspanColor=(sessionPercent < 0 )? 'red' : 'green';
                      var sessionpercspanSymbol=(sessionPercent < 0 )?  '↓' :  '↑';

                      
                     // alert(sessionpercClass);

                      $("#divtotSession").html(totalsessions);
                      $("#divsessionPerc").addClass(sessionpercClass);
                      $("#divsessionPerc span").addClass(sessionpercspanClass);
                      $('#divsessionPerc span').css('color', sessionpercspanColor);
                      $('#divsessionPerc span').html(sessionpercspanSymbol);
                      $("#divsessionPerc").prepend(Math.abs(sessionPercent)+"%");

                      var totalpgviews=resultData[0]['totalpgviews'];
                      var pgviewsPercent=resultData[0]['pgviewsPercent'];
                      var pgviewsPercentClass=(pgviewsPercent < 0) ? 'negative-value' : 'positive-value'; 
                      var pgviewsPercentspanClass=(pgviewsPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var pgviewsPercentColor=(pgviewsPercent < 0 )? 'red' : 'green';
                      var pgviewsPercentSymbol=(pgviewsPercent < 0 )?  '↓' :  '↑';


                      $("#divpgViews").html(totalpgviews);
                      $("#divpgviewPerc").addClass(pgviewsPercentClass);
                      $("#divpgviewPerc span").addClass(pgviewsPercentspanClass);
                      $('#divpgviewPerc span').css('color', pgviewsPercentColor);
                      $('#divpgviewPerc span').html(pgviewsPercentSymbol);
                      $("#divpgviewPerc").prepend(Math.abs(pgviewsPercent)+"%");

                     var totalusers=resultData[0]['users'];
                     var totalusersPercent=resultData[0]['totalusersPercent'];
                     var totalusersPercentClass=(totalusersPercent < 0) ? 'negative-value' : 'positive-value'; 
                     var totalusersPercentspanClass=(totalusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                     var totalusersPercentColor=(totalusersPercent < 0 )? 'red' : 'green';
                     var totalusersPercentSymbol=(totalusersPercent < 0 )?  '↓' :  '↑';

                     $("#divtotalUsers").html(totalusers);
                     $("#divtotalUsersPerc").addClass(totalusersPercentClass);
                     $("#divtotalUsersPerc span").addClass(totalusersPercentspanClass);
                      $('#divtotalUsersPerc span').css('color', totalusersPercentColor);
                      $('#divtotalUsersPerc span').html(totalusersPercentSymbol);
                      $("#divtotalUsersPerc").prepend(Math.abs(totalusersPercent)+"%");

                      
                      var newUsers=resultData[0]['newUsers'];
                      var newusersPercent=resultData[0]['newusersPercent'];
                    
                      var newusersPercentClass=(newusersPercent < 0) ? 'negative-value' : 'positive-value'; 
                      var newusersPercentspanClass=(newusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var newusersPercentColor=(newusersPercent < 0 )? 'red' : 'green';
                      var newusersPercentSymbol=(newusersPercent < 0 )?  '↓' :  '↑';

                      $("#divnewUsers").html(newUsers);
                      $("#divnewUsersPerc").addClass(newusersPercentClass);
                      $("#divnewUsersPerc span").addClass(newusersPercentspanClass);
                      $('#divnewUsersPerc span').css('color', newusersPercentColor);
                      $('#divnewUsersPerc span').html(newusersPercentSymbol);
                      $("#divnewUsersPerc").prepend(Math.abs(newusersPercent)+"%");
                      

                    //Sessions graph
                        var ctx = document.getElementById("myChartsp").getContext("2d");
                        var dates = resultData[0]['graphsessions']['encodedDates'];
                       // var encodedDates=dates['encodedDates'];
                       //  encodedDates= encodedDates.toArray();
                       // console.log(dates);
                        dates = dates.split(",");
                        var sessions = resultData[0]['graphsessions']['encodedSessions'];
                        //console.log(sessions);
                        sessions = sessions.replaceAll(/\"/g,'')
                        var sessions = sessions.substring(1, sessions.length-1);
                        sessions = sessions.split(",");

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

                    //chart for pageviews

                    var ctx = document.getElementById("myChartpv").getContext("2d");
                        var dates = resultData[0]['graphpageviews']['encodedDates'];
                        dates = dates.split(",");
                        var pageviews = resultData[0]['graphpageviews']['encodedpageviews'];
                        pageviews = pageviews.replaceAll(/\"/g,'')
                        pageviews = pageviews.substring(1, pageviews.length-1);
                        pageviews = pageviews.split(",");
                        
                                           
                        // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                        var formattedDates = dates.map(function(date) {
                        return moment(date, 'YYYY/MM/DD').format('DD/MM/YYYY');
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
                            }
                        }
                        });
                      
                    },
                    error: function(data){
                      
                        $('#authorizedView').css('display','none');
                        $('#unauthorizedView').css('display','block');
                        $('#loader').css('display','none');
                    }
                   });
           
  
                         
   
    </script>    
<div class="card p-0">    
    <div class="row">    
        <div class="row">

<!-- SVG content (e.g., shapes, paths, etc.) goes here -->
  <div id="loader" class="" style="display: flex; justify-content: center; align-items: center;">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="100" height="100">
      <linearGradient id="a11">
        <stop offset="0" stop-color="#FF156D" stop-opacity="0"></stop>
        <stop offset="1" stop-color="#FF156D"></stop>
      </linearGradient>
      <circle fill="none" stroke="url(#a11)" stroke-width="8" stroke-linecap="round" stroke-dasharray="0 22 0 22 0 22 0 22 0 360" cx="100" cy="100" r="35" transform-origin="center">
        <animateTransform type="rotate" attributeName="transform" calcMode="discrete" dur="2" values="360;324;288;252;216;180;144;108;72;36" repeatCount="indefinite"></animateTransform>
      </circle>
      </svg>
  </div>
  <div id="authorizedView" style="display:none">
      
  <h2 class="center p-4 bold">Overview Report (Last 7 days)</h2>                       
            <div class="card-deck mb-5  flex mt-2 pr-5 session_card" >    
                              
                <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 " >  
                   Total Sessions                   
                    <div class="bold" id="divtotSession"></div>
                        <div id="divsessionPerc" class="ml-auto flex justify-end">
                            <span class=""></span> 
                        </div>               
                    </div>
                <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 pgview_card">
                  Pageviews       
                <div id="divpgViews" class="bold">'</div>
                    <div id="divpgviewPerc"  class="ml-auto flex justify-end">
                        <span class=""></span>                                 
                    </div>                   
                </div>
                <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 users_card" >
                   Total Users 
                <div id="divtotalUsers" class="bold"></div>
                    <div id="divtotalUsersPerc" class="ml-auto flex justify-end">
                        <span></span> 
                    </div>               
                </div>
                <div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 " >  
                New Users                   
                <div id="divnewUsers" class="bold"></div>
                <div id="divnewUsersPerc" class="ml-auto flex justify-end">
                              
                    <span></span> 
                </div>                                    
                </div>             
        </div> 

        
            <div id="tabs">
                <ul>
                    <li> <a href="#tabs-1">Sessions </a></li>
                    <li><a href="#tabs-2">Pageviews</a></li>
                </ul>
                <div id="tabs-1">
                    <div class="row p-2">
                    <canvas id="myChartsp" style="width:600px; height:200px;max-width:1200px;"></canvas>
                    </div>
                </div>
                <div id="tabs-2">
                    <div class="row p-2">
                    <canvas id="myChartpv" style="width:600px; height:200px;max-width:1200px;"></canvas>
                    </div>
                </div>
            </div>
        

        <div class="row p-1 mt-3 ">
        <div class="card-deck  flex">
            <div class="p-4  card md:w-1/2 lg:w-1/2 xl:w-1/2 sm:w-1/2  ">
                <a class="font-semibold center" href='utilities/analytics?selectedid=<?php echo $property_id ?>&initial=true'>Click here to view Detailed Report</a>
            </div>
            <div class="p-4  card md:w-1/2 lg:w-1/2 xl:w-1/2 sm:w-1/2 ">
                <a class="font-semibold center" href='<?php echo env('APP_URL')?>/cp/utilities/analytics?reauth=true'>Click here to reauthorize</a>  
            </div>
        </div>     
    </div>
    </div>
            
    <div  id="unauthorizedView" style="display:none">
        <div class="p-4 font-bold content-center">
            <h2>Please Authorize Your Google Account For Analytics Data</h2>
          
           <a href='<?php echo env('APP_URL')?>/cp/utilities/analytics?reauth=true'>Click here</a> 
           
        </div> 
    </div>
           
    <script>
           $(document).ready(function() {           
                $( "#tabs" ).tabs();
            });
    </script>
    
</div>