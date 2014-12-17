<!DOCTYPE html>
<head>
<title>Advertise</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

	<?php include_once("template_navbar.php"); ?>
<br/>
<br/>
<div class="container">
	<div class="jumbotron">
		<h1>Party Posted Successfully!</h1>
		
		<script>
		  $('#loading-example-btn').click(function () {
		    var btn = $(this)
		    btn.button('loading')
		    $.ajax(...).always(function () {
		      btn.button('reset')
		    });
		  });
		</script>
		<br/>
		<br/>
		<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>
		<div style='overflow:hidden;height:400px;width:520px;'><div id='gmap_canvas' style='height:400px;width:520px;'></div>
		<style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div>
		<a href='http://wwwonlinecasino.ca/'>Online Casino</a> <script type='text/javascript' src='http://maps-generator.com/google-maps-authorization/script.js?id=c5b924431276b466c49b3648157a28cc54211fe8'></script><script type='text/javascript'> function init_map(){
		var myOptions = {
		zoom:12,center:new google.maps.LatLng(38.9076831,-92.3323514),
		mapTypeId: google.maps.MapTypeId.ROADMAP};
		map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
		marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(38.9076831,-92.3323514)});
		infowindow = new google.maps.InfoWindow({
		content:'<div>'+
		'<h5> Halloween Turnup </h5>'+
		'</div>'+
		'<div> 3908 buttonwood dr apt 301 </div>'+
		'<div> 65201 Columbia </div>'
		});
		google.maps.event.addListener(marker, 'click', function(){
		infowindow.open(map,marker);
		});
		infowindow.open(map,marker);
		}
		google.maps.event.addDomListener(window, 'load', init_map);
		</script>
	</div>
</div>  	

</body>