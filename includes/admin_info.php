<?php

include 'classes/Dbase.php';
session_start();
$url=$_SERVER['REQUEST_URI'];


if(sizeof(explode('?',$url)) > 1){
	$params=explode('?',$url)[1];
	$params=explode('/',$url);
	
	if(in_array("date", $params)){
			$date = date($params[1]);// "hi";
		}else{
			$date=date('Y-m-d',time());
	}
	}

else{
	$date=date('Y-m-d',time());
	}




$query="SELECT * FROM `login` WHERE `admin`=0";
$objd= new Dbase();
$check= $objd->fetchAll($query);

//$names= array();
while($fetch=mysqli_fetch_assoc($check)){
	$na=$fetch['name'];
	//array_push($names,$na);
	
	?><a href="<?php echo explode('?',$url)[0]."?date/".$date."/uname/".$fetch['u_name']?>"><?php echo '<br>'.$na.'<br>'; ?></a><?php 
}


if(sizeof(explode('?',$url)) > 1){ //
	$params=explode('?',$url)[1];

	$params=explode('/',$params);

	$ind1=array_search('date',$params);
	
	$ind2=array_search('uname',$params);
	
	
	
	$date=$params[$ind1 + 1];
	$name=$params[$ind2 + 1];
	
	
	if(sizeof($params)%2==0){ 
		
		
		?><header id="head1">
			
			<h1>FEEDBACK PAGE</h1>
		</header>
		<table colspan="10" cellpadding="10" cellspacing="15">
			<tr>
				<td>DATE:</td>
				<?php 
					if($date > '2016-06-17'){
						?><a href="<?php echo explode("?", $url)[0]."?date/".date('Y-m-d', strtotime($date . '-1 day'))."/uname/".$name;  ?>">Prev</a><br><br>
					<?php } ?>
				<td><?php echo $date ?></td>
				<?php if($date< date('Y-m-d',time())){
				?><a href="<?php echo explode("?", $url)[0]."?date/".date('Y-m-d', strtotime($date . '+1 day'))."/uname/".$name;  ?>">Next</a>
				<?php }
				?>
			</tr>
			<tr>
				<td>Name:</td>
				<td><?php echo $name?></td>
			</tr>
		</table>
		<?php 	
				$feed="";
				$score="";
				if(isset($_POST['feed']) && isset($_POST['score'])){ 
					$feed=$_POST['feed'];
				$score=$_POST['score'];}
					$query2="SELECT * FROM `report` WHERE `u_name`='{$name}' AND `date`='{$date}'";
				
					$check2= $objd->fetchAll($query2) or die('error');
					$fetch2=mysqli_fetch_assoc($check2);
					if (empty($fetch2['project'] )){
						$query3="SELECT `project` FROM `report` WHERE `u_name`='{$name}' AND `project`<>'' ORDER BY `date` DESC LIMIT 1";
						$check3=$objd->fetchAll($query3);
						$fetch3=mysqli_fetch_assoc($check3);
						
						$project=$fetch3['project'];
					}
				
				
					if(empty($fetch2['feedback'])){ 
					
					//die("if");
				
					
					
					
						if(!empty($fetch2['project']) && !empty($fetch2['report_name'])){
							
							
							
							
							
							?> 
							<table colspan="10" cellpadding="10" cellspacing="15">
								<tr>
									<td>Project</td>
									<td><?php echo $fetch2['project']; ?></td>
								<tr>
								<tr>
									<td>Report</td>
									<td><?php echo $fetch2['report_name']; ?></td>
								</tr>
							
							</table><br><br><?php
							
								$objd->Update_set(array(
								'feedback' => $feed,
								'score' => $score
								
								
								));
								
								$objd->Update_where(array(
									'date'=> $date,
									'u_name'=>$name
								));

							$objd->Update('report') or die("Some error occured while submitting feedback. Please contact the admin!");
						//header('Locaton: admin.php?date/'.$date.'/uname/'.$name);
						}
			
					
						else if(empty($fetch2['project']) && empty($fetch2['score'])){ 
							
								
							
							?><table colspan="10" cellpadding="10" cellspacing="15">
								<tr>
									<td>Project</td>
									<td><?php echo $project ?></td>
								<tr>
								<tr>
									<td>Report</td>
									<td><?php echo "Not yet submitted" ?></td>
								</tr>
							
							</table><br><br><?php
							
							$objd->prepareInsert(array(
			
								'feedback' => $feed,
								'score' => $score,
								'date' => $date,
								'u_name' => $name
								
								));

						$objd->insert('report') or die("Some error occured while submitting feedback. Please contact the admin!");}
							//header('Locaton: admin.php?date/'.$date.'/uname/'.$name);
						
				}}
					
		
			else{
					
				?><table colspan="10" cellpadding="10" cellspacing="15" align="left">
				<tr>
					<td>Project</td>
					
					<?php
						if(empty($fetch2['project'])){
							?><td><?php echo $project; ?></td>
						<?php }else{
							?><td><?php echo $fetch2['project'] ?></td>
					<?php	}
					?>
					
				</tr>
				<tr>
					<td>Report</td>
					<?php
						if(empty($fetch2['report_name'])){
							?><td><?php echo "Not yet submitted" ?></td>
						<?php }else{
							?><td><?php echo $fetch2['report_name'] ?></td>
					<?php	}
					?>
					
				</tr>
				<tr>
					<td>FEEDBACK</td>
					<td><?php echo $fetch2['feedback'] ?></td>
				</tr>
				<tr>
					<td>Score</td>
					<td><?php echo $fetch2['score'] ?></td>
				
				</tr>
							
		</table><br><br><?php}
		
		?>
		<form action="<?php echo explode('?',$url)[0]."?date/".$date."/uname/".$name?>" method="POST">
				<p>FEEDBACK:<textarea rows="8" cols="70" name="feed"></textarea></p><br>
					Score:<input name="score" type="text">
					<p><button type="submit" name="save">Submit</button></p>
				</form><?php
}}
	
	/**else{
		die('insuffient parameters');
	
	}**/





?>