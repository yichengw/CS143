<!DOCTYPE html>
<html>
<body>

<?php

echo "<h2>Web Query Interface</h2>";
echo "(by Yicheng Wang)<br>";
echo "Type a SQL query in the following box: <br>";
echo "Example: SELECT * FROM Actor WHERE id=10; <br>";
echo "<br>";
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<textarea name='query' cols='60' rows="8"></textarea><br>
	<input type="submit" name = "submit" value= "submit">
</form>

<?php
echo "Note: tables and fields are case sensitive. All tables in Project 1B are availale.<br>";
if($_SERVER["REQUEST_METHOD"]=="POST"){

	//establish a connection from PHP to bd system
	//$db = new mysqli('localhost','cs143','','TEST');
	$db = new mysqli('localhost','cs143','','CS143');
	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}
	$query1=$_POST['query'];
	$rs = $db->query($query1);

	if (!$rs){ 
    	$errmsg = $db->error;
    	echo "<h4>Query failed: $errmsg. </h4>";
    	echo "<h4>Please check your query format:(</h4>";
    	exit(1);
	}
	//print the results
	echo '<h4>Results from MySQL:</h4>';
	//print the header
	echo '<table border=1 cellspacing=1 cellpadding=2>';
	echo '<tr align="center">';
	//$row = $rs->fetch_assoc();
	//foreach(array_keys($row) as $col) {
	//	echo '<td>' . $col . '</td>';
	//}
	while($header = $rs->fetch_field()){
		echo '<td><b>' . $header->name . '</b></td>';
	}
	echo '</tr>';

	//print out the actual query results
	do
	{
		//traversal every atrribute in the row
		echo '<tr align="center">';
		foreach($row as $c_row)
		{
			if($c_row==NULL)
				echo '<td>N/A</td>';
			else
				echo '<td>' . $c_row . '</td>';				
		}
		echo '</tr>';
	}while($row = $rs->fetch_assoc());
	echo '</table>';
	//free up query results and close the database connection
	mysql_free_result($rs);	
	mysql_close($db);

}
?>


</body>
</html>