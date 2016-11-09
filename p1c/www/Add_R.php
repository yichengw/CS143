
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


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if (empty($_POST['title'])) 
	{$titleErr = "Please select a movie";}
	else
	{$mid = $_POST['title'];}
	if (empty($_POST['name'])) 
	{$nameErr = "Please input your name";}
	else
	{$name= $_POST['name'];}
	if (empty($_POST['rating'])) 
	{$ratingErr = "Please leave a rating";}
	else
	{$rating= $_POST['rating'];}
	if (empty($_POST['review'])) 
	{$reviewErr = "Please leave a review";}
	else
	{$review= $_POST['review'];}			
	$valid=$mid && $name && $rating && $review;
	}

?>	

    <h3>Add Movie/Actor Relation</h3>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class = "inputpadding">
    		<p><span class="error">* Required field.</span></p>
            <label for="title">Movie title:</label><br>
            <select class="inputselect" name="title">
            <?php
            	
            	if(isset($_GET["mid"]))
            	{
            		$getid = $_GET["mid"];
            		$sqlSelect2 = "SELECT title, year FROM Movie WHERE id = $getid;";
					if (!($rs = $db->query($sqlSelect2)))
					{ 
						$errmsg = $db->error;
						die("Query sqlSelect2 failed: $errmsg <br />");
					}

					$r = $rs->fetch_assoc();
					$gettitle = $r["title"];
					$getyear = $r["year"];

					echo "<option value = $getid>$gettitle ($getyear)</option>";          		
            	}
            	
            	else{
            		echo "<option value = ''></option>";
            	}

				while($row = $rs_title->fetch_assoc()){
					$movieid = $row["id"];
					$title = $row["title"];
					$year = $row["year"];
					echo "<option value = $movieid>$title ($year)</option>\n";
				}
            ?>
            </select>
            <span class="error">* <?php echo "$titleErr";?></span><br/><br/>
            <label for="name">Name:</label><br>
            <input class = "inputtext" type="text" value="Mr. Anonymous" name="name">
			<span class="error">* <?php echo "$nameErr";?></span><br/><br/>
            <label for="rating">Rating:</label><br>
            <select class="inputselect" name="rating">
            	<option value=''></option>
            	<option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4</option>
                <option value=5>5</option>
            </select>
            <span class="error">* <?php echo "$ratingErr";?></span><br/><br/>
            <label for="review">Review:</label><br>
            <!--<input class = "inputtext" type="text" placeholder="Text input" name="review"> -->
            <textarea class = "inputlongtext" cols='107' rows="8" name="review"></textarea>
			<span class="error">* <?php echo "$reviewErr";?></span><br/><br/>
            <button class = "inputsubmit" type="submit">Add</button>
        </div>
        </form>

<?php

if($valid){
	$d = date("Y-m-d h:i:sa");
	//echo $d;
	$sqlInsert = "INSERT INTO Review VALUES('$name', '$d', '$mid', '$rating', '$review');";
	if (!($rs = $db->query($sqlInsert)))
	{ 
		$errmsg = $db->error;
		die("Query sqlInsert failed: $errmsg <br/>");
	}
	
	$sqlSelect = "SELECT AVG(rating) FROM Review WHERE mid = $mid;";	
	if (!($rs = $db->query($sqlSelect)))
	{ 
		$errmsg = $db->error;
		die("Query sqlSelect failed: $errmsg <br />");
	}
	$row = $rs->fetch_assoc();
	foreach($row as $val){
		//echo $val; echo"<br/>";
		$sqlUpdate = "UPDATE Movie SET rating = $val;";	
		if (!($rs = $db->query($sqlUpdate)))
		{ 
			$errmsg = $db->error;
			die("Query sqlUpdate failed: $errmsg <br />");
		}
	}
	
	echo "Successfully added your movie review!";

	$db->close();
	
}

?>

	</body>
</html>