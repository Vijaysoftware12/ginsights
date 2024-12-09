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
    var interval=0;
    var lastweek;
    var lwk;
	var user_role="<?php echo $user_role;?>";
	var g_count=0;
	let key;
	
	let storedValue;

	$(function(){
		
	//checking for super admin. 
	//alert(user_role);
    var propertyid="<?php echo $property_id;?>";
    $('#pid').val(propertyid);
		interval=7;
	if(user_role=="0")
	{
	 $('.ggear ').css('display','none');	
	}


    // Function to disable and enable the button
   /* function toggleButton(state) {
        $('#fullreport').prop('disabled', state);
        $('.ggear').prop('disabled', state);
    }*/
    function toggleButton(selector, state) {
    $(selector).css({
        'pointer-events': state ? 'none' : 'auto', // Disable or enable mouse interactions
        'opacity': state ? '0.5' : '1' // Make the element semi-transparent when disabled
    });
}

    // Disable the button on initial load
    //toggleButton(true);
    toggleButton('.fullreport, .toggle-button', true);
	$('#interval').prop('disabled', true);

    $('#interval').change(function(){
       // toggleButton(true);
       toggleButton('.fullreport, .toggle-button', true);
	   $('#interval').prop('disabled', true);
	  $("#accordion").accordion({
            collapsible: true,
             active: 0 ,
			 heightStyle: "content"
        });
    // Create and show the loading animation                  
    $('#selctedInterval').val($(this).val());	
	// Remove any local storage data    
    localStorage.removeItem("data_interval");
	//localStorage.removeItem("resultData");				   
    interval = $("#interval").val();
	//alert(interval);
    $('#loader').css({
        'display': 'flex',
        'justify-content': 'center',
        'align-items': 'center'
         });

    dataExpire();
	key = `${propertyid},resultData,${interval}`;
	
	storedValue="";
	storedValue = localStorage.getItem(key);
	if (storedValue) {
		let parsedValue = JSON.parse(storedValue);				
		var resultdata =parsedValue.resultData;
        //interval=localStorage.getItem("data_interval");
		interval=parsedValue.interval;
		$('#selctedInterval').val(interval);
		$('#interval').val(interval);
        processData(resultdata,interval,"partial");
        //toggleButton(false);
        toggleButton('.fullreport, .toggle-button', false);
		$('#interval').prop('disabled', false);
		}
		else{
			$("#accordion").accordion({
            collapsible: true,
             active: 0 ,
			 heightStyle: "content"// Open the first section by default
        });
	
    $.ajax({
        type:"POST",
        dataType: 'json',
        url:"https://statamic.vijaysoftware.com/public/api/dpviewnewpartial",
            data:{
                "refresh_token" : refreshtoken,
                "property_id" : propertyid,
                "interval" : interval,
                },

            success: function(resultData_partial) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            processData_partial(resultData_partial,interval,"partial");
			$('#ginsights').css('display','block');
			$('#reportsection').css('display','block');
            //document.body.removeChild(loadingElement);
           // document.body.removeChild(document.getElementById('loadingAnimation'));
			},
            error: function(data){
				$('#authorizedView').css('display','none');
                $('#unauthorizedView').css('display','block');
				$('#interval').css('display','none');
				$('.ggear ').css('display','none');
                $('#fullreport').css('display','none');
                $('#accordion').css('display','none');
                $('#loader').css('display','none');
                //document.body.removeChild(loadingElement);
               // document.body.removeChild(document.getElementById('loadingAnimation'));
				}
        });
				   
		//Get Complete data
				  
	$.ajax({
        type:"POST",
        dataType: 'json',
        url:"https://statamic.vijaysoftware.com/public/api/dpviewnew",
            data:{
                "refresh_token" : refreshtoken,
                "property_id" : propertyid,
                "interval" : interval,
                },
			success: function(resultData) {                     
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
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
                    //localStorage.removeItem("resultData");
                    localStorage.setItem("createdtime",createdtime);
                    localStorage.setItem("data_interval",interval);
                    // Store resultData in localStorage
				//localStorage.setItem("resultData", JSON.stringify(resultData));
					
                    //  var storedData='';
                      // Retrieve and parse resultData from localStorage
					//storedData = JSON.parse(localStorage.getItem("resultData"));
                    interval= JSON.parse(localStorage.getItem("data_interval"));
                    $('#interval').val(interval);
                    $('#selctedInterval').val(interval);
					
					key = `${propertyid},resultData,${interval}`;
						 value = {
							propertyid: propertyid,
							resultData: resultData,
							interval: interval
						};
					localStorage.setItem(key, JSON.stringify(value));processData(JSON.parse(JSON.stringify(resultData)),interval,"detail");
					  
                      $('#ginsights').css('display','block');
                      $('#reportsection').css('display','block');
                      $('#loader').css('display','none');
                      //document.body.removeChild(loadingElement);
                     // document.body.removeChild(document.getElementById('loadingAnimation'));
                     //toggleButton(false);
                     toggleButton('.fullreport, .toggle-button', false);
					 $('#interval').prop('disabled', false);

                    },

            error: function(data){
				$('#authorizedView').css('display','none');
                $('#unauthorizedView').css('display','block');
				$('#interval').css('display','none');
                $('.ggear ').css('display','none');
                $('#fullreport').css('display','none');
                $('#accordion').css('display','none');
                $('#loader').css('display','none');
               // toggleButton(false);
               toggleButton('.fullreport, .toggle-button', false);
			   $('#interval').prop('disabled', false);
                // document.body.removeChild(loadingElement);				
               // document.body.removeChild(document.getElementById('loadingAnimation'));	  
				}
        });
		//Get Complete data end
	}
                 
    });
	//Interval change end

    dataExpire();
	key = `${propertyid},resultData,${interval}`;
	//console.log(key);
	storedValue = localStorage.getItem(key);
    //localStorage.removeItem('resultData');
   // if (localStorage.getItem("resultData") !== null ) {
		//var resultdata = JSON.parse(localStorage.getItem("resultData"));
		if (storedValue) {			
			$("#accordion").accordion({
            collapsible: true,
             active: 0 ,
			 heightStyle: "content"// Open the first section by default
        });
		let parsedValue = JSON.parse(storedValue);
		var resultdata =parsedValue.resultData;
        //interval=localStorage.getItem("data_interval");
		interval=parsedValue.interval;
		$('#selctedInterval').val(interval);
		$('#interval').val(interval);
        processData(resultdata,interval,"partial");
        //toggleButton(false);
        toggleButton('.fullreport, .toggle-button', false);
		$('#interval').prop('disabled', false);
        }
    else{
		
        $.ajax({
            type:"POST",
            dataType: 'json',
            url:"https://statamic.vijaysoftware.com/public/api/dpviewnewpartial",
                data:{
                    "refresh_token" : refreshtoken,
                    "property_id" : propertyid,
                    "interval" : interval,
                    //  "startDate" : $('#startdate').val(),
                    // "endDate" : $('#enddate').val(),
                    },
                    success: function(resultData_partial) {
					
                    processData_partial(resultData_partial,interval,"partial");
                    $('#ginsights').css('display','block');
                    $('#reportsection').css('display','block');
                    $('#loader').css('display','none');
                    //document.body.removeChild(document.getElementById('loadingAnimation'));
                    },
                    error: function(data){
                    $('#authorizedView').css('display','none');
                    $('#unauthorizedView').css('display','block');
					$('#interval').css('display','none');
                    $('.ggear ').css('display','none');
                    $('#fullreport').css('display','none');
                    $('#accordion').css('display','none');
                    $('#loader').css('display','none');
                   // toggleButton(false);
                   toggleButton('.fullreport, .toggle-button', false);
				   $('#interval').prop('disabled', false);
                   // document.body.removeChild(document.getElementById('loadingAnimation'));
                    }
            });
				//Get Complete data
				
				$.ajax({
                type:"POST",
                dataType: 'json',                
					url:"https://statamic.vijaysoftware.com/public/api/dpviewnew",
                    data:{
                        "refresh_token" : refreshtoken,
                        "property_id" : propertyid,
                        "interval" : interval,
						//"startDate" : $('#startdate').val(),
                       //"endDate" : $('#enddate').val(),
                    },
                    success: function(resultData) {                      
						var csrfToken = $('meta[name="csrf-token"]').attr('content');                     
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
						//localStorage.removeItem("resultData");				
						var createdtime = new Date().valueOf();
						localStorage.setItem("createdtime",createdtime);
						localStorage.setItem("data_interval",interval);
						//console.log(createdtime);
					   
						// Store resultData in localStorage
						//localStorage.setItem("resultData", JSON.stringify(resultData));
					
					key = `${propertyid},resultData,${interval}`;
						 value = {
							propertyid: propertyid,
							resultData: resultData,
							interval: interval
						};
						localStorage.removeItem(key);
					localStorage.setItem(key, JSON.stringify(value));
						//var storedData='';
						// Retrieve and parse resultData from localStorage
					//	storedData = JSON.parse(localStorage.getItem("resultData"));
						interval=JSON.parse(localStorage.getItem("data_interval"));
						$('#interval').val(interval);
						$('#selctedInterval').val(interval);
						
						processData(JSON.parse(JSON.stringify(resultData)),interval,"detail");
						$('#ginsights').css('display','block');
						$('#reportsection').css('display','block');
                        $('#loader').css('display','none');
                        //toggleButton(false);
                        toggleButton('.fullreport, .toggle-button', false);
						$('#interval').prop('disabled', false);
						//document.body.removeChild(document.getElementById('loadingAnimation'));
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
                        //toggleButton(false);
                        toggleButton('.fullreport, .toggle-button', false);
						$('#interval').prop('disabled', false);
						//document.body.removeChild(document.getElementById('loadingAnimation'));
                    }
                   });				   
				   //Get Complete data end				   
                  }				  
				  
        });
		
		


        function dataExpire(){
            createdtime = localStorage.getItem("createdtime");
            //console.log(createdtime);
            var currenttime = new Date().valueOf();
            var elapsedtime =(currenttime - createdtime)/1000;
            //  console.log(elapsedtime);
            if(elapsedtime > 900){
				//localStorage.removeItem("resultData");
				//localStorage.removeItem("data_interval");
				key = `${propertyid},resultData,${interval}`;
				localStorage.removeItem(key);
				}
        }
				
		function processData_partial(resultData_partial,interval,type){			
            var dates =0;
            var sessions=0;
			$('#authorizedView').css('display', 'block');
            $('#loader').css('display','none');
            
			var totalsessions=(resultData_partial['totalsessions']);
				if (totalsessions >= 1000) {
					totalsessions = (totalsessions / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                }
                    
            var sessionPercent=parseFloat(resultData_partial['sessionPercent']);
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
                     

			var totalpgviews=resultData_partial['totalpgviews'];
				if (totalpgviews >= 1000) {
					totalpgviews = (totalpgviews / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
					}
            var pgviewsPercent=parseFloat(resultData_partial['pgviewsPercent']);
			var roundedpgviewsPercent=Math.round(pgviewsPercent * 10) / 10 ;var pgviewsPercentClass=(pgviewsPercent < 0) ? 'negative-value' : 'positive-value';
            var pgviewsPercentspanClass=(pgviewsPercent < 0 )? 'arrow-down' : 'arrow-up';
            var pgviewsPercentColor=(pgviewsPercent < 0 )? 'red' : 'green';
            var pgviewsPercentSymbol=(pgviewsPercent < 0 )?  '↓' :  '↑';
			
			$("#divpgViews").html(totalpgviews);
            $("#divpgviewPerc").addClass(pgviewsPercentClass);
            $("#divpgviewPerc span").addClass(pgviewsPercentspanClass);
            $('#divpgviewPerc span').css('color', pgviewsPercentColor);
            $('#divpgviewPerc span').html(pgviewsPercentSymbol + Math.abs(roundedpgviewsPercent)+"%");
            
            var totalusers=resultData_partial['totalusers'];
                if (totalusers >= 1000) {
                    totalusers = (totalusers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                }
                
            var totalusersPercent=parseFloat(resultData_partial['totalusersPercent']);
            var roundedtotalusersPercent=Math.round(totalusersPercent * 10) / 10 ;
            var totalusersPercentClass=(totalusersPercent < 0) ? 'negative-value' : 'positive-value';
            var totalusersPercentspanClass=(totalusersPercent < 0 )? 'arrow-down' : 'arrow-up';
            var totalusersPercentColor=(totalusersPercent < 0 )? 'red' : 'green';
            var totalusersPercentSymbol=(totalusersPercent < 0 )?  '↓' :  '↑';
            
				$("#divtotalUsers").html(totalusers);
                $("#divtotalUsersPerc").addClass(totalusersPercentClass);
                $("#divtotalUsersPerc span").addClass(totalusersPercentspanClass);
                $('#divtotalUsersPerc span').css('color', totalusersPercentColor);
                $('#divtotalUsersPerc span').html(totalusersPercentSymbol + Math.abs(roundedtotalusersPercent)+"%");
                
			var newUsers=resultData_partial['newusers'];
				if (newUsers >= 1000) {
                    newUsers = (newUsers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
                    }
            var newusersPercent=parseFloat(resultData_partial['newusersPercent']);
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
            
            if(interval == 'lastmonth'){
                $(".scard-compare").html("vs. Previous Month");
            }else if(interval == 'lastweek'){
                $(".scard-compare").html("vs. Previous Week");
            }
            else{
                $(".scard-compare").html("vs. Previous " + interval + " Days");
            }

            //   dates = resultData['graphsessions']['encodedDates'];
			dates=resultData_partial['sessionsCurrent']['encodedDates'];
            dates = dates.split(",");
                      
			var sessions =resultData_partial['sessionsCurrent']['encodedSessions'];
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

			
		pg_view_dates = resultData_partial['pageviewsCurrent']['encodedDates'];pg_view_dates = pg_view_dates.split(",");
            var pageviews = resultData_partial['pageviewsCurrent']['encodedpageviews'];
			pageviews = pageviews.replaceAll(/\"/g,'')
            pageviews = pageviews.substring(1, pageviews.length-1);
            pageviews = pageviews.split(",");
            
			// Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
          /*  var formattedDates = pg_view_dates.map(function(date) {
            const momentDate = moment(date, 'YYYY/MM/DD');
            const day = momentDate.format('D'); // Day of the month without leading zero
            const month = momentDate.format('MMM'); // Abbreviated month name in uppercase
			return day + ' ' + month;
            });*/

                       
			
			//chart for unique users
			dates=resultData_partial['uniqueusersCurrent']['encodedDates'];
            dates = dates.split(",");
            var uniqueusers =resultData_partial['uniqueusersCurrent']['encodedUsers'];
            uniqueusers = uniqueusers.replaceAll(/\"/g,'')
            var uniqueusers = uniqueusers.substring(1, uniqueusers.length-1);
            uniqueusers = uniqueusers.split(",");

            // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
           /* var formattedDates = dates.map(function(date) {
            const momentDate = moment(date, 'YYYY/MM/DD');
            const day = momentDate.format('D'); // Day of the month without leading zero
            const month = momentDate.format('MMM'); // Abbreviated month name in uppercase
			return day + ' ' + month;
            });*/

			//chart for unique users end
			
			//data for Average duration
			//var averagesessions =resultData_partial['averageSessionCurrent']['encodedAverage'];
			if(resultData_partial['averageSessionCurrent']['encodedAverage']!== undefined && resultData_partial['averageSessionCurrent']['encodedAverage'] !== null){
			const averageSessions =JSON.parse( resultData_partial['averageSessionCurrent']['encodedAverage']);			
			var averageMinutes = averageSessions.map(timeToMinutes);		
			// Parse each element and convert it to the desired format
			var formattedTimes = averageMinutes.map(formatTime);			
			//data for Average duration end	
			 }
			// To plot All in one graph and average duration graph
			plot_graphs(resultData_partial, formattedDates,pageviews, sessions, uniqueusers,formattedTimes,type)	;
			
			
        }

        function processData(resultData,interval,type)
        {	
			var dates =0;
            var sessions=0;
			$('#authorizedView').css('display', 'block');
			
            var totalsessions=(resultData['totalsessions']);
            if (totalsessions >= 1000) {
                totalsessions = (totalsessions / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
            }
            var sessionPercent=resultData['sessionPercent'];
			var sessionpercClass=(sessionPercent < 0 )? 'negative-value' : 'positive-value';
            var sessionpercspanClass=(sessionPercent < 0 )? 'arrow-down' : 'arrow-up';
            var sessionpercspanColor=(sessionPercent < 0 )? 'red' : 'green';
            var sessionpercspanSymbol=(sessionPercent < 0 )?  '↓' :  '↑';
            
			$("#divtotSession").html(totalsessions);
            $("#divsessionPerc").addClass(sessionpercClass);
            $("#divsessionPerc span").addClass(sessionpercspanClass);
            $('#divsessionPerc span').css('color', sessionpercspanColor);
            $('#divsessionPerc span').html(sessionpercspanSymbol + Math.abs(sessionPercent).toFixed(1)+"%");
            
			var totalpgviews=resultData['totalpgviews'];
			if (totalpgviews >= 1000) {
                totalpgviews = (totalpgviews / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
            }
            var pgviewsPercent=resultData['pgviewsPercent'];
            var pgviewsPercentClass=(pgviewsPercent < 0) ? 'negative-value' : 'positive-value';
            var pgviewsPercentspanClass=(pgviewsPercent < 0 )? 'arrow-down' : 'arrow-up';
            var pgviewsPercentColor=(pgviewsPercent < 0 )? 'red' : 'green';
            var pgviewsPercentSymbol=(pgviewsPercent < 0 )?  '↓' :  '↑';
			
            $("#divpgViews").html(totalpgviews);
            $("#divpgviewPerc").addClass(pgviewsPercentClass);
            $("#divpgviewPerc span").addClass(pgviewsPercentspanClass);
            $('#divpgviewPerc span').css('color', pgviewsPercentColor);
            $('#divpgviewPerc span').html(pgviewsPercentSymbol + Math.abs(pgviewsPercent).toFixed(1)+"%");
            
            var totalusers=resultData['totalusers'];
            if (totalusers >= 1000) {
                totalusers = (totalusers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
            }
            
			var totalusersPercent=parseFloat(resultData['totalusersPercent']);
			var totalusersPercentClass=(totalusersPercent < 0) ? 'negative-value' : 'positive-value';
            var totalusersPercentspanClass=(totalusersPercent < 0 )? 'arrow-down' : 'arrow-up';
            var totalusersPercentColor=(totalusersPercent < 0 )? 'red' : 'green';
            var totalusersPercentSymbol=(totalusersPercent < 0 )?  '↓' :  '↑';
            
            $("#divtotalUsers").html(totalusers);
            $("#divtotalUsersPerc").addClass(totalusersPercentClass);
            $("#divtotalUsersPerc span").addClass(totalusersPercentspanClass);
            $('#divtotalUsersPerc span').css('color', totalusersPercentColor);
            $('#divtotalUsersPerc span').html(totalusersPercentSymbol + Math.abs(totalusersPercent).toFixed(1)+"%");
            
            var newUsers=resultData['newusers'];
            if (newUsers >= 1000) {
                newUsers = (newUsers / 1000).toFixed(0) + 'K'; // Format as "K" if above 1000
            }
            
            var newusersPercent=parseFloat(resultData['newusersPercent']);
			var newusersPercentClass=(newusersPercent < 0) ? 'negative-value' : 'positive-value';
            var newusersPercentspanClass=(newusersPercent < 0 )? 'arrow-down' : 'arrow-up';
            var newusersPercentColor=(newusersPercent < 0 )? 'red' : 'green';
            var newusersPercentSymbol=(newusersPercent < 0 )?  '↓' :  '↑';

            $("#divnewUsers").html(newUsers);
            $("#divnewUsersPerc").addClass(newusersPercentClass);
            $("#divnewUsersPerc span").addClass(newusersPercentspanClass);
            $('#divnewUsersPerc span').css('color', newusersPercentColor);
            $('#divnewUsersPerc span').html(newusersPercentSymbol + Math.abs(newusersPercent).toFixed(1)+"%");
			
            if(interval == 'lastmonth'){
                $(".scard-compare").html("vs. Previous Month");
            }else if(interval == 'lastweek'){
                $(".scard-compare").html("vs. Previous Week");
            }
            else{
                $(".scard-compare").html("vs. Previous " + interval + " Days");
            }

            
             //   dates = resultData['graphsessions']['encodedDates'];
			dates=resultData['sessionsCurrent']['encodedDates'];
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
            // $('#loader').css('display','none');

                     /*   window.bar1= new Chart(ctx, {
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

                        });*/


           // var p_ctx = document.getElementById("myChartpv").getContext("2d");
            pg_view_dates = resultData['pageviewsCurrent']['encodedDates'];pg_view_dates = pg_view_dates.split(",");
			var pageviews = resultData['pageviewsCurrent']['encodedpageviews'];
			pageviews = pageviews.replaceAll(/\"/g,'')
            pageviews = pageviews.substring(1, pageviews.length-1);
            pageviews = pageviews.split(",");
            // Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
          /*  var formattedDates = pg_view_dates.map(function(date) {
            const momentDate = moment(date, 'YYYY/MM/DD');
            const day = momentDate.format('D'); // Day of the month without leading zero
            const month = momentDate.format('MMM'); // Abbreviated month name in uppercase
			return day + ' ' + month;
            });*/

                   /* window.bar = new Chart(p_ctx, {
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
                        });*/
						
			//data for unique users
			dates=resultData['uniqueusersCurrent']['encodedDates'];
            dates = dates.split(",");
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
						
			

			//data for Average duration
							
			/*dates=resultData['averageSessionCurrent']['encodedDates'];
             dates = dates.split(",");					
						
			// Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
            var formattedDates = dates.map(function(date) {
            const momentDate = moment(date, 'YYYY/MM/DD');
            const day = momentDate.format('D'); // Day of the month without leading zero
            const month = momentDate.format('MMM'); // Abbreviated month name in uppercase
			return day + ' ' + month;
			});
						
			dates = JSON.parse(resultData['averageSessionCurrent']['encodedDates']);*/
			if(resultData['averageSessionCurrent']['encodedAverage']!== undefined && resultData['averageSessionCurrent']['encodedAverage'] !== null){
			const averageSessions =JSON.parse( resultData['averageSessionCurrent']['encodedAverage']);
			
			var averageMinutes = averageSessions.map(timeToMinutes);// Parse each element and convert it to the desired format
			var formattedTimes = averageMinutes.map(formatTime);	
			//data for Average duration end
			}			
			// To plot All in one graph and average duration graph
			plot_graphs(resultData, formattedDates,pageviews, sessions, uniqueusers,formattedTimes,type);

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
                                 // e.stopPropagation();
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
			}

			var ctx2 = document.getElementById("deviceChart").getContext("2d");
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
                                //  e.stopPropagation();
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
				
                    $('#loader').css('display','none');					
                }
	// To plot All in one graph and average duration graph
	function plot_graphs(result_data, dates_data,page_views, sessions_data, unique_users,formatted_Times, type){
		
		var resultdata={};
		resultdata=result_data;
		var formattedDates=dates_data;
		var pageviews=page_views;
		var sessions=sessions_data;
		var uniqueusers=unique_users;
		var formattedTimes=formatted_Times;
		var graph_type=type;
		if(formattedDates== "Invalid date Invalid date"){						
			formattedDates="";
		}
		if(graph_type=="partial"){
		//console.log(resultdata);	
	$("#chartAll").css("height", "500px");
		//All in one graph	
		if (window.all) {
			window.all.destroy();
		}
  		var canvas = document.getElementById("myChartsp");
		var ctx = canvas.getContext("2d");
	window.all = new Chart(ctx, {
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
		responsive: true,
		maintainAspectRatio: false,
		hover: {
			mode: null, 
			intersect: false, 
			animationDuration: 0  
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
var a_ctx = document.getElementById("myChartaverage").getContext("2d");
//if( (JSON.parse(resultdata.averageSessionCurrent.encodedAverage)).length!==0 && (JSON.parse(resultdata.averageSessionCurrent.encodedDates)).length!==0) {
 if (resultdata.averageSessionCurrent.encodedAverage !== undefined && resultdata.averageSessionCurrent.encodedAverage !== null) {
	 //	$("#myChartaverage").removeClass("hidediv");
	//$("#myChartaverage").addClass("showdiv");
	//document.getElementById('chartContainer').textContent="";
	//document.getElementById('chartContainer').append($("#myChartaverage"));
		dates_avg=resultdata['averageSessionCurrent']['encodedDates'];
        dates_avg = dates_avg.split(",");
		// Convert dates to the desired format: yyyy/mm/dd to dd/mm/yyyy
        formattedDates_avg = dates_avg.map(function(date) {
        const momentDate = moment(date, 'YYYY/MM/DD');
        const day = momentDate.format('D'); // Day of the month without leading zero
        const month = momentDate.format('MMM'); // Abbreviated month name in uppercase
        return day + ' ' + month;
        });	
						
			// Function to adjust the canvas height dynamically
        
		if (window.avg) {
			window.avg.destroy();
		}
        // Call the function to set the initial height
       $("#chartContainer").css("height", "500px");
		var a_ctx = document.getElementById("myChartaverage").getContext("2d");
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
                //e.stopPropagation();
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
				
						
			//Average Duration graph End		
}
else{
								
			formattedDates_avg="";
		
		if (window.avg) {
			window.avg.destroy();
		}
        // Call the function to set the initial height
       $("#chartContainer").css("height", "500px");
		var a_ctx = document.getElementById("myChartaverage").getContext("2d");
	$("#chartContainer").css("height", "500px");
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
		
		
	}
	}
				
	function clearCanvas() {
    var canvas = document.getElementById("myChartsp");
    var ctx = canvas.getContext("2d");
    // Clear the entire canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    // Optionally, reset canvas width to ensure complete clearing
    canvas.width = canvas.width;  // This effectively resets the canvas
	}
				
	// Convert time strings to total minutes
     function timeToMinutes(timeStr) {
        var parts = timeStr.split(':').map(Number);
        if (parts.length === 2) {
            return parts[0] + parts[1]/60 ;
			
        } else if (parts.length === 3) {  // HH:MM:SS format		
            return parts[0] * 60 + parts[1] + parts[2]/60 ;
			
        }
        return 0;
    }

	
	// Function to convert minutes to a formatted time string
function formatTime(minutes) {
    var totalSeconds = minutes * 60;
    var hours = Math.floor(totalSeconds / 3600);
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

			function showLoadingAnimation() {
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
                }


    </script>

 <div class="card p-0">
    <div class="gcard-con pl-3 border border-light py-2 hidediv" id="ginsights" >
        <div class="gcard_heading">
            <img src="https://statamic.vijaysoftware.com/garesource/img/vijay-icon-100x100.png" width="30px" alt="analytic icon">
            <span>GInsights Analytics</span>
			<span class=" text-sm text-gray-700 mr-1">: </span>
			<div id="cachedUrlDisplay" class=" text-sm text-gray-700 ml-auto">
			<!-- Cached URL will be displayed here -->
			</div>
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
          <input type="submit" value="See Full Report" class="btn-primary ml-2 mr-1 fullreport" title="click to open Full Report" id="fullreport" />
          </form>
          
        </div>
             
		
        <div class="ggear pl-2 pr-3 toggle-button" id="ggear">
		
            <a href='utilities/analytics?reset=true' title="Settings"><i class="fa-solid fa-gear"></i></a>
		
        </div>
		
    </div>
	 <div class="row">
			<!-- Loader-->
      
			<!-- SVG content (e.g., shapes, paths, etc.) goes here -->
		  <div id="loader" class="dbloader" >
			 <!--  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="100" height="100">
			 <linearGradient id="a11">
				<stop offset="0" stop-color="#FF156D" stop-opacity="0"></stop>
				<stop offset="1" stop-color="#FF156D"></stop>
			  </linearGradient>
			  <circle fill="none" stroke="url(#a11)" stroke-width="8" stroke-linecap="round" stroke-dasharray="0 22 0 22 0 22 0 22 0 360" cx="100" cy="100" r="35" transform-origin="center">
				<animateTransform type="rotate" attributeName="transform" calcMode="discrete" dur="2" values="360;324;288;252;216;180;144;108;72;36" repeatCount="indefinite"></animateTransform>
			  </circle>
			  </svg>-->
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
</g><g></g></g>  </svg>
		  </div>

		 <div id="authorizedView" class="hidediv" >

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
           // showLoadingAnimation();
           
			$( "#tabs" ).tabs();
            //$( "#accordion" ).accordion();
			 $("#accordion").accordion({
            collapsible: true,
             active: 0 ,
			 heightStyle: "content"// Open the first section by default
			});
			
			var cachedUrl = localStorage.getItem('selectedUrl'); 
			// Retrieve the URL from localStorage
				if (cachedUrl !== null) {
					console.log('Retrieved URL:', cachedUrl); // Outputs the stored URL
					$('#cachedUrlDisplay').text(cachedUrl); // Optionally display the URL in a specific element
				}
		

            $('#fullreport').click(function(){
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
        <div class="row p-2 fullwidth"  id="chartAll">
        <canvas class= "chart-styles db_graph" id="myChartsp" ></canvas>
        </div>
        
        <h3>Top Devices</h3>
        <div id="chartTop"> 
        <canvas class= "chart-styles db_doughnutchart" id="deviceChart" ></canvas>
        </div>
		
		<h3>Average Session Duration</h3>		
        <div class="row p-2 fullwidth "  id="chartContainer">
        <canvas class= "chart-styles db_graph" id="myChartaverage" ></canvas>
        </div>

        <h3>New vs. Returning Visitors</h3>
        <div id="chartNewvsRet"> 
        <canvas class= "chart-styles db_doughnutchart" id="newvsreturnchart" > </canvas>
        </div>

        </div>
        


			
		<!--<div class="flex pl-3 border border-light py-2" id="ginsights" >
			<div class="flex-1 gcard_heading">
					<span>GInsights</span>
			</div>
		</div> -->
		<div  id="unauthorizedView" class="hidediv" >
        <div class="p-4 font-bold content-center">
          <h2>Please Authorize Your Google Account For Analytics Data</h2>
          <a href='<?php echo env('APP_URL')?>/cp/utilities/analytics?reauth=true' class="btn-primary ml-1 mr-1 mt-2 " title="Connect to Google" id="ConnecttoGoogle">Connect to Google</a>
        </div>
      </div>

	</div>
 
