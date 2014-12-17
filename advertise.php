<?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["a"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$title = preg_replace('#[^a-z0-9 ]#i', '', $_POST['title']);
	$a = preg_replace('#[^a-z0-9, ]#i', '', $_POST['a']);
	$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
	$s = preg_replace('#[^a-z ]#i', '', $_POST['s']);
	$z = preg_replace('#[^0-9]#', '', $_POST['z']);
	//$start = $_POST['start'];
	//$end = $_POST['end'];
	// DUPLICATE DATA CHECKS FOR PARTY
	// FORM DATA ERROR HANDLING
	if($title == "" || $a == "" || $c == "" || $s == "" || $z == ""){
		echo "The form submission is missing values.";
        exit();
	} else {
		// END FORM DATA ERROR HANDLING
		// Begin Insertion of data into the database
		//$sql = "INSERT INTO parties (title, address, city, state, zipcode, startdate, enddate, datecreated, datemodified) VALUES('$title', $a','$c','$s','$z','$start','$end',now(),now())";
		$sql = "INSERT INTO parties (title, address, city, state, zipcode, datecreated, datemodified) VALUES('$title', '$a','$c','$s','$z',now(),now())";
		$query = mysqli_query($db_conx, $sql); 
		if ($query === TRUE){
			echo "party_added";
		} else{
			echo "insertion unsuccessful.";
		}
		exit();
	}
	exit();
}
?>
<!DOCTYPE html>
<head>
<title>Advertise</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/ajax.js"></script>
	<script>
	function emptyElement(x){
		_(x).innerHTML = "";
	}
	function addParty(){
		var title = _("title").value;
		var a = _("address").value;
		var c = _("city").value;
		var s = _("state").value;
		var z = _("zipcode").value;
		//var start = _("start").value;
		//var end = _("end").value;
		var status = _("status");
		if(title == "" || a == "" || c == "" || s == "" || z == ""){
			status.innerHTML = "Fill out all of the form data";
		} else {
			_("addpartybtn").style.display = "none";
			status.innerHTML = 'please wait ...';
			var ajax = ajaxObj("POST", "advertise.php");
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText != "party_added"){
						status.innerHTML = ajax.responseText;
						_("addpartybtn").style.display = "block";
					} else {
						window.scrollTo(0,0);
						_("addpartyform").innerHTML = "OK, You have successfully posted a new party. </br>Party information is as follows:</br>Title: "+title+
						"</br>Address: "+a+"</br>City: "+c+"</br>State: "+s+"</br>Zip Code: "+z+
						"</br>Click here to advertise another: <a href='http://babbage.cs.missouri.edu/~lem346/PartyFinder/advertise.php'>Advertise</a>";
					}
				}
			}
			ajax.send("title="+title+"&a="+a+"&c="+c+"&s="+s+"&z="+z);
		}
	}
	</script>
	
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
		<h1>Where's the Party At?!</h1>
		<form role="form" id="addpartyform" onsubmit="return false">
			<div class="form-group">
				<label >Event Title</label>
				<input type="text" class="form-control" id="title" placeholder="Enter a title for the event" onfocus="emptyElement('status')">
			</div>
		  <div class="form-group">
			<label >Street Address</label>
			<input type="text" class="form-control" id="address" placeholder="Enter street address" onfocus="emptyElement('status')">
		  </div>
		  <div class="form-group">
			<label>City</label>
			<input type="text" class="form-control" id="city" placeholder="Enter City" onfocus="emptyElement('status')">
		  </div>
		  <div class="form-group">
			<label>State</label>
			<input type="text" class="form-control" id="state" placeholder="Enter State" onfocus="emptyElement('status')">
		  </div>
		  <div class="form-group">
			<label>Zip Code</label>
			<input type="text" class="form-control" id="zipcode" placeholder="Enter Zip Code" onfocus="emptyElement('status')">
		  </div>
<!--
			<div class="form-group">
			<label>Start</label>
				<div class='input-group date'>
					<input type='text' class="form-control" id="start" onfocus="emptyElement('status')"/> 
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
			<div class="form-group">
			<label>End</label>
				<div class='input-group date'>
					<input type='text' class="form-control"  id="end" onfocus="emptyElement('status')"/>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
-->
				<button id="addpartybtn" class="btn btn-default" onclick="addParty()">Create Party</button>
		   <p id="status"></p>
		</form>
	</div>
</div>
</body>