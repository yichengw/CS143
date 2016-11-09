<?php

echo "<h2>Calculator</h2>";
echo "(by Yicheng Wang)<br>";
echo "Type an expression in the following box (e.g., 10.5+20*3/25).<br>";
echo"<br>";
?>

<!DOCTYPE html>
<html>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="string" name="formula">
	<input type="submit" name = "submit" value= "calculate">
</form>

<?php

echo"&nbsp; *Only numbers and +,-,* and / operators are allowed in the expression.<br>";
echo"&nbsp; *The evaluation follows the standard operator precedence.<br>";
echo"&nbsp; *The calculator does not support parentheses.<br>";
echo'&nbsp; *The calculator handles invalid input "gracefully". It does not output PHP error messages.<br>';
echo"<br>";
echo"Here are some(but not limit to) reasonable test cases:<br>";
echo"&nbsp; 1. A basic arithmetic operation: 3+4*5=23<br>";
echo"&nbsp; 2. An expression with floating point or negative sign : -3.2+2*4-1/3 = 4.46666666667, 3*-2.1*2 = -12.6<br>";
echo"&nbsp; 3. Some typos inside operation (e.g. alphabetic letter): Invalid input expression 2d4+1<br>";

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$formula1=$_POST['formula'];
	echo"<h2>Result</h2>";
	if(empty($formula1)){
		echo"Input cannot be empty!";
	}else{
		
		//preg_match("/\D&[^\*]&[^\/]&[^\+]&[^\-]+/",$formula1, $matches);
		//if(preg_match("/[A-Za-z]+/",$formula1))
		//if($matches[0]!=NULL)
		if(preg_match("/[^0-9\*\/\+\-\.\ ]+/",$formula1))
		{
			echo "Invalid expression!";
		}
		else{
			eval("\$ans=$formula1;");
			if($ans == NULL){
				echo"Invalid expression!";
			}else{
				echo $formula1;
				echo " = ".$ans;
		}
		}
	}
}



?>

</body>
</html>