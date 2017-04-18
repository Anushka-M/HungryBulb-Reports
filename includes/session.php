
<div class="entry row" >
	

<?php

$currentfile=$_SERVER['SCRIPT_NAME'];
$name="";
$pass="";

$log_fail = false;

if(isset($_POST['name']) && isset($_POST['pass']) ){
	$name=$_POST['name'];
	$pass=$_POST['pass'];
	
	
	 
	if(!empty($name) && !empty($pass)){
		$pass=md5($_POST['pass']);
		include "classes/Dbase.php";
		$objDb = new Dbase();
		$testR = $objDb->fetchAll("select * from `login` WHERE `u_name`='{$name}' AND `password`='{$pass}'");
		$fetch=mysqli_fetch_assoc($testR);
		
		if(!empty($fetch)){
			$_SESSION['name']= $fetch['name'];
			echo $_SESSION['name'];
			
			$_SESSION['u_name']=$name;
			
			if($fetch['admin']==1){
				$_SESSION['admin']=1;
				header('Location: admin.php');
			}
			else{
				$_SESSION['admin']=0;
				header('Location: employee.php');
			}
		}
		else{
			//die('sunno na sangemarr marr ki ye minaare!');
			$log_fail = true;
		}
	}


}


?>

	<section class="col-lg-12 ">
		<header class="clearfix ">
			<section id="logo" class="logo ">
				<img src="images/logo.jpg" style="max-width: 45%" id="logo"  alt="Logo" class="img-responsive img-rounded center-block"/><br/><br/>
			</section>
		</header>
		
		<div class="login">
			<section id="entry_form">
			
			<form action="<?php echo $currentfile; ?>" method="POST" class="form-horizontal" data-toggle="validator">
				<legend style="margin-bottom: 2%" ><font color="white"><strong>Login</strong></font></legend>
				
				<?php 
			if($log_fail){
				
				?>
				<p style="color: red;">Incorrect username/password</p>
				<?php
			}
			?>
			
				<section class="form-group row" >
				
					<label class="col col-lg-2 control-label " >Username:</label>
					<div class="col-lg-10">
						<input class="form-control col col-lg-9" type="text" name="name" placeholder="Username" required>
					</div>
				</section>
				
				<section class="form-group row">
				<label class="col-lg-2 control-label">Password:</label>
				<div class="col-lg-10">
				<input class="form-control" type="password" name="pass" placeholder="Password" required>
				</div>
				</section>
				
				<div class="form-group">
					<section class="col-lg-offset-2 col-lg-10">
						<button type="submit"  class='btn btn-primary data-toggle="tooltip" data-original-title="Login'>Login</button>
					</section>
				</div>
			</form> 
			
		</div>
	</section>
</div>