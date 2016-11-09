
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
	<h2>Movie Information Page :</h2>
	<hr>
	<?php
	if (isset($_GET["mid"])) 
	{
		$db = new mysqli('localhost', 'cs143', '');
		if($db->connect_errno > 0)
		{
			die('Unable to connect to database [' . $db->connect_error . ']');
		}
		$db->select_db("CS143");
		$id = $_GET["mid"];
		$sqlSelectMovie = "SELECT title, year, company , rating FROM Movie WHERE id = $id";
		$sqlSelectGenre = "SELECT genre FROM MovieGenre WHERE mid = $id";
		$sqlSelectMD = "SELECT CONCAT(D.first,' ',D.last) Director,D.dob dob FROM Director D, MovieDirector MD WHERE D.id = MD.did AND MD.mid = $id";
		if (!($rsMovie = $db->query($sqlSelectMovie)))
			{ 
				$errmsg = $db->error;
				die("Query sqlSelectMovie search failed: $errmsg <br />");
			}
		if (!($rsGenre = $db->query($sqlSelectGenre)))
			{ 
				$errmsg = $db->error;
				die("Query sqlSelectGenre search failed: $errmsg <br />");
			}
		if (!($rsMD = $db->query($sqlSelectMD)))
			{ 
				$errmsg = $db->error;
				die("Query sqlSelectMD search failed: $errmsg <br />");
			}
		echo "<h3>Movie Information is:</h3>"."<div class = 'inputpadding'>";
		$row = $rsMovie->fetch_assoc();
		$title = $row["title"];
		$year = $row["year"];
		$company = $row["company"];
		$rating = $row['rating'];
		$res =  "Title: $title($year)<br/>Producer: $company<br/>MPAA Rating: $rating<br/>";
		$rsMovie->free();
		$row = $rsMD->fetch_assoc();
		$Director = $row["Director"];
		$dob = $row["dob"];
		$res = ($Director)?$res."Director: $Director($dob)<br/>":$res."Director: N/A<br/>";
		$rsMD->free();
		$row = $rsGenre->fetch_assoc();
		$genre = $row["genre"];
		$res .= "Genre: $genre<br/>";
		$rsGenre->free();
		echo $res;
		echo "</div><h3>Actors in this Movie:</h3>"."<div class = 'inputpadding'>";
		$sqlSelectRole = "SELECT CONCAT(A.first,' ',A.last) Name,role Role, MA.aid aid FROM (SELECT role,aid FROM MovieActor WHERE mid = $id) MA, Actor A WHERE MA.aid = A.id;";
		if (!($rs = $db->query($sqlSelectRole)))
			{ 
				$errmsg = $db->error;
				die("Query search failed: $errmsg <br />");
			}
		echo "<table border=1 cellspacing=1 cellpadding=2>";
		echo "<tr align=center>";
		echo "<td><b>Name</td></b>";
		echo "<td><b>Role</td></b>";
		echo "</tr>";
		echo "</tr>";
		while($row = $rs->fetch_assoc()) 
		{
			$role = $row["Role"];
			$name = $row["Name"];
			$aid = $row["aid"];
			echo "<tr align=center>";
			echo "<td><a href=\"Show_A.php?aid=$aid\">$name</td></a>";
			echo "<td>$role</td>";
			echo "</tr>";
		}
		echo "</table></hr>";
		$rs->free();
		echo "</div><h3> User Review :</h3>"."<div class = 'inputpadding'>";
		$sqlSelectReview = "SELECT name, time, comment FROM Review WHERE mid = $id;";
		$sqlAVG = "SELECT AVG(rating) AVG FROM Review WHERE mid = $id;";
		if (!($rsReview = $db->query($sqlSelectReview)))
			{ 
				$errmsg = $db->error;
				die("Query search failed: $errmsg <br />");
			}
		if (!($rsAVG = $db->query($sqlAVG)))
			{ 
				$errmsg = $db->error;
				die("Query search failed: $errmsg <br />");
			}
			
		if($rsReview->num_rows==0)
		{


			echo "<a href=\"Add_R.php?mid=$id\">By now, nobody ever rates this movie. Be the first one to give a review</a>";
		}
		else
		{
			$row = $rsAVG->fetch_assoc();
			$AVG = $row["AVG"];
			echo "Average score for this Movie is $AVG/5 based on 1 people's reviews<br/>";
			echo "<a href=\"Add_R.php?mid=$id\">Leave your review as well!</a><br/>";
			echo "</div>"."<h3>Comment detials shown below :</h3>"."<div class = 'inputpadding'>";
			while($row=$rsReview->fetch_assoc())
			{
			echo "<font color='red'>".$row["name"]."</font> rates the this movie with score ".$row["rating"]." and left a review at ".$row["time"]."<br/>";
			echo "comment:<br/>".$row["comment"]."<br/><br/>";
			}
		}
	}
	?>
	</div>
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