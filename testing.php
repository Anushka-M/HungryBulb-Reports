<!DOCTYPE html>

<html>
<head>


	<meta name="description" content="your description">
	<meta name="keywords" content="your keywords">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
</head>

<?php
	include 'classes/Dbase.php';
	$objd = new Dbase();
	$arr_fetch= array();
	
	$query = "SELECT * FROM `random`";
	$check = $objd->fetchAll($query);
	while($fetch=mysqli_fetch_assoc($check)){
		array_push($arr_fetch,$fetch['NAME'].' '.$fetch['COLLEGE']);
	}
	
	print_r($arr_fetch);
	
	
	
?>
<body>
	<p>Random testing Module</p>

</body>

</html>