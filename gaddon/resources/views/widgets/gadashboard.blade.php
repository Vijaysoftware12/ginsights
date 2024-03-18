<header>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@^2.29.1/moment.min.js"></script>
<link rel="stylesheet" href="https://statamic.vijaysoftware.com/garesource/css/ga_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">



</header>
<!--<input type="text" name="_token" id="token" value="{{ csrf_token() }}"> -->
<script>

//alert("111s");
    var propertyid="<?php echo $property_id;?>";
    var refreshtoken="<?php echo $refresh_token;?>";
    var interval=7;
    var lastweek;
    var lwk;

$(function(){

    $('#interval').change(function(){
        $('#loader').css({
        'display': 'flex',
        'justify-content': 'center',
        'align-items': 'center'
         });
        //$('#loader').css('display','block');
        interval = $(this).val();
        $.ajax({
                    type:"POST",
                   dataType: 'json',
                    url:"https://statamic.vijaysoftware.com/public/apipost",
                    data:{
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                        "interval" : interval,
                    },

                    success: function(resultData) {
                      processData(resultData,interval);
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

                    }
                   });
    });


                $.ajax({
                    type:"POST",
                   dataType: 'json',
                    url:"https://statamic.vijaysoftware.com/public/apipost",
                    data:{
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                        "interval" : "7",
                    },

                    success: function(resultData) {


                      processData(resultData,interval);
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

                    }
                   });

                });

                function processData(resultData,interval)
                {
                    var dates =0;
                    var sessions=0;


						$('#authorizedView').css('display', 'block');
                        $('#loader').css('display','none');

                        console.log(resultData[0]);
					    //var pg_view_dates = resultData[0]['graphpageviews']['encodedDates'];
						//pg_view_dates = pg_view_dates.split(",");
             //           var pageviews = resultData[0]['graphpageviews']['encodedpageviews'];

                      var totalsessions=resultData[0]['sessions'];
                      totalsessions = Math.abs(totalsessions / 1000,1).toFixed(1);
                      var sessionPercent=resultData[0]['sessionPercent'];
                      var sessionpercClass=(sessionPercent < 0 )? 'negative-value' : 'positive-value';
                      var sessionpercspanClass=(sessionPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var sessionpercspanColor=(sessionPercent < 0 )? 'red' : 'green';
                      var sessionpercspanSymbol=(sessionPercent < 0 )?  '↓' :  '↑';
                     //console.log(sessionPercent);

					  $("#divtotSession").html(totalsessions + 'K');
                      $("#divsessionPerc").addClass(sessionpercClass);
                      $("#divsessionPerc span").addClass(sessionpercspanClass);
                      $('#divsessionPerc span').css('color', sessionpercspanColor);
                      $('#divsessionPerc span').html(sessionpercspanSymbol + Math.abs(sessionPercent)+"%");
                      //$("#divsessionPerc").html("");
                      //$("#divsessionPerc").prepend(Math.abs(sessionPercent)+"%");

					  var totalpgviews=resultData[0]['totalpgviews'];
                      totalpgviews = Math.abs(totalpgviews / 1000,1).toFixed(1) ;
                      var pgviewsPercent=resultData[0]['pgviewsPercent'];
                      var pgviewsPercentClass=(pgviewsPercent < 0) ? 'negative-value' : 'positive-value';
                      var pgviewsPercentspanClass=(pgviewsPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var pgviewsPercentColor=(pgviewsPercent < 0 )? 'red' : 'green';
                      var pgviewsPercentSymbol=(pgviewsPercent < 0 )?  '↓' :  '↑';


                      $("#divpgViews").html(totalpgviews+'K');
                      $("#divpgviewPerc").addClass(pgviewsPercentClass);
                      $("#divpgviewPerc span").addClass(pgviewsPercentspanClass);
                      $('#divpgviewPerc span').css('color', pgviewsPercentColor);
                      $('#divpgviewPerc span').html(pgviewsPercentSymbol + Math.abs(pgviewsPercent)+"%");
                      //$('#divpgviewPerc').html("");
                     // $("#divpgviewPerc").prepend(Math.abs(pgviewsPercent)+"%");

                     var totalusers=resultData[0]['users'];
                     //console.log(totalusers);
                     totalusers = Math.abs(totalusers/ 1000,1).toFixed(1);

                     var totalusersPercent=resultData[0]['totalusersPercent'];
                     console.log(totalusersPercent);
                     //totalusersPercent = 20.4;
                     var totalusersPercentClass=(totalusersPercent < 0) ? 'negative-value' : 'positive-value';
                     var totalusersPercentspanClass=(totalusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                     var totalusersPercentColor=(totalusersPercent < 0 )? 'red' : 'green';
                     var totalusersPercentSymbol=(totalusersPercent < 0 )?  '↓' :  '↑';
                     // alert(totalusersPercentColor);


                     $("#divtotalUsers").html(totalusers+'K');
                     $("#divtotalUsersPerc").addClass(totalusersPercentClass);
                     $("#divtotalUsersPerc span").addClass(totalusersPercentspanClass);
                     $('#divtotalUsersPerc span').css('color', totalusersPercentColor);
                    //  $("#divtotalUsersPerc").html("");
                      $('#divtotalUsersPerc span').html(totalusersPercentSymbol + Math.abs(totalusersPercent)+"%");
                     // $("#divtotalUsersPerc").prepend(Math.abs(totalusersPercent)+"%");


                      var newUsers=resultData[0]['newUsers'];
                      newUsers = Math.abs(newUsers/ 1000,1).toFixed(1);
                      var newusersPercent=resultData[0]['newusersPercent'];
                      var newusersPercentClass=(newusersPercent < 0) ? 'negative-value' : 'positive-value';
                      var newusersPercentspanClass=(newusersPercent < 0 )? 'arrow-down' : 'arrow-up';
                      var newusersPercentColor=(newusersPercent < 0 )? 'red' : 'green';
                      var newusersPercentSymbol=(newusersPercent < 0 )?  '↓' :  '↑';

                      $("#divnewUsers").html(newUsers+'K');
                      $("#divnewUsersPerc").addClass(newusersPercentClass);
                      $("#divnewUsersPerc span").addClass(newusersPercentspanClass);
                      $('#divnewUsersPerc span').css('color', newusersPercentColor);
                      $('#divnewUsersPerc span').html(newusersPercentSymbol + Math.abs(newusersPercent)+"%");
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
                         dates = resultData[0]['graphsessions']['encodedDates'];

                        dates = dates.split(",");
                        var sessions = resultData[0]['graphsessions']['encodedSessions'];

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
                        var pg_view_dates = resultData[0]['graphpageviews']['encodedDates'];
                        pg_view_dates = pg_view_dates.split(",");
                       var pageviews = resultData[0]['graphpageviews']['encodedpageviews'];
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
                        console.log(formattedDates);

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
                  const visitordata = resultData[0]['visitors']['visitors'];
                  //console.log(visitordata);
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
                                    backgroundColor: ["#ff6384","#cc65fe","#ffce56"]
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

                //Device Category chart
                if(window.device != undefined) {
                        window.device.destroy();
                        var canvas = document.getElementById('deviceChart');
                        canvas.width = Math.min(600, 400); // Set width to a maximum of 1200px
                        canvas.height = Math.min(200, 200); // Set height to a maximum of 200px

                         // Set height to a maximum of 200px
                      }


               var ctx2 = document.getElementById("deviceChart").getContext("2d");

               var deviceCategories = resultData[0]['devicecategory']['deviceCategories'] ;
               var sessions = resultData[0]['devicecategory']['percentages'] ;
              // console.log(resultData[0]['devicecategory']);
              


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
            <span>GInsights</span>
        </div>
        <div class="gcard_date">
          <select name="gcard-date-interval" id="interval">
              <option value="7">Last 7 days</option>
              <option value="1">Yesterday</option>
              <option value="lastweek">Last Week</option>
              <option value="14">Last 14 days</option>
            <option value="lastmonth">Last Month</option>
              <option value="30">Last 30 Days</option>
  
          </select>
          <a href='utilities/analytics?selectedid=<?php echo $property_id ?>&initial=true' class="btn-primary ml-2 mr-1" title="click to open Full Report" id="fullreport">See Full Report</a>
        </div>
        <div class="ggear pl-2 pr-3">
            <a href='utilities/analytics?selectedid=<?php echo $property_id ?>&initial=true' title="Settings"><i class="fa-solid fa-gear"></i></a>
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

				<!-- Wind-ui CSS playground! -->
<div class="flex h-screen w-full flex-col  bg-white bg-[url('https://tailwindcss.com/_next/static/media/docs@tinypng.61f4d3334a6d245fc2297517c87ae044.png')] bg-no-repeat text-slate-500 antialiased">
  <!--  Component starts here  -->
  <!-- Outline Accordion with Icons -->
  <section id='reportsection' class="w-[700px] divide-y divide-slate-200 rounded border border-slate-200 bg-white" style="display:none">

	<details class="group p-4" open>
      <summary class="relative flex cursor-pointer list-none gap-4 pr-8 font-medium text-slate-700 focus-visible:outline-none group-hover:text-slate-800 [&::-webkit-details-marker]:hidden">
        Overview Report
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-0 top-1 h-4 w-4 stroke-slate-700 transition duration-300 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-labelledby="title-ac26 desc-ac26">
          <title id="title-ac26">Open icon</title>
          <desc id="desc-ac26">icon that represents the state of the summary</desc>
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
      </summary>

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
    </details>
    <details class="group p-4">
      <summary class="relative flex cursor-pointer list-none gap-4 pr-8 font-medium text-slate-700 focus-visible:outline-none group-hover:text-slate-800 [&::-webkit-details-marker]:hidden">

      Top Devices
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-0 top-1 h-4 w-4 stroke-slate-700 transition duration-300 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-labelledby="title-ac28 desc-ac28">
          <title id="title-ac28">Open icon</title>
          <desc id="desc-ac28">icon that represents the state of the summary</desc>
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
      </summary>
      <canvas class= "chart-styles" id="deviceChart" style="width:400px; height:200px; max-width:400px;"></canvas>
    </details>
    <details class="group p-4 items-center justify-center">
      <summary class="relative flex cursor-pointer list-none gap-4 pr-8 font-medium text-slate-700 focus-visible:outline-none group-hover:text-slate-800 [&::-webkit-details-marker]:hidden">
          New Vs Returning Visitors
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-0 top-1 h-4 w-4 stroke-slate-700 transition duration-300 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-labelledby="title-ac32 desc-ac32">
          <title id="title-ac32">Open icon</title>
          <desc id="desc-ac32">icon that represents the state of the summary</desc>
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
      </summary>
      <canvas class= "chart-styles " id="newvsreturnchart" style="width:400px; height:200px; max-width:400px;"></canvas>
    </details>

  </section>
  <!--  Component ends here  -->



</div>
		<!--<div class="flex pl-3 border border-light py-2" id="ginsights" >
			<div class="flex-1 gcard_heading">
					<span>GInsights</span>
			</div>
		</div> -->
		<div  id="unauthorizedView" style="display:none">
        <div class="p-4 font-bold content-center">
          <h2>Please Authorize Your Google Account For Analytics Data</h2>
          <a href='<?php echo env('APP_URL')?>/cp/utilities/analytics?reauth=true'>Click here</a>
        </div>
      </div>

	</div>
 </div>
