<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Refresh" content="30">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home - Dashboard</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->


</head>

<body>
		

	<div class="col-sm-12 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
			</ol>
			
			
			<div id="clockbox" class="panel-heading" style="top: 0px; right: 50%; left: 50%;position: absolute; font-weight: 800"></div>
			<div id="datebox" class="panel-heading" style="top: 0px; right: 0px; position: absolute"></div>
		</div><!--/.row-->
		
									
		<div class="row">
		
			<?php
			
			if (file_exists("../conf/switches.conf.php")){
				
			include("../lib/switches.php");
			
			echo '<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body tabs">
						
							<ul class="nav nav-pills">';
							#Set counter for elements in foreach loop
							$counter = 0;
							#generate list rooms for the tab panel
							foreach(switches_get_rooms() as $room){
								#if we are on the first element, show it as active
								if ($counter == 0){ $active = "active";} else{ $active = "";}
								echo '<li class="'.$active.'" ><a href="#'.$room.'" data-toggle="tab">'.$room.'</a></li>';
							$counter++;
							}
						
			echo '			</ul>
								
							<div class="tab-content">';
							#Set counter for elements in foreach loop
							$counter = 0;
							#generate the tab content by the array of switches which have been set in the configuration
							foreach (switches_get_rooms() as $room) {
								#if we are on the first element, show it as active
								if ($counter == 0){ $active = "active";} else{ $active = "";}
								echo '<div class="tab-pane fade in '.$active.'" id="'.$room.'">
									<h4>
										<table border=0 >';

									foreach (switches_get_switches_by_room($room) as $switch) {
										echo '
												<tr>
												<td style="width: 25px"><h2><i class="fa fa-power-off" id="'.$switch["id"].'" onclick="cC(this.id);" ></i></h2></td><td>'.$switch["description"].'</td>
												</tr>';
									}

								echo '</table></h4>
								</div>';
							$counter++;
							}
								

			echo '

							</div>
						</div>
					</div><!--/.panel-->
	
			</div>';
			}
			?>
		
		
		
		
		</div><!--/.row-->	
		
		
		<div class="row">
		</div><!--/.row-->
		
		
		
		<div class="row">

			
		</div><!--/.row-->
	</div>	<!--/.main-->
		  

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	tday=new Array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
	tmonth=new Array("Januar","Februar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
	
	function GetClock(){
	var d=new Date();
	var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear(),nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;
	
	
	if(nyear<1000) nyear+=1900;
	if(nmin<=9) nmin="0"+nmin;
	if(nsec<=9) nsec="0"+nsec;
	
	document.getElementById('clockbox').innerHTML=""+nhour+":"+nmin+":"+nsec;
	document.getElementById('datebox').innerHTML=""+tday[nday]+" "+ ndate + ". " +tmonth[nmonth]+" "+nyear;
	}
	
	
	GetClock();
	setInterval(GetClock,1000);
	</script>
	
	<script>
		$('#calendar').datepicker({
		});

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>
	
	

	<script>



	var a = [<?php
		foreach (switches_get_switches() as $switch) {
		echo '"'.$switch["id"].'", ';
		}
	?>];
	a.forEach(function(entry) {

	    $.get("status.php?switch="+entry, function(data){
	    if (data == 0){
	            document.getElementById(entry).style.color = "red";
	    return false;
	    }
	    if (data == 1){
	            document.getElementById(entry).style.color = "green";
	    return false;
	    }
	    });

	});



	function cC(id) {

	//$.get("switch.php?secret=0815&id="+id);

	$.get("switch.php?id="+id, function(data){
	if (data == 0){
	        document.getElementById(id).style.color = "red";
	return false;
	}
	if (data == 1){
	document.getElementById(id).style.color = "green";
	return false;
	}

	});



	}
	</script>
	
	
</body>

</html>
