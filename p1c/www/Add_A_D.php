<html>
	<head>	
	<title>MovieDB Search Engine</title>
	<meta charset="utf-8">
	<style>
	img {
    	max-width: 100%;
    	height: auto;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="mycss.css" />
		<!--<title>MovieDB: Add Actor/Director</title>-->
		<center><h1>MovieDB Search Engine</h1></center>
	</head>
	<body>
	<div class = "back">
		<a class = "button" href="homepage.php"> Home </a>
		<div class="dropdown">
		<span><button class = "button">Add New Content</button></span>
			<div class = "dropdown-content">
		    	<a href="Add_A_D.php">Add Actor/Director</a><br>
		        <a href="Add_M.php">Add Movie Information</a><br>
            	<a href="Add_M_A_R.php">Add Movie/Actor Relation</a><br>
            	<a href="Add_M_D_R.php">Add Movie/Director Relation</a><br>
            	<a href="Add_R.php">Add Movie Review</a>
			</div>
		</div>
		<div class="dropdown">
			<span><button class="button">Browsering Content</button></span>
			<div class = "dropdown-content">
				<a href="Show_A.php">Show Actor Information</a><br>
            	<a href="Show_M.php">Show Movie Information</a>
			</div>
		</div>
		<div class="dropdown">
			<span><button class = "button">Search Interface</button></span>
			<div class = "dropdown-content">
				<a href="search.php">Search/Actor Movie</a>
			</div>
		</div>
	</div>
	
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if (empty($_POST["fname"])) 
	$fnameErr = "First name is required";
	else
	$fname = $_POST['fname'];
	if (empty($_POST["lname"])) 
	$lnameErr = "Last name is required";
	else
	$lname = $_POST['lname'];
	if (empty($_POST["type"])) 
	$typeErr = "Type is required";
	else
	$type = $_POST['type'];
	if (empty($_POST["dob"])) 
	$dobErr = "Date of Birth is required";
	else
	$dob = $_POST['dob'];
	if (empty($_POST["sex"])) 
	$sexErr = "Gender is required";
	else
	$sex = $_POST['sex'];
	if (empty($_POST["dod"])) 
	$dod = "NULL";
	else
	$dod = $_POST['dod'];
	
	$valid=$type && $fname && $lname && $sex && $dob;
	}
	?>
	
	<h4>Add new Actor/Director:</h4>
	<div class = "inputpadding">
	<p><span class="error">* Required field.</span></p>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="radio" name="type" value="Actor">Actor
	<input type="radio" name="type" value="Director">Director
	<span class="error">* <?php echo "$typeErr";?></span><br/><br/>
	<label for="title">First Name:</label><br>
	<input class = "inputtext" placeholder="Text input" type="text" name="fname">
	<span class="error">* <?php echo "$fnameErr";?></span><br/><br/>
	<label for="title">Last Name:</label><br>
	<input class = "inputtext" placeholder="Text input" type="text" name="lname">
	<span class="error">* <?php echo "$lnameErr";?></span><br/><br/>
	<input type="radio" name="sex" value="Male">Male
	<input type="radio" name="sex" value="Female">Female
	<span class="error">* <?php echo "$sexErr";?></span><br/><br/>
	<label for="title">Date of Birth:</label><br>
	<input class = "inputtext" placeholder="Text input" type="text" name="dob">(ie: 1997-05-05)
	<span class="error">* <?php echo "$dobErr";?></span><br/><br/>
	<label for="title">Date of Die:</label><br>
	<input class = "inputtext" placeholder="Text input" type="text" name="dod">(Leave blank if alive now)<br/><br/>
	<button class = "inputsubmit" type="submit">Add</button>
	</div>
</form>

<?php
	function checkDateIsValid($date) {
		$format="Y-m-d";
		$date_create = DateTime::createFromFormat("Y-m-d", $date);
		if(!$date_create)
			return False;
		if($date!=$date_create->format("Y-m-d"))
			return False;
		return True;
	}
	if($valid)
	{
		if(!checkDateIsValid($dob)||($dod!="NULL"&&!checkDateIsValid($dod))) { 
			die("Invalid input: date format error.");
		}
		if($dod!="NULL"&&DateTime::createFromFormat("!Y-m-d", $dod)<DateTime::createFromFormat("!Y-m-d", $dob))
			die("Invalid input: date of birth $dob is after date of death $dod");
		$db = new mysqli('localhost', 'cs143', '');
		if($db->connect_errno > 0)
		{
			die('Unable to connect to database [' . $db->connect_error . ']');
		}
		$db->select_db("CS143");
		$sqlMaxID = "SELECT * FROM MaxPersonID;";
		if (!($rs = $db->query($sqlMaxID)))
		{ 
			$errmsg = $db->error;
			die("Query sqlMaxID failed: $errmsg <br />");
		}
		$row = $rs->fetch_assoc();
		$newID = $row["id"]+1;
		$sqlUpdate = "UPDATE MaxPersonID SET id = id + 1;";
		if (!($rs = $db->query($sqlUpdate)))
		{ 
			$errmsg = $db->error;
			die("Query sqlUpdate failed: $errmsg <br />");
		}
		if ($type=="Actor")
		{
			$sqlInsert = "INSERT INTO Actor VALUES('$newID', '$lname', '$fname', '$sex', '$dob', '$dod');";
		}
		else
		{
			$sqlInsert = "INSERT INTO Director VALUES('$newID', '$lname', '$fname', '$dob', '$dod');";
		}
		if (!($rs = $db->query($sqlInsert)))
		{ 
			$errmsg = $db->error;
			die("Query sqlInsert failed: $errmsg <br />");
		}
		if($dod=="NULL")
		echo "Add Success:<br/>$newID $fname $lname $sex $dob still alive";
		else
		echo "Add Success:<br/>$newID $fname $lname $sex $dob $dod";
		$db->close();
	}

?>

		
	</body>
</html>
