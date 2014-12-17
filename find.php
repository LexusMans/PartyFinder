<!DOCTYPE html>
<html lang="en">
	<style type="text/css">
   		body { background: navy; }
	</style>

  <head>
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
		<h1>Choose your Amenities!</h1>
		<p>Check all that you are interested in!</p>
		<div class="btn-group" data-toggle="buttons">
		  <label class="btn btn-primary">
		    <input type="checkbox"> Jungle Juice
		  </label>
		  <label class="btn btn-primary">
		    <input type="checkbox"> Music
		  </label>
		  <label class="btn btn-primary">
		    <input type="checkbox"> Backyard
		  </label>
		  <label class="btn btn-primary">
		    <input type="checkbox"> DJ
		  </label>
		  <label class="btn btn-primary">
		    <input type="checkbox"> High Capacity
		  </label>
		  <label class="btn btn-primary">
		    <input type="checkbox"> Kickback
		  </label>
		</div>
		<br/>
		<br/>
		<button type="button" id="loading-example-btn" data-loading-text="Loading..." class="btn btn-primary">
		  Search
		</button>
	</div>
</div>
	<?php
		include_once("php_includes/db_conx");
		
		$sql = "SELECT * FROM parties";
		$result = $db_conx->query($sql);
		
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo "Event Title: " .$row["title"]. "</br>Address: " .$row["address"]. "</br>".$row["city"]. ", " .$row["state"]. " " .$row["zipcode"]. "</br>"; 
			}
		}
	?>


  </body>
</html>