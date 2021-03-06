<?php
session_start();
// If user is logged in, header them away
if(isset($_SESSION["username"])){
  header("location: message.php?msg=You are already logged in!");
    exit();
}
?>
<?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
  include_once("php_includes/db_conx.php");
  $username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
  $sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
      echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
      exit();
    }
  if (is_numeric($username[0])) {
      echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
      exit();
    }
    if ($uname_check < 1) {
      echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
      exit();
    } else {
      echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
      exit();
    }
}
?>
<?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");

	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	// GET USER IP ADDRESS
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
	$query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
	$query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == ""){
		echo "The form submission is missing values.";
			exit();
	}
	else if ($u_check > 0){ 
		echo "The username you entered is alreay taken";
		exit();
	}
	else if ($e_check > 0){ 
		echo "That email address is already in use in the system";
		exit();
	}
	else if (strlen($u) < 3 || strlen($u) > 16) {
		echo "Username must be between 3 and 16 characters";
		exit(); 
	} else if (is_numeric($u[0])) {
		echo 'Username cannot begin with a number';
		exit();
	}
	else {
		// END FORM DATA ERROR HANDLING
		// Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
		$cryptpass = crypt($p);
		include_once ("php_includes/randStrGen.php");
		$p_hash = randStrGen(20)."$cryptpass".randStrGen(20);
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (username, email, password, ip, signup, lastlogin, notescheck) VALUES('$u','$e','$p_hash','$ip',now(),now(),now())";
		//$query = mysqli_query($db_conx, $sql); 
		if (mysqli_query($db_conx, $sql) != true){
			echo "unsuccessful insertion";
			exit();
		} 
		$uid = mysqli_insert_id($db_conx);
		// Establish their row in the useroptions table
		$sql = "INSERT INTO useroptions (id, username) VALUES ('$uid','$u')";
		//$query = mysqli_query($db_conx, $sql);
		if (mysqli_query($db_conx, $sql) != true){
			echo "unsuccessful insertion 2";
			exit();
		} 
		// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
		if (!file_exists("user/$u")) {
		  mkdir("user/$u", 0755);
		}
		// Email the user their activation link
		$to = "$e";
		$from = "lem346@mail.missouri.edu";
		$subject = 'Party Finder Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Party Finder Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://babbage.cs.missouri.edu/~lem346/PartyFinder/index.php"></a>Party Finder Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="https://http://babbage.cs.missouri.edu/~lem346/PartyFinder/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
		$headers = "From: $from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $message, $headers);
		echo "signup_success";
		exit();
	}
	exit();
}
?>

<!DOCTYPE html>
<html>
  <head>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  
  <script src="js/main.js"></script>
  <script src="js/ajax.js"></script>

<script>
function restrict(elem){
  var tf = _(elem);
  var rx = new RegExp;
  if(elem == "email"){
    rx = /[' "]/gi;
  } else if(elem == "username"){
    rx = /[^a-z0-9]/gi;
  }
  tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
  _(x).innerHTML = "";
}
function checkusername(){
  var u = _("username").value;
  if(u != ""){
    _("unamestatus").innerHTML = 'checking ...';
    var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
          if(ajaxReturn(ajax) == true) {
              _("unamestatus").innerHTML = ajax.responseText;
          }
        }
        ajax.send("usernamecheck="+u);
  }
}
function signup(){
	var u = _("username").value;
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	var status = _("status");
	if(u == "" || e == "" || p1 == "" || p2 == ""){
		status.innerHTML = "Fill out all of the form data";
	}
	else if(p1 != p2){
		status.innerHTML = "Your password fields do not match";
	}
	else {
		_("signupbtn").style.display = "none";
		status.innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "signup.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				  if(ajax.responseText != "signup_success"){
					status.innerHTML = ajax.responseText;
					_("signupbtn").style.display = "block";
				  } else {
					window.scrollTo(0,0);
					_("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";
				  }
			}
			else{
				status.innerHTML = "ajaxReturn(ajax) != true";
				_("signupbtn").style.display = "block";
			}
			ajax.send("u="+u+"&e="+e+"&p="+p1);
		}
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

  <h3>Sign Up Here</h3>
	<form role="form" name=signupform" id="signupform" onsubmit="return false">
		<div>Username: </div>
		<input id="username" type="text" onblur="checkusername()" maxlength="16">
		<span id="unamestatus"></span>
		<div>Email Address:</div>
		<input id="email" type="text" maxlength="88">
		<div>Create Password:</div>
		<input id="pass1" type="password" maxlength="16">
		<div>Confirm Password:</div>
		<input id="pass2" type="password" maxlength="16">
		<br /><br />
		<button id="signupbtn" onclick="signup()">Create Account</button>
		</br></br>
		<span id="status">Good</span>
	</form>
</body>
</html>