
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
	<img src="http://thewongcouple.com/our-wedding/images/CinemaBackground.jpg" alt="Norway" width="1500" height="500">
	</body>
</html>