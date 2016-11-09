
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
	<h2>Actor Information Page :</h2>
	<?php
	if (isset($_GET["aid"])) 
	{
		$db = new mysqli('localhost', 'cs143', '');
		if($db->connect_errno > 0)
		{
			die('Unable to connect to database [' . $db->connect_error . ']');
		}
		$db->select_db("CS143");
		$id = $_GET["aid"];
		$sqlSelectActor = "SELECT CONCAT(first,' ',last) Name,sex Sex,dob 'Date of Birth',dod 'Date of Death' FROM Actor WHERE id = $id;";
		if (!($rs = $db->query($sqlSelectActor)))
			{ 
				$errmsg = $db->error;
				die("Query search failed: $errmsg <br />");
			}
		echo "<h3>Actor Information is:</h3><div class = 'inputpadding'>";
		echo "<table border=1 cellspacing=1 cellpadding=2>";
		echo "<tr align=center>";
		while($header = $rs->fetch_field())
		{
			echo "<td><b>".$header->name."</b></td>";
		}
		echo "</tr>";
		while($row = $rs->fetch_assoc()) 
		{
			echo "<tr align=center>";
			foreach($row as $val)
			{
				if (is_null($val))
				{
					echo "<td>"."Still alive"."</td>";
				}
				else
				{
					echo "<td>"."$val"."</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table></div>";
		echo "<h3>Actor's Movies and Role:</h3><div class = 'inputpadding'>";
		$rs->free();
		$sqlSelectRole = "SELECT MA.role Role, M.title 'title',MA.mid mid FROM (SELECT role,mid FROM MovieActor WHERE aid = $id) MA, Movie M WHERE MA.mid = M.id;";
		if (!($rs = $db->query($sqlSelectRole)))
			{ 
				$errmsg = $db->error;
				die("Query search failed: $errmsg <br />");
			}
		echo "<table border=1 cellspacing=1 cellpadding=2>";
		echo "<tr align=center>";
		echo "<td><b>Role</td></b>";
		echo "<td><b>Movie Title</td></b>";
		echo "</tr>";
		while($row = $rs->fetch_assoc()) 
		{
			$role = $row["Role"];
			$title = $row["title"];
			$mid = $row["mid"];
			echo "<tr align=center>";
			echo "<td>$role</td>";
			echo "<td><a href=\"Show_M.php?mid=$mid\">$title</td></a>";
			echo "</tr>";
		}
		echo "</table></div>";
		$rs->free();
		$db->close();
	}
	?>
	<br/>
	<div class = "inputpadding">
		<form method="GET" action="search.php">
			<label for="title">Search:</label><br>
			<input class = "inputtext" placeholder="Search.." type="text" name="keywords">
			<button class = "inputsubmit" type="submit">search</button>
		</form>
	</div>
	</body>
</html>