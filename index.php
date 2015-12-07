<!DOCTYPE html>
<html>
<head>
	<title>PHP Test</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		/*
		*	This javascript function uses JQuery and AJAX to retrive information
		*	about staff members from a data array held within another .php file.
		* it then outputs this information into the <div id="more-info">...
		*	
		*	The page getStaffInfo.php checks for the $_GET variables: name and code
		*/
		function getInfo(name, code){
			$(".info-box").load('getStaffInfo.php?name=' + name + '&code=' + code);
		}
	</script>
	<style>
		#info-box{
			margin-top: 20px;
			border: 1px solid #AAA;
		}
	</style>
</head>
<body>
<php
	
	/*
	*	This is the Main section of code.
	*	
	*	It first works out whether you've tried to log in or not
	*	then it will show you the relevant content:
	*	- A form if you haven't logged into the database OR
	*	- A list of staff if you have logged into the database.
	*/
	if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != "" && $_POST['password'] != ""){
		$db = getDatabase("localhost", $_POST['username'], $_POST['password'], "php_test");
		if($db->connect_errno){
			printForm();
		}else{
			showStaff($db);
		}
	}else{
		printForm();
	}
	
	/*
	*	This function prints a form that will take the user's
	* Username and Password and send them to this same page
	*	once the submit button is pressed.
	*/
	function printForm(){
		echo "
			<h2>Enter your details below:</h2>
			<form name='input' action='{$_SERVER['PHP_SELF']}' method='get'>
		    <label for='username'>Username:</label>
				<input type='text' id='username' name='username'/>
				<br />
		    <label for='password'>Password:</label>
				<input type='password' id='password' name='password'/>
				<br /><br />
		    <input type='reset' value='Log In' name='submit' />
		  </form>
		";
	}
	
	/*
	*	This function takes user details and tries to log you into the database.
	*	If the details are correct then the database is returned.
	*	If the details are incorrect then an error is given.
	*/
	function getDatabase($host, $username, $password, $database){
		$mysqli = new mysqli($host, $username, $password, $database);
		if ($mysqli->connect_errno){
			echo "Your login Username or Password is invalid";
			echo "<br />";
		}else{
			echo "Connection to database established!";
			echo "<br />";
		}
		return $mysqli;
	}
	
	/*
	*	This function attempts to get the staff and their respective codes
	*	using the function getStaffCodes. It then iterated over each of these
	* staff members and creates a button that upon being clicked will call
	* a javascript script called getInfo.
	*
	*	It also creates a <div> element in which details about the staff can
	*	later be added to.
	*/
	function showStaff($db){
		$result = getStaffCodes();
		echo "<h2>Staff members are:</h2>";
		while($row = mysqli_fetch_array($result)){
			$name = "{$row['first_name']}";
			$code = "{$row['code']}";
			echo "<input id='button1' type='button' value=$name onclick=\"getInfo($name, $code);\" />";
		}
		echo "<div id='info-box'>Click a button above to see the information here.</div>";
	}
	
	/*
	*	This function returns a mysqli array from the database
	*	containing the first_name and code of each of the staff members.
	*/
	function getStaffCodes(){
		$query = "
			SELECT first_name, code
			FROM secret_codes;
		";
		$result = mysqli_query($db, $query);
		return $result;
	}
	
	/*
	*	This function is empty but this is where you will make the query to
	*	add yourself to the table within the database.
	*
	* NOTE: Only the "admin" account has the right privileges to INSERT data into the table!
	*/
	function addYourself(){
		// Please try to only add yourself once if possible.
	}
?>
</body>
</html>