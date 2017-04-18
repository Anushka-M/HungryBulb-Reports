<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
	<title>User Login</title>
	
	<!--<link href='https://fonts.googleapis.com/css?family=Lora:400,700,700italic' rel='stylesheet' type='text/css'>-->
	<!--Bootstrap-->
	
	<link href="_/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="_/css/mystyles.css" rel="stylesheet" media="screen">

</head>
<body style="background:#fafafa;">
	<header id="heade1" style="background-color:#66CCFF;border-bottom:solid white;">
		<section class="row">
			<!-- testing -->
			<img src="images/logo.jpg" style="margin:10px auto;" class="col col-lg-2">
			<section class="col col-lg-10">
				<h1 class="col-lg-10" style="text-align:center;margin-top:50px;"><font size="50"><strong >EMPLOYEE INFO</strong></font></h1>
				<h4 class="col-lg-2" style="margin-top:150px;"><?php echo date('Y-M-D',time()); ?></h4>
			</section>
		</section>
	</header>	
		
			
			<?php
				include 'classes/Dbase.php';
				session_start();
				date_default_timezone_set('Asia/Kolkata');
				if(empty($_SESSION['u_name'])){
					
					header('Location: index.php');
				}
				if($_SESSION['admin']==0){
							die('Access Forbidden');
		}
				?>
		<div class="navbar">
			<section class="data col col-lg-12">
				<h4 >Welcome <i><?php echo $_SESSION['name'].'  ' ; ?></i>
				
					<?php
        //session_start();

        if (!isset($_SESSION['u_name']) || empty($_SESSION['u_name'])) {
            header('Location: index.php');
        } else {
            ?><a href="logout.php">( LOG OUT )</a>

        <?php

        }

        ?>
				</h4>
				<div class="col-lg-10 col-lg-offeset-1">
					<h4><strong>Employees:</strong></h4>
			<?php
				$query = "SELECT * FROM `login` WHERE `admin`=0";
				$objd = new Dbase();
				$check = $objd->fetchAll($query);

				
				while ($fetch = mysqli_fetch_assoc($check)) {
					$na = $fetch['name'];
					
					
					?> <table><a href="<?php echo 'admin_info2.php?u_name/'.$fetch['u_name'].'/date/'.date('Y-m-d',time()); ?>"><?php  echo $na.'<br>'; ?></a></li> <?php
					

					
				}
					?>

		</div>
        
   
	</section>
</div>

	<script src="_/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="_/js/bootstrap.js"></script>
	 <script src="_/js/myscript.js"></script>
</body>


</html>