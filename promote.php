<?php
if(isset($_POST['title']) || isset($_POST['a']) || isset($_POST['c'])){

	// CONNECT TO THE DATABASE
	//include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$title = preg_replace('#[^a-z0-9 ]#i', '', $_POST['title']);
	$a = preg_replace('#[^a-z0-9, ]#i', '', $_POST['a']);
	$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
	$s = preg_replace('#[^a-z ]#i', '', $_POST['s']);
	$z = preg_replace('#[^0-9]#', '', $_POST['z']);
	$desc = preg_replace('#[^a-z0-9, ]#i', '', $_POST['desc']);
	//get date time stamp
	$start =  $_POST['start'];
	$date = DateTime::createFromFormat('m/d/Y g:i a', $start);
	$fdate = $date->format('Y-m-d H:i:s');
	
	$pong = $_POST['pong'];
	$jj = $_POST['jj'];
	$dj = $_POST['dj'];
	$p = 0;
	$p = 0;
	$p = 0;
	if ($pong == true)
		$p = 1;
	if ($jj == true)
		$j = 1;
	if ($dj == true)
		$d = 1;
	// Form data Error Handling
	if($title == "" || $a == "" || $c == "" || $s == "" || $z == "" || $start == ""){
		echo "Form is missing information";
        exit();
	}
	else {
		// Begin Insertion of data into the database
		$link = mysqli_connect("dbhost-mysql.cs.missouri.edu", "lem346", "9ErVF9vM", "lem346");

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
		$sql = "INSERT INTO parties (title, address, city, state, zipcode, start, datecreated, datemodified, description, pong, jj, dj) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
		
		/* create a prepared statement */
		if ($stmt = mysqli_prepare($link, $sql)) {
			
			$timenum = time();
			$timestamp = date('Y-m-d H:i:s', $timenum);
			
			/* bind parameters for markers */
			mysqli_stmt_bind_param($stmt, "sssssssssiii",  $title, $a, $c, $s, $z, $fdate, $timestamp, $timestamp, $desc, $p, $j, $d);

			/* execute query */
			//mysqli_stmt_execute($stmt);
			
			if(!mysqli_stmt_execute($stmt)){
				echo "Execute failed: (" . mysqli_stmt_errno($stmt) . ") " . mysqli_stmt_error($stmt);
				exit();
			}

			/* close statement */
			mysqli_stmt_close($stmt);
			
			echo "party_added";
			exit();
		}
		else{
			echo "Failed to prepare SQL statement.";
			exit();
		}
	}
	echo "Just failed.";
	exit();
}
?>
<!DOCTYPE html>
<head>
<title>Promote</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

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
		var start = _("start").value;
		var desc = _("description").value;
		var status = _("status");
		var pong = _("pong").checked;
		var jj = _("jj").checked;
		var dj = _("dj").checked;
		
		if(title == "" || a == "" || c == "" || s == "" || z == "" || start == ""){
			status.innerHTML = "Fill out all of the form data";
		} else {
			_("addpartybtn").style.display = "none";
			status.innerHTML = 'please wait ...';
			var ajax = ajaxObj("POST", "promote.php");
			ajax.onreadystatechange = function(){
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText != "party_added"){
						status.innerHTML = ajax.responseText;
						_("addpartybtn").style.display = "block";
					} else {
						window.scrollTo(0,0);
						_("addpartyform").innerHTML = "OK, You have successfully posted a new party. </br>Party information is as follows:</br>Title: "+title+
						"</br>Address: "+a+"</br>City: "+c+"</br>State: "+s+"</br>Zip Code: "+z+ "</br>Start Time: "+start+"</br>Description: "+desc+
						"</br>Click here to view list of parties: <a href='http://babbage.cs.missouri.edu/~lem346/PartyFinder/find.php'>View List</a>";
					}
				}
				else{
					status.innerHTML = 'ajaxReturn(ajax) != true';
					_("addpartybtn").style.display = "block";
				}
			}
			ajax.send("title="+title+"&a="+a+"&c="+c+"&s="+s+"&z="+z+"&start="+start+"&desc="+desc+"&pong="+pong+"&jj="+jj+"&dj="+dj);
		}
	}
</script>
	
</head>
<body>
    <?php include_once("template_navbar.php"); ?>
<br/>
<br/>
<div class="container">
	<div class="jumbotron">
		<h1>Where's the Party At?!</h1>
		<form role="form" id="addpartyform" onsubmit="return false">
			<div class="row"><div class="col-xs-5"><div class="form-group">
				<label >Event Title</label>
				<input type="text" class="form-control" id="title" placeholder="Enter a title for the event" onfocus="emptyElement('status')">
			</div></div></div>
			<div class="row"><div class="col-xs-4"><div class="form-group">
				<label >Street Address</label>
				<input type="text" class="form-control" id="address" placeholder="Enter street address" onfocus="emptyElement('status')">
			</div></div></div>
			<div class="row"><div class="col-xs-4"><div class="form-group">
				<label>City</label>
				<input type="text" class="form-control" id="city" placeholder="Enter City" onfocus="emptyElement('status')">
			</div></div></div>
			<div class="row"><div class="col-xs-3"><div class="form-group">
				<label>State</label>
				<input type="text" class="form-control" id="state" placeholder="Enter State" onfocus="emptyElement('status')">
			</div></div></div>
			<div class="row"><div class="col-xs-3"><div class="form-group">
				<label>Zip Code</label>
				<input type="text" class="form-control" id="zipcode" placeholder="Enter Zip Code" onfocus="emptyElement('status')">
			</div></div></div>
			<div class="row"><div class="col-xs-3"><div class="form-group">
				<label>Start Time</label>
				<div class="input-group date" id="datetimepicker1">
					<input type="text" class="form-control" id="start" readonly>
					<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
				</div>
			</div></div></div>
			<div class="form-group">
				<label>Description</label>
				<textarea rows="4" id="description" class="form-control" placeholder="Enter Party Description" onfocus="emptyElement('status')"></textarea>
			</div>
			<div class="form-group">
				<label class="checkbox-inline">
					<input type="checkbox" id="pong" value="option1"> Beer Bong
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="jj" value="option2"> Jungle Juice
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="dj" value="option3"> Speakers/DJ
				</label>
			</div>
			<button id="addpartybtn" class="btn btn-default" onclick="addParty()">Create Party</button>
			<p id="status"></p>
		</form>
	</div>
</div>

<!-- Javascript Plugins -->
	<script src="js/main.js"></script>
	<script src="js/ajax.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/moment.js"></script>
	<script src="js/bootstrap-datetimepicker.js"></script>
<!-- Javascript Functions (Order Matters)-->
	<script>
		$('#datetimepicker1').datetimepicker();
	</script>
</body>