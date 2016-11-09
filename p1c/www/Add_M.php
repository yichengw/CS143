
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
	if (empty($_POST['title'])) 
	{$titleErr = "Movie Title is required";}
	else
	{$title = $_POST['title'];}
	if (empty($_POST['company'])) 
	{$companyErr = "Movie company is required";}
	else
	{$company = $_POST['company'];}
	if (empty($_POST['year'])) 
	{$yearErr = "Movie year is required";}
	else

	{	
		$year = $_POST['year'];	
		$pattern = "/^\d{4}$/";	//year
		if(!preg_match($pattern, $year)){
		$yearErr = "Invalid format for movie year";
		$year = "";
		}
	}
	$rate = $_POST['rate'];
		
	$valid=$title && $company && $year;
	}
?>	

    <h3>Add Movie Information</h3>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class = "inputpadding">
    		<p><span class="error">* Required field.</span></p>
        	<label for="title">Title:</label><br>
            <input class = "inputtext" type="text" placeholder="Text input" name="title">
			<span class="error">* <?php echo "$titleErr";?></span><br/><br/>
            <label for="company">Company:</label><br>
            <input class = "inputtext" type="text" class="form-control" placeholder="Text input" name="company">
            <span class="error">* <?php echo "$companyErr";?></span><br/><br/>
            <label for="year">Year:</label><br>
            <input class = "inputtext" type="text" class="form-control" placeholder="Text input" name="year">
            <span class="error">* <?php echo "$yearErr";?></span><br/><br/>
            <label for="rating">MPAA Rating</label><br>
            <select   class="inputselect" name="rate">
                <option value="G">G</option>
                <option value="NC-17">NC-17</option>
                <option value="PG">PG</option>
                <option value="PG-13">PG-13</option>
                <option value="R">R</option>
                <option value="surrendere">surrendere</option>
            </select>
            <span class="error">* <?php echo "$rateErr";?></span><br/><br/>
            <label for="title">Genre:</label><br>
            <input type="checkbox" name="genre[]" value="Action">Action</input>
            <input type="checkbox" name="genre[]" value="Adult">Adult</input>
            <input type="checkbox" name="genre[]" value="Adventure">Adventure</input>
            <input type="checkbox" name="genre[]" value="Animation">Animation</input>
            <input type="checkbox" name="genre[]" value="Comedy">Comedy</input>
            <input type="checkbox" name="genre[]" value="Crime">Crime</input>
            <input type="checkbox" name="genre[]" value="Documentary">Documentary</input>
            <input type="checkbox" name="genre[]" value="Drama">Drama</input>
            <br>
            <input type="checkbox" name="genre[]" value="Family">Family</input>
            <input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input>
            <input type="checkbox" name="genre[]" value="Horror">Horror</input>
            <input type="checkbox" name="genre[]" value="Musical">Musical</input>
            <input type="checkbox" name="genre[]" value="Mystery">Mystery</input>
            <input type="checkbox" name="genre[]" value="Romance">Romance</input>
            <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input>
            <input type="checkbox" name="genre[]" value="Short">Short</input>
            <br>
            <input type="checkbox" name="genre[]" value="Thriller">Thriller</input>
            <input type="checkbox" name="genre[]" value="War">War</input>
            <input type="checkbox" name="genre[]" value="Western">Western</input>
            <br/><br/>
            <button class = "inputsubmit" type="submit">Add</button>
        </div>
        </form>

<?php
if($valid){
	$db = new mysqli('localhost','cs143','','CS143');
	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$sqlMaxID = "SELECT * FROM MaxMovieID;";
	if (!($rs = $db->query($sqlMaxID)))
	{ 
		$errmsg = $db->error;
		die("Query sqlMaxID failed: $errmsg <br />");
	}
	$row = $rs->fetch_assoc();
	$newID = $row["id"]+1;
	$sqlUpdate = "UPDATE MaxMovieID SET id = id + 1;";	
	if (!($rs = $db->query($sqlUpdate)))
	{ 
		$errmsg = $db->error;
		die("Query sqlUpdate failed: $errmsg <br />");
	}
	$sqlInsert = "INSERT INTO Movie VALUES('$newID', '$title', '$year', '$rate','company');";
	if (!($rs = $db->query($sqlInsert)))
	{ 
		$errmsg = $db->error;
		die("Query sqlInsert failed: $errmsg <br />");
	}
	
	if(isset($_POST['genre'])){
		foreach ($_POST['genre'] as $gvalue) {
			//echo $gvalue;
			$sqlInsert = "INSERT INTO MovieGenre VALUES('$newID', '$gvalue');";
			if (!($rs = $db->query($sqlInsert)))
			{ 
				$errmsg = $db->error;
				die("Query sqlInsert failed: $errmsg <br />");
			}
		}
	}
	echo "Successfully added your movie information!";
	$db->close();
}
?>

	</body>
</html>