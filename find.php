<!DOCTYPE html>
<html lang="en">
	<style type="text/css">
   		body { background: navy; }
	</style>

  <head>
	<title>Find</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
 </head>
  
 <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
<?php 	include_once("template_navbar.php");
			include_once("php_includes/db_conx.php"); ?>
	</br>
	<div class = 'container'>
		<div class='jumbotron'>
		<h1>What's the move for tonight?</h1>
		<p>Below is a list of local of parties, or click the button below to promote a party.</p>
		<p><a class='btn btn-success btn-lg' href='promote.php' role='button'>Promote A Party</a></p>
	</div>

<?php	
	$query= "SELECT * FROM parties ORDER BY datecreated DESC";
	
	if ($result = mysqli_query($db_conx, $query)){
		while($row = mysqli_fetch_assoc($result)){
			//change format of date
			$myDateTime = DateTime::createFromFormat('Y-m-d G:i:s', $row["start"]);
			$newDateString = $myDateTime->format('l, F jS, Y g:i a');
			//get party id
			$pid = $row["id"];
			
			//display results in jumbotrons
			echo
			"<div class='jumbotron'>
				<label>" .$row["title"]. "</label></br>Address: " .$row["address"]. "</br>".$row["city"]. ", " .$row["state"]. " " .$row["zipcode"]. "</br>Start Time: ".$newDateString."</br>
				<form action='partyinfo.php' method='POST'>
                        <input type='hidden' name='pid' value='$pid'/>
                        <input type='submit' name='submit' value='Details'/>
                </form>
			</div>"; 
		}
		//free result set
		mysqli_free_result($result);
	}
	//close connection
	mysqli_close($db_conx);
	//close container div 
	echo "</div>";
	?>
</body>
</html>