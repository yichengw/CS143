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
	
	<h2>Searching Page :</h2>
	<div class = "inputpadding">
		<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<label for="title">Search:</label><br>
			<input class = "inputtext" placeholder="Search.." type="text" name="keywords"></input>
			<button class = "inputsubmit" type="submit">search</button>
		</form>
	</div>
		
		
<?php
	if (isset($_GET["keywords"])) 
	{
		$keywords = explode(' ',$_GET["keywords"]);
		
		if($keywords)
		{
			$db = new mysqli('localhost', 'cs143', '');
			if($db->connect_errno > 0)
			{
				die('Unable to connect to database [' . $db->connect_error . ']');
			}
			$db->select_db("CS143");
			$sqlSelectActor = "SELECT id,Fullname as 'name',dob FROM (SELECT id,CONCAT(first,' ',last) as Fullname,dob FROM Actor) S WHERE Fullname LIKE '%$keywords[0]%'";
			
			for($i=1; $i<sizeof($keywords); $i++)
			{
				$sqlSelectActor .= "AND Fullname LIKE '%$keywords[$i]%'";
			}
			$sqlSelectActor .= ";";
			if (!($rs = $db->query($sqlSelectActor)))
			{ 
				$errmsg = $db->error;
				die("Query search failed: $errmsg <br />");
			}
			echo "<h3>matching Actors are:</h3><div class = 'inputpadding'>";
			echo "<table border=1 cellspacing=1 cellpadding=2>";
			echo "<tr align=center>";
			echo "<td><b>"."Name"."</b></td>";
			echo "<td><b>"."Date of Birth"."</b></td>";
			echo "</tr>";
			while($row = $rs->fetch_assoc()) 
			{
				echo "<tr align=center>";
				$id = $row["id"];
				$name = $row["name"];
				$dob = $row["dob"];
				echo "<td>"."<a href=\"Show_A.php?aid=$id\">$name</a>"."</td>";
				echo "<td>"."<a href=\"Show_A.php?aid=$id\">$dob</a>"."</td>";
				echo "</tr>";
			}
			echo "</table></div>";
			$rs->free();
			//Movie
			
			$sqlSelectMovie = "SELECT id,title,year FROM Movie WHERE title LIKE '%$keywords[0]%'";
			
			for($i=1; $i<sizeof($keywords); $i++)
			{
				$sqlSelectMovie .= "AND title LIKE '%$keywords[$i]%'";
			}
			$sqlSelectMovie .= ";";
			if (!($rs = $db->query($sqlSelectMovie)))
			{ 
				$errmsg = $db->error;
				die("Query search failed: $errmsg <br />");
			}
			echo "<h3>matching Movies are:</h3><div class = 'inputpadding'>";
			echo "<table border=1 cellspacing=1 cellpadding=2>";
			echo "<tr align=center>";
			echo "<td><b>"."Title"."</b></td>";
			echo "<td><b>"."Year"."</b></td>";
			echo "</tr>";
			while($row = $rs->fetch_assoc()) 
			{
				echo "<tr align=center>";
				$id = $row["id"];
				$title = $row["title"];
				$year = $row["year"];
				echo "<td>"."<a href=\"Show_M.php?mid=$id\">$title</a>"."</td>";
				echo "<td>"."<a href=\"Show_M.php?mid=$id\">$year</a>"."</td>";
				echo "</tr>";
			}
			echo "</table></div>";
			$rs->free();
			$db->close();
		}
	
	}
?>
	</body>
<html>