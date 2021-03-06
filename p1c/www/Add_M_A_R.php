
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

	$db = new mysqli('localhost','cs143','','CS143');
	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}
	$sqlTitle = "SELECT id, title, year FROM Movie;";
	$rs_title = $db->query($sqlTitle);
	if (!($rs_title))
	{ 
		$errmsg = $db->error;
		die("Query sqlTitle failed: $errmsg <br />");
	}

	$sqlActor = "SELECT id, last, first, dob FROM Actor;";		
	$rs_actor = $db->query($sqlActor);
	if (!($rs_actor))
	{ 
		$errmsg = $db->error;
		die("Query sqlTitle failed: $errmsg <br />");
	}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if (empty($_POST['title'])) 
	{$titleErr = "Please select a movie";}
	else
	{$mid = $_POST['title'];}
	if (empty($_POST['actor'])) 
	{$actorErr = "Please select an actor";}
	else
	{$aid= $_POST['actor'];}
	if (empty($_POST['role'])) 
	{$roleErr = "Actor must have a role";}
	else
	{$role = $_POST['role'];}		
	$valid=$mid && $aid && $role;
	}

?>	

    <h3>Add Movie/Actor Relation</h3>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class = "inputpadding">
    		<p><span class="error">* Required field.</span></p>
            <label for="title">Movie title:</label><br>
            <select class="inputselect" name="title">
            <option value = ''></option>
            <?php
				while($row = $rs_title->fetch_assoc()){
					//foreach($row as $c_row){
					//	echo "<option> $c_row </option>\n";
					$movieid = $row["id"];
					$title = $row["title"];
					$year = $row["year"];
					echo "<option value = $movieid>$title ($year)</option>\n";
					//}
				}
            ?>
            </select>
            <span class="error">* <?php echo "$titleErr";?></span><br/><br/>
            <label for="actor">Actor:</label><br>
            <select class="inputselect" name="actor">
            <option value = ''></option>
            <?php
				while($row = $rs_actor->fetch_assoc()){
					$actorid = $row["id"];
					$last = $row["last"];
					$first = $row["first"];
					$dob = $row["dob"];
					echo "<option value = $actorid>$first $last ($dob)</option>\n";
				}
            ?>
            </select>
            <span class="error">* <?php echo "$actorErr";?></span><br/><br/>
            <label for="role">Role:</label><br>
            <input class = "inputtext" type="text" placeholder="Text input" name="role">
			<span class="error">* <?php echo "$roleErr";?></span><br/><br/>
            <button class = "inputsubmit" type="submit">Add</button>
        </div>
        </form>

<?php

if($valid){
	$sqlInsert = "INSERT INTO MovieActor VALUES('$mid', '$aid', '$role');";
	if (!($rs = $db->query($sqlInsert)))
	{ 
		$errmsg = $db->error;
		die("Query sqlInsert failed: $errmsg <br />");
	}	
	echo "Successfully added your movie/actor relation!";
	$db->close();
}

?>

	</body>
</html>