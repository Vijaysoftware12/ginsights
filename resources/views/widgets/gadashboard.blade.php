<header>
<meta name="csrf-token" content="{{ csrf_token() }}">
<?php 

		$baseUrl = asset('');
		//echo $baseUrl;
		 $user_role = Auth::user()->super;
    
?>


<script src="<?php echo $baseUrl;?>/vendor/ginsights/js/jquery-3.6.0.min.js"></script>
<script src="<?php echo $baseUrl;?>/vendor/ginsights/js/jquery-ui.js"></script> 
<script src="<?php echo $baseUrl;?>/vendor/ginsights/js/Chart.js"></script> 


<link rel="stylesheet" href="<?php echo $baseUrl;?>/vendor/ginsights/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $baseUrl;?>/vendor/ginsights/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://statamic.vijaysoftware.com/garesource/css/ga_style.css">


</header>
<!--<input type="text" name="_token" id="token" value="{{ csrf_token() }}"> -->



<script>

//alert("111s");
    var propertyid="<?php echo $property_id;?>";
    var refreshtoken="<?php echo $refresh_token;?>";
    var interval=7;
    var lastweek;
    var lwk;
	var user_role="<?php echo $user_role;?>";

$(function(){
			//checking for super admin. 
		//alert(user_role);
    var propertyid="<?php echo $property_id;?>";
    $('#pid').val(propertyid);


	if(user_role=="0")
	{
	 $('.ggear ').css('display','none');	
	}

    $('#interval').change(function(){
		  
    
      
      $('#selctedInterval').val($(this).val());
		// Remove any local storage data
    
    localStorage.removeItem("data_interval");
		localStorage.removeItem("resultData");				   
        $('#loader').css({
        'display': 'flex',
        'justify-content': 'center',
        'align-items': 'center'
         });
        //$('#loader').css('display','block');
        interval = $(this).val();
		
		
  /*      if (localStorage.getItem("resultData") !== null ) {
     var resultdata = JSON.parse(localStorage.getItem("resultData"));
                     console.log(resultdata + '80' + interval);
                     processData(resultdata,interval);
       
         
        }*/
      
       // ddate=moment().subtract(14, 'days').format("YYYY-MM-DD");
        
      
      
        dataExpire();
        $.ajax({
                    type:"POST",
                   dataType: 'json',
                    url:"https://statamic.vijaysoftware.com/public/api/dpviewnewpartial",
                    data:{
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                        "interval" : interval,
                       // "startDate" : $('#startdate').val(),
                       // "endDate" : $('#enddate').val(),
                    },

                    success: function(resultData_partial) {
                    //for cache storage
                  // console.log('Success2: ' + resultData_partial);
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                     // console.log (csrfToken);
                      
                             
                      processData_partial(resultData_partial,interval);
					   $('#ginsights').css('display','block');
					  $('#reportsection').css('display','block');
                    },
                    error: function(data){
                      //alert('36');
					  $('#authorizedView').css('display','none');
                      $('#unauthorizedView').css('display','block');
					  //$('#reportsection').css('display','none');
                      $('#loader').css('display','none');
						          $('#interval').css('display','none');
						          $('.ggear ').css('display','none');
                      $('#fullreport').css('display','none');
                      $('#accordion').css('display','none');
                      
                    }
                   });
				   
				   //Get Complete data
				  
				    $.ajax({
                    type:"POST",
                   dataType: 'json',
                  //  url:"https://statamic.vijaysoftware.com/public/api/apipost",
                   url:"https://statamic.vijaysoftware.com/public/api/dpviewnew",
                    data:{
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                        "interval" : interval,
                      //  "startDate" : $('#startdate').val(),
                       // "endDate" : $('#enddate').val(),

                    },

                    success: function(resultData) {                     
                      var csrfToken = $('meta[name="csrf-token"]').attr('content');
                     // console.log (csrfToken);
                      $.ajax({
                        url:"{{ route('cc') }}",
                        dataType: 'json',
                        type:"POST",
                  
                        headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              },
                        
                          data:{
                              "rData" :JSON.stringify(resultData),
                              "interval" : interval,
                              "property_id" : propertyid,
                          },
                          

                          success: function(data) {
                          //  console.log(data);
                        
                          },
                          error: function(data){
                            // alert(error);
                          },

                      }); 
    var createdtime = new Date().valueOf();
	// Remove any local storage data
  localStorage.removeItem("data_interval");
	localStorage.removeItem("resultData");
  localStorage.setItem("createdtime",createdtime);
	localStorage.setItem("data_interval",interval);
    //console.log(createdtime);  
   
    // Store resultData in localStorage
    localStorage.setItem("resultData", JSON.stringify(resultData));
    var storedData='';
    // Retrieve and parse resultData from localStorage
     storedData = JSON.parse(localStorage.getItem("resultData"));
	interval= JSON.parse(localStorage.getItem("data_interval"));
	$('#interval').val(interval);
	$('#selctedInterval').val(interval);
    processData(JSON.parse(JSON.stringify(resultData)),interval);
					  
                      $('#ginsights').css('display','block');
                      $('#reportsection').css('display','block');
                    },

                    error: function(data){

                      $('#authorizedView').css('display','none');
                      $('#unauthorizedView').css('display','block');
					 // $('#reportsection').css('display','none');
                      $('#loader').css('display','none');
                      $('#interval').css('display','none');
                      $('.ggear ').css('display','none');
                      $('#fullreport').css('display','none');
                      $('#accordion').css('display','none');					  

                    }
                   });
				   
				   //Get Complete data end
                  
    });
	//Interval change end

    dataExpire();

    //localStorage.removeItem('resultData');
    if (localStorage.getItem("resultData") !== null ) {
  //...

   var resultdata = JSON.parse(localStorage.getItem("resultData"));
                   //  console.log(resultdata + '80' + interval);
					 interval=localStorage.getItem("data_interval");
					$('#selctedInterval').val(interval);
					  $('#interval').val(interval);
                     processData(resultdata,interval);
					
	
       
         
        }
    else{
                $.ajax({
                    type:"POST",
                   dataType: 'json',
                  //  url:"https://statamic.vijaysoftware.com/public/api/apipost",
                   url:"https://statamic.vijaysoftware.com/public/api/dpviewnewpartial",
                    data:{
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                        "interval" : interval,
                      //  "startDate" : $('#startdate').val(),
                       // "endDate" : $('#enddate').val(),

                    },

                    success: function(resultData_partial) {
                     
                      processData_partial(resultData_partial,interval);
                      $('#ginsights').css('display','block');
                      $('#reportsection').css('display','block');
                    },

                    error: function(data){

                      $('#authorizedView').css('display','none');
                      $('#unauthorizedView').css('display','block');
					 // $('#reportsection').css('display','none');
                      $('#loader').css('display','none');
                      $('#interval').css('display','none');
                      $('.ggear ').css('display','none');
                      $('#fullreport').css('display','none');
                      $('#accordion').css('display','none');					  

                    }
                   });
				   
				   //Get Complete data
				   
				    $.ajax({
                    type:"POST",
                   dataType: 'json',
                  //  url:"https://statamic.vijaysoftware.com/public/api/apipost",
                   url:"https://statamic.vijaysoftware.com/public/api/dpviewnew",
                    data:{
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                        "interval" : interval,
                      //  "startDate" : $('#startdate').val(),
                       // "endDate" : $('#enddate').val(),

                    },

                    success: function(resultData) {
                      
                      var csrfToken = $('meta[name="csrf-token"]').attr('content');
                     // console.log (csrfToken);
                      $.ajax({
                        url:"{{ route('cc') }}",
                        dataType: 'json',
                        type:"POST",
                  
                        headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              },
                        
                          data:{
                              "rData" :JSON.stringify(resultData),
                              "interval" : interval,
                          },
                          

                          success: function(data) {
							 
                        
                          },
                          error: function(data){
                            // alert(error);
                          },

                      }); 
  localStorage.removeItem("resultData");
	localStorage.removeItem("resultData");
    var createdtime = new Date().valueOf();
    localStorage.setItem("createdtime",createdtime);
	localStorage.setItem("data_interval",interval);
    //console.log(createdtime);
   
    // Store resultData in localStorage
    localStorage.setItem("resultData", JSON.stringify(resultData));
    var storedData='';
    // Retrieve and parse resultData from localStorage
     storedData = JSON.parse(localStorage.getItem("resultData"));
	 interval=JSON.parse(localStorage.getItem("data_interval"));
		$('#interval').val(interval);
		$('#selctedInterval').val(interval);
                      processData(JSON.parse(JSON.stringify(resultData)),interval);
                      $('#ginsights').css('display','block');
                      $('#reportsection').css('display','block');
                    },

                    error: function(data){

                      $('#authorizedView').css('display','none');
                      $('#unauthorizedView').css('display','block');
					 // $('#reportsection').css('display','none');
                      //$('#loader').css('display','none');
                      $('#interval').css('display','none');
                      $('.ggear ').css('display','none');
                      $('#fullreport').css('display','none');
                      $('#accordion').css('display','none');					  

                    }
                   });
				   
				   //Get Complete data end
				   
                  }
				  
				  
                });

                function dataExpire(){
                  // localStorage.removeItem("data_interval");
                  //localStorage.removeItem("resultData");
                  createdtime = localStorage.getItem("createdtime");
                    //console.log(createdtime);
                    var currenttime = new Date().valueOf();
                    var elapsedtime =(currenttime - createdtime)/1000;
                  //  console.log(elapsedtime);
                    if(elapsedtime > 240){
                    localStorage.removeItem("resultData");
                    localStorage.removeItem("data_interval");
                    }
                }
				
				 function processData_partial(resultData_partial,interval)
                {
                    var dates =0;
                    var sessions=0;
					$('#authorizedView').css('display', 'block');
                    $('#loader').css('display','none');

                      //  console.log(resultData[0]);
					    //var pg_view_dates = resultData[0]['graphpageviews']['encodedDates'];
						//pg_view_dates = pg_view_dates.split(",");
             //           var pageviews = resultData[0]['graphpageviews']['encodedpageviews'];
						//console.log("resultData_partial");
                     //console.log(resultData_partial);
                      //var totalsessions=resultData['sessions'];

                      
                      //const totalsessions = arraySum(resultData['sessionsCurrent']['encodedSessions']);
                    //  console.log('asdf'+resultData['sessionsCurrent']['encodedSessions']);
                      var totalsessions=(resultData_partial['totalsessions']);
                    
                      if (totalsessions >= 1000) {
                        totalsessions = (totalsessions / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                      //totalsessions = Math.abs(totalsessions / 1000,1).toFixed(1);
                      var sessionPercent=parseFloat(resultData_partial['sessionPercent']);
					 //var roundedsessionPercent= Math.sign(sessionPercent) * Math.ceil(Math.abs(sessionPercent) * 10) / 10;
					 var roundedsessionPercent=Math.round(sessionPercent * 10) / 10 ;
                      var sessionpercClass=(sessionPercent < 0 )? 'negative-value' : 'positive-value';
                      var sessionpercspanClass=(sessionPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var sessionpercspanColor=(sessionPercent < 0 )? 'red' : 'green';
                      var sessionpercspanSymbol=(sessionPercent < 0 )?  '↓' :  '↑';
                     //console.log(sessionPercent);

					  $("#divtotSession").html(totalsessions);
                      $("#divsessionPerc").addClass(sessionpercClass);
                      $("#divsessionPerc span").addClass(sessionpercspanClass);
                      $('#divsessionPerc span').css('color', sessionpercspanColor);
                      $('#divsessionPerc span').html(sessionpercspanSymbol + Math.abs(roundedsessionPercent)+"%");
                      //$("#divsessionPerc").html("");
                      //$("#divsessionPerc").prepend(Math.abs(sessionPercent)+"%");

					  var totalpgviews=resultData_partial['totalpgviews'];
						//console.log(totalpgviews);
                     // totalpgviews = Math.abs(totalpgviews / 1000,1).toFixed(1) ;
                      if (totalpgviews >= 1000) {
                          totalpgviews = (totalpgviews / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                      var pgviewsPercent=parseFloat(resultData_partial['pgviewsPercent']);
					 
					 // var roundedpgviewsPercent= Math.sign(pgviewsPercent) * Math.ceil(Math.abs(pgviewsPercent) * 10) / 10;
					  var roundedpgviewsPercent=Math.round(pgviewsPercent * 10) / 10 ;					 
                      var pgviewsPercentClass=(pgviewsPercent < 0) ? 'negative-value' : 'positive-value';
                      var pgviewsPercentspanClass=(pgviewsPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var pgviewsPercentColor=(pgviewsPercent < 0 )? 'red' : 'green';
                      var pgviewsPercentSymbol=(pgviewsPercent < 0 )?  '↓' :  '↑';


                      $("#divpgViews").html(totalpgviews);
                      $("#divpgviewPerc").addClass(pgviewsPercentClass);
                      $("#divpgviewPerc span").addClass(pgviewsPercentspanClass);
                      $('#divpgviewPerc span').css('color', pgviewsPercentColor);
                      $('#divpgviewPerc span').html(pgviewsPercentSymbol + Math.abs(roundedpgviewsPercent)+"%");
                      //$('#divpgviewPerc').html("");
                     // $("#divpgviewPerc").prepend(Math.abs(pgviewsPercent)+"%");

                     var totalusers=resultData_partial['totalusers'];
                     if (totalusers >= 1000) {
                      totalusers = (totalusers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                     //console.log(totalusers);
                     //totalusers = Math.abs(totalusers/ 1000,1).toFixed(1);

                     var totalusersPercent=parseFloat(resultData_partial['totalusersPercent']);
                    // var roundedtotalusersPercent= Math.sign(totalusersPercent) * Math.ceil(Math.abs(totalusersPercent) * 10) / 10;
					  var roundedtotalusersPercent=Math.round(totalusersPercent * 10) / 10 ;
                     var totalusersPercentClass=(totalusersPercent < 0) ? 'negative-value' : 'positive-value';
                     var totalusersPercentspanClass=(totalusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                     var totalusersPercentColor=(totalusersPercent < 0 )? 'red' : 'green';
                     var totalusersPercentSymbol=(totalusersPercent < 0 )?  '↓' :  '↑';
                     // alert(totalusersPercentColor);


                     $("#divtotalUsers").html(totalusers);
                     $("#divtotalUsersPerc").addClass(totalusersPercentClass);
                     $("#divtotalUsersPerc span").addClass(totalusersPercentspanClass);
                     $('#divtotalUsersPerc span').css('color', totalusersPercentColor);
                    //  $("#divtotalUsersPerc").html("");
                      $('#divtotalUsersPerc span').html(totalusersPercentSymbol + Math.abs(roundedtotalusersPercent)+"%");
                     // $("#divtotalUsersPerc").prepend(Math.abs(totalusersPercent)+"%");


                      var newUsers=resultData_partial['newusers'];
                      if (newUsers >= 1000) {
                        newUsers = (newUsers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                      //newUsers = Math.abs(newUsers/ 1000,1).toFixed(1);
                      var newusersPercent=parseFloat(resultData_partial['newusersPercent']);
					// var roundednewusersPercent= Math.sign(newusersPercent) * Math.ceil(Math.abs(newusersPercent) * 10) / 10;
					  var roundednewusersPercent=Math.round(newusersPercent * 10) / 10 ;
                      var newusersPercentClass=(newusersPercent < 0) ? 'negative-value' : 'positive-value';
                      var newusersPercentspanClass=(newusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var newusersPercentColor=(newusersPercent < 0 )? 'red' : 'green';
                      var newusersPercentSymbol=(newusersPercent < 0 )?  '↓' :  '↑';

                      $("#divnewUsers").html(newUsers);
                      $("#divnewUsersPerc").addClass(newusersPercentClass);
                      $("#divnewUsersPerc span").addClass(newusersPercentspanClass);
                      $('#divnewUsersPerc span').css('color', newusersPercentColor);
                      $('#divnewUsersPerc span').html(newusersPercentSymbol + Math.abs(roundednewusersPercent)+"%");
                     // $("#divnewUsersPerc").prepend();
//$("#divnewUsersPerc").html("");

                      if(interval == 'lastmonth'){
                         $(".scard-compare").html("vs. Previous Month");
                      }else if(interval == 'lastweek'){
                         $(".scard-compare").html("vs. Previous Week");
                      }
                      else{
                        $(".scard-compare").html("vs. Previous " + interval + " Days");
                      }

                   //   $(".gcard-widget-head span").html("Last" + interval + "days";)

                      //Sessions graph
                      if(window.bar1 != undefined) {
                          window.bar1.destroy();
                          var s_canvas = document.getElementById('myChartsp');
						            s_canvas.width = Math.min(1200, 600); // Set width to a maximum of 1200px
						            s_canvas.height = Math.min(200, 200);
                        }

                        var ctx = document.getElementById("myChartsp").getContext("2d");
                      //   dates = resultData['graphsessions']['encodedDates'];
						dates=resultData_partial['sessionsCurrent']['encodedDates'];
                        dates = dates.split(",");
                      //  var sessions = resultData['graphsessions']['encodedSessions'];
						var sessions =resultData_partial['sessionsCurrent']['encodedSessions'];
						//console.log('309' + sessions);
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


                        window.bar1= new Chart(ctx, {
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
                          plugins: {
                            legend: {
                              labels: {
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  e.stopPropagation();
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
                                  e.stopPropagation();
                                }
                            }

                        }

                        });


						                    //chart for pageviews
                       if(window.bar != undefined) {
                        window.bar.destroy();
                        var canvas = document.getElementById('myChartpv');
                        canvas.width = Math.min(1200, 600); // Set width to a maximum of 1200px
                        canvas.height = Math.min(200, 200); // Set height to a maximum of 200px

                         // Set height to a maximum of 200px
                      }

                    var p_ctx = document.getElementById("myChartpv").getContext("2d");
                      //  var pg_view_dates = resultData[0]['graphpageviews']['encodedDates'];
 //console.log(resultData['pageviewsCurrent']['encodedDates']);                     
 pg_view_dates = resultData_partial['pageviewsCurrent']['encodedDates'];                       
                        pg_view_dates = pg_view_dates.split(",");
                      // var pageviews = resultData[0]['graphpageviews']['encodedpageviews'];
 var pageviews = resultData_partial['pageviewsCurrent']['encodedpageviews'];
					   //	console.log(resultData[0]['graphpageviews']);
                        pageviews = pageviews.replaceAll(/\"/g,'')
                        pageviews = pageviews.substring(1, pageviews.length-1);
                        pageviews = pageviews.split(",");
                       // console.log(pg_view_dates);
                       // console.log(pageviews);

                        // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                        var formattedDates = pg_view_dates.map(function(date) {
                        const momentDate = moment(date, 'YYYY/MM/DD');
                        const day = momentDate.format('D'); // Day of the month without leading zero
                        const month = momentDate.format('MMM'); // Abbreviated month name in uppercase

                        return day + ' ' + month;
                        });

                        // Sort the dates in chronological order
                       /* formattedDates.sort(function(a, b) {
                            return moment(a, 'DD/MM/YYYY').toDate() - moment(b, 'DD/MM/YYYY').toDate();
                        });*/
                        //console.log(formattedDates);

                    window.bar = new Chart(p_ctx, {
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
                          legend: {
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  e.stopPropagation();
                                }
                            }
                        }
                        });
                }

                function processData(resultData,interval)
                {				
					//alert(interval);
                    var dates =0;
                    var sessions=0;
					 $('#authorizedView').css('display', 'block');
                  //  
                      //  console.log(resultData[0]);
                      var totalsessions=(resultData['totalsessions']);
                    
                      if (totalsessions >= 1000) {
                        totalsessions = (totalsessions / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                      //totalsessions = Math.abs(totalsessions / 1000,1).toFixed(1);
                      var sessionPercent=resultData['sessionPercent'];
					  //var roundedsessionPercent= Math.sign(sessionPercent) * Math.ceil(Math.abs(sessionPercent) * 10) / 10;
					 // var roundedsessionPercent= Math.round(parseFloat(sessionPercent * 10)) / 10 ;
					 
				//	console.log('sessionPercent-'+"- "+sessionPercent+" - "+resultData['sessionPercent']+" - "+roundedsessionPercent);
                      var sessionpercClass=(sessionPercent < 0 )? 'negative-value' : 'positive-value';
                      var sessionpercspanClass=(sessionPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var sessionpercspanColor=(sessionPercent < 0 )? 'red' : 'green';
                      var sessionpercspanSymbol=(sessionPercent < 0 )?  '↓' :  '↑';
                     //console.log(sessionPercent);

					  $("#divtotSession").html(totalsessions);
                      $("#divsessionPerc").addClass(sessionpercClass);
                      $("#divsessionPerc span").addClass(sessionpercspanClass);
                      $('#divsessionPerc span').css('color', sessionpercspanColor);
                      $('#divsessionPerc span').html(sessionpercspanSymbol + Math.abs(sessionPercent).toFixed(1)+"%");
                      //$("#divsessionPerc").html("");
                      //$("#divsessionPerc").prepend(Math.abs(sessionPercent)+"%");

					  var totalpgviews=resultData['totalpgviews'];
            //console.log(totalpgviews);
                     // totalpgviews = Math.abs(totalpgviews / 1000,1).toFixed(1) ;
                      if (totalpgviews >= 1000) {
                          totalpgviews = (totalpgviews / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                      var pgviewsPercent=resultData['pgviewsPercent'];
                      var pgviewsPercentClass=(pgviewsPercent < 0) ? 'negative-value' : 'positive-value';
                      var pgviewsPercentspanClass=(pgviewsPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var pgviewsPercentColor=(pgviewsPercent < 0 )? 'red' : 'green';
                      var pgviewsPercentSymbol=(pgviewsPercent < 0 )?  '↓' :  '↑';
					//var roundedPgviewsPercent= Math.sign(pgviewsPercent) * Math.ceil(Math.abs(pgviewsPercent) * 10) / 10;
					// var roundedPgviewsPercent= Math.round(parseFloat(pgviewsPercent * 10)) / 10 ;
					
						//console.log('pgviewsPercent-'+"- "+pgviewsPercent+" - "+parseFloat(resultData['pgviewsPercent'])+" - "+roundedPgviewsPercent);
                      $("#divpgViews").html(totalpgviews);
                      $("#divpgviewPerc").addClass(pgviewsPercentClass);
                      $("#divpgviewPerc span").addClass(pgviewsPercentspanClass);
                      $('#divpgviewPerc span').css('color', pgviewsPercentColor);
                      $('#divpgviewPerc span').html(pgviewsPercentSymbol + Math.abs(pgviewsPercent).toFixed(1)+"%");
                      //$('#divpgviewPerc').html("");
                     // $("#divpgviewPerc").prepend(Math.abs(pgviewsPercent)+"%");

                     var totalusers=resultData['totalusers'];
                     if (totalusers >= 1000) {
                      totalusers = (totalusers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                     //console.log(totalusers);
                     //totalusers = Math.abs(totalusers/ 1000,1).toFixed(1);

                     var totalusersPercent=parseFloat(resultData['totalusersPercent']);
					 //var roundedtotalusersPercent= Math.sign(totalusersPercent) * Math.ceil(Math.abs(totalusersPercent) * 10) / 10;
					 // var roundedtotalusersPercent=Math.round(totalusersPercent * 10) / 10 ;
                     
                     //totalusersPercent = 20.4;
                     var totalusersPercentClass=(totalusersPercent < 0) ? 'negative-value' : 'positive-value';
                     var totalusersPercentspanClass=(totalusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                     var totalusersPercentColor=(totalusersPercent < 0 )? 'red' : 'green';
                     var totalusersPercentSymbol=(totalusersPercent < 0 )?  '↓' :  '↑';
                     // alert(totalusersPercentColor);


                     $("#divtotalUsers").html(totalusers);
                     $("#divtotalUsersPerc").addClass(totalusersPercentClass);
                     $("#divtotalUsersPerc span").addClass(totalusersPercentspanClass);
                     $('#divtotalUsersPerc span').css('color', totalusersPercentColor);
                    //  $("#divtotalUsersPerc").html("");
                      $('#divtotalUsersPerc span').html(totalusersPercentSymbol + Math.abs(totalusersPercent).toFixed(1)+"%");
                     // $("#divtotalUsersPerc").prepend(Math.abs(totalusersPercent)+"%");
					//console.log('totalusersPercent-'+"- "+totalusersPercent+" - "+roundedtotalusersPercent);

                      var newUsers=resultData['newusers'];
                      if (newUsers >= 1000) {
                        newUsers = (newUsers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                      }
                      //newUsers = Math.abs(newUsers/ 1000,1).toFixed(1);
                      var newusersPercent=parseFloat(resultData['newusersPercent']);
					  //var roundednewusersPercent= Math.sign(newusersPercent) * Math.ceil(Math.abs(newusersPercent) * 10) / 10;
					  // var roundednewusersPercent=Math.round(newusersPercent * 10) / 10;
                      var newusersPercentClass=(newusersPercent < 0) ? 'negative-value' : 'positive-value';
                      var newusersPercentspanClass=(newusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var newusersPercentColor=(newusersPercent < 0 )? 'red' : 'green';
                      var newusersPercentSymbol=(newusersPercent < 0 )?  '↓' :  '↑';

                      $("#divnewUsers").html(newUsers);
                      $("#divnewUsersPerc").addClass(newusersPercentClass);
                      $("#divnewUsersPerc span").addClass(newusersPercentspanClass);
                      $('#divnewUsersPerc span').css('color', newusersPercentColor);
                      $('#divnewUsersPerc span').html(newusersPercentSymbol + Math.abs(newusersPercent).toFixed(1)+"%");
					 // console.log('newusersPercent-'+"- "+newusersPercent+" - "+roundednewusersPercent);
                     // $("#divnewUsersPerc").prepend();
//$("#divnewUsersPerc").html("");

                      if(interval == 'lastmonth'){
                         $(".scard-compare").html("vs. Previous Month");
                      }else if(interval == 'lastweek'){
                         $(".scard-compare").html("vs. Previous Week");
                      }
                      else{
                        $(".scard-compare").html("vs. Previous " + interval + " Days");
                      }

                   //   $(".gcard-widget-head span").html("Last" + interval + "days";)

                      //Sessions graph
                      if(window.bar1 != undefined) {
                          window.bar1.destroy();
                          var s_canvas = document.getElementById('myChartsp');
						            s_canvas.width = Math.min(1200, 600); // Set width to a maximum of 1200px
						            s_canvas.height = Math.min(200, 200);
                        }

                        var ctx = document.getElementById("myChartsp").getContext("2d");
                      //   dates = resultData['graphsessions']['encodedDates'];
					dates=resultData['sessionsCurrent']['encodedDates'];
					//console.log(dates);
                        dates = dates.split(",");
                      //  var sessions = resultData['graphsessions']['encodedSessions'];
					var sessions =resultData['sessionsCurrent']['encodedSessions'];
					//console.log('309' + sessions);
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
                       // $('#loader').css('display','none');

                        window.bar1= new Chart(ctx, {
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
                          plugins: {
                            legend: {
                              labels: {
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  e.stopPropagation();
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
                                  e.stopPropagation();
                                }
                            }

                        }

                        });


						                    //chart for pageviews
                       if(window.bar != undefined) {
                        window.bar.destroy();
                        var canvas = document.getElementById('myChartpv');
                        canvas.width = Math.min(1200, 600); // Set width to a maximum of 1200px
                        canvas.height = Math.min(200, 200); // Set height to a maximum of 200px

                         // Set height to a maximum of 200px
                      }

                    var p_ctx = document.getElementById("myChartpv").getContext("2d");
                      //  var pg_view_dates = resultData[0]['graphpageviews']['encodedDates'];
 //console.log(resultData['pageviewsCurrent']['encodedDates']);                     
 pg_view_dates = resultData['pageviewsCurrent']['encodedDates'];                       
                        pg_view_dates = pg_view_dates.split(",");
                      // var pageviews = resultData[0]['graphpageviews']['encodedpageviews'];
 var pageviews = resultData['pageviewsCurrent']['encodedpageviews'];
					   //	console.log(resultData[0]['graphpageviews']);
                        pageviews = pageviews.replaceAll(/\"/g,'')
                        pageviews = pageviews.substring(1, pageviews.length-1);
                        pageviews = pageviews.split(",");
                       // console.log(pg_view_dates);
                       // console.log(pageviews);

                        // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
                        var formattedDates = pg_view_dates.map(function(date) {
                        const momentDate = moment(date, 'YYYY/MM/DD');
                        const day = momentDate.format('D'); // Day of the month without leading zero
                        const month = momentDate.format('MMM'); // Abbreviated month name in uppercase

                        return day + ' ' + month;
                        });

                        // Sort the dates in chronological order
                       /* formattedDates.sort(function(a, b) {
                            return moment(a, 'DD/MM/YYYY').toDate() - moment(b, 'DD/MM/YYYY').toDate();
                        });*/
                     //   console.log(formattedDates);

                    window.bar = new Chart(p_ctx, {
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
                          legend: {
                                onClick(e, legendItem, legend) {
                                  // Prevent the default behavior of the legend item click
                                  e.stopPropagation();
                                }
                            }
                        }
                        });

                  //new vs return chart
                  if(window.visitor != undefined) {
                        window.visitor.destroy();
                        var canvas = document.getElementById('newvsreturnchart');
                        canvas.width = Math.min(600, 400); // Set width to a maximum of 1200px
                        canvas.height = Math.min(200, 200); // Set height to a maximum of 200px

                         // Set height to a maximum of 200px
                      }

                  var ctx1 = document.getElementById("newvsreturnchart").getContext("2d");
                  const visitordata = resultData['visitors']['visitors'];
                 // console.log(visitordata);
                  const visitors_val = [];
                  const count = [];
                  const percentages = [];
                  for (const visitor of visitordata) {
                    if (visitor.visitorsvalue && visitor.visitorsvalue !== '(not set)') {
                    visitors_val.push(visitor.visitorsvalue);
                    percentages.push(visitor.percentages);
                    }
                  }
                  //var visitors = resultData[0]['visitors']['visitors']['visitorsvalue'];
                 // var count = resultData[0]['visitors']['visitors']['count'];
                //console.log(visitorsval);

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
                                  e.stopPropagation();
                                },
                                labels: {
                                generateLabels: (chart) => {

                                    const labels = [];
                                    const datasets = chart.data.datasets;
                                    for (let i = 0; i < datasets.length; i++) {                                        
                                    const dataset = datasets[i];
                                   // console.log(dataset );
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

                //Device Category chart
                if(window.device != undefined) {
                        window.device.destroy();
                        var canvas = document.getElementById('deviceChart');
                        canvas.width = Math.min(600, 400); // Set width to a maximum of 1200px
                        canvas.height = Math.min(200, 200); // Set height to a maximum of 200px

                         // Set height to a maximum of 200px
                      }


               var ctx2 = document.getElementById("deviceChart").getContext("2d");

               var deviceCategories = resultData['deviceCategory']['deviceCategories'] ;
               var sessions = resultData['deviceCategory']['percentages'] ;
              // console.log(resultData['deviceCategory']);
              


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
                        },

                    });

                }


    </script>

 <div class="card p-0">
    <div class="gcard-con pl-3 border border-light py-2" id="ginsights" style="display:none">
        <div class="gcard_heading">
            <img src="https://statamic.vijaysoftware.com/garesource/img/vijay-icon-100x100.png" width="30px" alt="analytic icon">
            <span>GInsights Analytics</span>
        </div>
        
          
        <div class="gcard_date">
        
          <select name="gcard-date-interval" id="interval">
              <option value="7">Last 7 days</option>
              <option value="1">Yesterday</option>
            <!--  <option value="lastweek">Last Week</option> -->
              <option value="14">Last 14 days</option>
           <!-- <option value="lastmonth">Last Month</option>-->
              <option value="30">Last 30 Days</option>
			  
			 
  
          </select>
          <form action='utilities/analytics'>
          <input type="hidden" value="123" id="pid" name="selectedid"/>
          <input type="hidden" id="selctedInterval" value="7" name="period"/>
          <input type="submit" value="See Full Report" class="btn-primary ml-2 mr-1" title="click to open Full Report" id="fullreport" />
          </form>
          
        </div>
             
		
        <div class="ggear pl-2 pr-3">
		
            <a href='utilities/analytics?reset=true' title="Settings"><i class="fa-solid fa-gear"></i></a>
		
        </div>
		
    </div>
	 <div class="row">
			<!-- Loader-->
      
			<!-- SVG content (e.g., shapes, paths, etc.) goes here -->
		  <div id="loader" class="" style="display: flex; justify-content: center; align-items: center; ">
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

		  <div class="gcard-widget-head p-3">
                <span>Overview Report </span>
            </div>
					<div class="card-deck mb-5 flex pr-5 session_card" >
						<div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 " >
						   <span class="scard_head">Total Sessions </span>
							<div class="scard-score" id="divtotSession"></div>
								<div id="divsessionPerc" class="ml-auto flex justify-end">
									<span class=""></span>
								</div>
                                <div class="scard-compare">vs. Previous  Days</div>
							</div>

						<div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 pgview_card">
                            <span class="scard_head">Pageviews </span>
						<div id="divpgViews" class="scard-score"></div>
							<div id="divpgviewPerc"  class="ml-auto flex justify-end">
								<span class=""></span>
							</div>
                            <div class="scard-compare">vs. Previous 7 Days</div>
						</div>
						<div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 users_card" >
                            <span class="scard_head">Total Users </span>
						<div id="divtotalUsers" class="scard-score"></div>
							<div id="divtotalUsersPerc" class="ml-auto flex justify-end">
								<span class=""></span>
							</div>
                    <div class="scard-compare">vs. Previous 7 Days</div>
						</div>
						<div class="card md:w-1/3 lg:w-1/4 xl:w-1/4 sm:w-1/2 " >
						    <span class="scard_head">New Users</span>
						<div id="divnewUsers" class="scard-score"></div>
                            <div id="divnewUsersPerc" class="ml-auto flex justify-end">
                                <span class=""></span>
                            </div>
                            <div class="scard-compare">vs. Previous 7 Days</div>
						</div>
				</div>

				<script>
				   $(document).ready(function() {
						$( "#tabs" ).tabs();
            $( "#accordion" ).accordion();
					});
				</script>

				<!-- <div class="row p-1 mt-3 ">
				<div class="card-deck  flex">
					<div class="p-4  card md:w-1/2 lg:w-1/2 xl:w-1/2 sm:w-1/2  ">
						<a class="font-semibold center" href='utilities/analytics?selectedid=<?php //echo $property_id ?>&initial=true'>Click here to view Detailed Report</a>
					</div>
					<div class="p-4  card md:w-1/2 lg:w-1/2 xl:w-1/2 sm:w-1/2 ">
						<a class="font-semibold center" href='<?php //echo env('APP_URL')?>/cp/utilities/analytics?reauth=true'>Click here to reauthorize</a>
					</div>
				</div> -->

				</div>

			</div>
             <!-- Accordion -->
        <div id="accordion">
        
        <h3>Overview Report</h3>
        <div class="">
        
      <div id="tabs" style="width:100%;">
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
        </div>
        
        <h3>Top Devices</h3>
        <div>
        <canvas class= "chart-styles" id="deviceChart" style="width:400px; height:200px; max-width:400px;"></canvas>
        </div>

        <h3>New Vs. Returning Visitors</h3>
        <div>
        <canvas class= "chart-styles " id="newvsreturnchart" style="width:400px; height:200px; max-width:400px;"></canvas>
        </div>

        </div>
        


			
		<!--<div class="flex pl-3 border border-light py-2" id="ginsights" >
			<div class="flex-1 gcard_heading">
					<span>GInsights</span>
			</div>
		</div> -->
		<div  id="unauthorizedView" style="display:none">
        <div class="p-4 font-bold content-center">
          <h2>Please Authorize Your Google Account For Analytics Data</h2>
          <a href='<?php echo env('APP_URL')?>/cp/utilities/analytics?reauth=true' class="btn-primary ml-1 mr-1 mt-2 " title="Connect to Google" id="ConnecttoGoogle">Connect to Google</a>
        </div>
      </div>

	</div>
 
