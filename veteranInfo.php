<?php	
	$vetID = $_GET['vetID'];
	$pageSubmitted = false;
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']) ){

		$pageSubmitted = true;
		$dataMissing = array();
		$fName = $middle = $lName = $address = $city = "NULL";
		$state = $zip = $phoneNumber = $email = $birthPlace = "NULL";
		$gender = $race = $highestRank = $seriousInjury = "NULL";
		$pow = $birthDate = "NULL";
		
        if(isset($_POST['fName']))
			$fName = trim($_POST['fName']);
		if(isset($_POST['middle'])){
			$middle = trim($_POST['middle']);
			if(strlen($middle) == 0 || $middle == "")
				$middle = "NULL";
		}
		else
			$middle = "NULL";
		if(isset($_POST['lName']))
			$lName = trim($_POST['lName']);
		if(isset($_POST['address']))
			$address = trim($_POST['address']);
		if(isset($_POST['city']))
			$city = trim($_POST['city']);
		if(isset($_POST['state']))
			$state = trim($_POST['state']);
		if(isset($_POST['zip']))
			$zip = trim($_POST['zip']);
		if(isset($_POST['phoneNumber']))
			$phoneNumber = trim($_POST['phoneNumber']);
		if(isset($_POST['email'])){
			$email = trim($_POST['email']);

            if(strlen($email) == 0 || $email == "")
                $email = "NULL";
		}
		else	
			$email = "NULL";
		if(isset($_POST['birthPlace'])){
			$birthPlace = trim($_POST['birthPlace']);
			if(strlen($birthPlace) == 0)
				$birthPlace = "NULL";
		}
		if(isset($_POST['gender'])){
			$gender = trim($_POST['gender']);
			if(strlen($gender) == 0)
				$gender = "NULL";
		}

		if(isset($_POST['race'])){
			$race = trim($_POST['race']);
			if(strlen($race) == 0)
				$race = "NULL";
		}
		if(isset($_POST['highestRank'])){
			$highestRank = trim($_POST['highestRank']);
			if(strlen($highestRank) == 0 || $highestRank == "")
				$highestRank = "NULL";
		}
		else
			$highestRank = "NULL";

		if(isset($_POST['seriousInjury'])){
			$sI = trim($_POST['seriousInjury']);
			if($sI == "on")
				$seriousInjury = 1;
			else 
				$seriousInjury = 0;
		}
		else 
			$seriousInjury = 0;
		
		if(isset($_POST['pow'])){
			$prisonerOfWar = trim($_POST['pow']);

			if($prisonerOfWar == "on")
				$pow = 1;
			else
				$pow = 0;
		}
		else
			$pow = 0;

		if(isset($_POST['birthDate'])){
			$birthDate = trim($_POST['birthDate']);
			if($birthDate == "0000-00-00")
				$birthDate = "NULL";
		}
		
		require_once("connection.php");

		require_once("functions.php");
		
		$query = "UPDATE Veteran
		SET V_First_Name = ?, V_Middle_Name = ?, V_Last_Name = ?,
		V_Address = ?, V_City = ?, V_State = ?, V_Zip = ?, V_Phone_Num = ?, V_Email = ?, Birth_Place = ?,
		Gender = ?, Race_Ethnicity=?, Highest_Rank=?, Serious_Injury=?, POW=?, DOB=?
		WHERE Vet_ID = ?";
		
        $statement = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($statement, "sssssssssssssiiss", $fName, $middle, $lName,$address, $city, $state, $zip, $phoneNumber, $email, $birthPlace, $gender, $race, $highestRank, $seriousInjury, $pow, $birthDate, $vetID);    				
		mysqli_stmt_execute($statement);
		$affected_rows = mysqli_stmt_affected_rows($statement);
		$pageSubmitted = false;
	}
?>

<?php if(!$pageSubmitted): ?>
<?php

	require_once("connection.php");
	$query = "SELECT * FROM Veteran WHERE Vet_ID = \"$vetID\" ";

	$response = mysqli_query($dbc, $query);

	$vet = mysqli_fetch_assoc($response);
	
	$fName = $vet['V_First_Name'];
	$lName = $vet['V_Last_Name'];

	$middle = $vet['V_Middle_Name'];
	
	$address = $vet['V_Address'];
	$city = $vet['V_City'];
	$state = $vet['V_State'];
	$zip = $vet['V_Zip'];
	$phoneNumber = $vet['V_Phone_Num'];
	$email = $vet['V_Email'];
	$birthPlace = $vet['Birth_Place'];
	$gender = $vet['Gender'];
	$race = $vet['Race_Ethnicity'];
	$highestRank = $vet['Highest_Rank'];
	$seriousInjury = $vet['Serious_Injury'];
	$pow = $vet['POW'];
	$dob = $vet['DOB'];
	$dob = date('Y-m-d', strtotime($dob));
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Veteran Information</title>
	</head>
	<body>
		<?php require_once("nav.php");?>
		<?php if(isset($affectedRows) && $affectedRows == 1): ?>
			<script>
				window.alert("Update successful.")
			</script>
		<?php endif; ?>
		<h1>Veteran Information</h1>
        <form action = "veteranInfo.php?vetID=<?= $vetID?>" method = "POST" autocomplete="off">
			<p>First Name*
				<input type = "text" required name = "fName" placeholder = "<?= $fName?>" value = "<?= $fName?>"  maxlength="25">
			</p>
			<p>Middle Initial 
				<input type = "text"  name = "middle" placeholder = "<?=$middle?>" 
				<?php
					if($middle != "NULL")
						echo " value = \"$middle\" ";
				?>
				maxlength="25" >
			</p>
			<p>Last Name*
				<input type = "text" required name = "lName" placeholder = "<?=  $lName?>" value = "<?=  $lName?>" maxlength="25">
			</p>
			<p>Address*
				<input type = "text" required name = "address" placeholder = "<?= $address?>" value = "<?= $address?>" maxlength="50">
			</p>
			<p>City*
				<input type = "text" required name = "city" placeholder = "<?= $city?>" value = "<?= $city?>" maxlength="20">
			</p>
			<p>State*
				<input type = "text" required name = "state" placeholder = "<?= $state ?>" value = "<?= $state ?>" maxlength ="2">
			</p>
			<p>Zip*
				<input   pattern="[0-9]{5}" type = "text" required name = "zip" placeholder = "<?= $zip?>" value = "<?= $zip?>" maxlength = "14">
			</p>
			<p>Phone Number*		
				<input type = "tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required name = "phoneNumber" placeholder = "<?= $phoneNumber?>" value = "<?= $phoneNumber?>" maxlength = "150">
			</p>
			<p>Email
				<input type = "email"  name = "email" placeholder = "<?= $email ?>" 
				<?php 
					if($email != "NULL")
						echo " value = \"$email\" ";
				?>
				maxlength ="50">
			</p>

			<p>Birth Place*
				<input type = "text" required name = "birthPlace" placeholder = "<?= $birthPlace ?>" value = "<?= $birthPlace ?>" maxlength="50">
			</p>
			<p>Gender
				<input type = "radio" name = "gender" value = "m" <?php if($gender == "m") echo " checked "; ?> >Male
				<input type = "radio" name = "gender" value = "f" <?php if($gender == "f") echo " checked "; ?> >Female
				<input type = "radio" name = "gender" value = "o" <?php if($gender == "o") echo " checked "; ?> >Other
			</p>
			<p>Race/Ethnicity
				<select name = "race">
					<option disabled  
					<?php 
						if($race == "NULL")
							echo " selected ";
					?> >
					<option value = "White"
					<?php
						if($race == "White")
							echo " selected ";
					?>
					>White</option>
					<option value = "Black or African American"
					<?php
						if($race == "Black or African American")
							echo " selected ";
					?>
					>Black or African American</option>
					<option value = "American Indian or Alaska Native"
					<?php
						if($race == "American Indian or Alaska Native")
							echo " selected ";
					?>
					>American Indian or Alaska Native</option>
					<option
					<?php
						if($race == "Asian")
							echo " selected ";
					?>
					>Asian</option>
					<option value = "Native Hawaiian or Other Pacific Islander"
					<?php
						if($race == "Native Hawaiian or Other Pacific Islander")
							echo " selected ";
					?>
					>Native Hawaiian or Other Pacific Islander</option>
					<option value = "Other" 
					<?php
						if($race == "Other")
							echo " selected ";
					?>
					>Other</option>
				</select>
			</p>
			<p>Highest Rank
				<input type = "text" name = "highestRank" placeholder = "<?= $highestRank ?>"  
				<?php
					if($highestRank != "NULL")
						echo " value = \"$highestRank\" ";
				?>

				maxlength = "50">
			</p>
			<p>Serious Injury
				<input type = "checkbox" name = "seriousInjury" <?php if($seriousInjury == 1) echo " checked ";  ?> >
			</p>
			<p>Prisoner of War
				<input type = "checkbox" name = "pow" <?php if($pow == 1) echo " checked "; ?>  >
			</p>
			<p>Date of Birth 
				<input type = "date" name = "birthDate" placeholder = "<?= $dob?>" value = "<?= $dob?>"  >
			</p>
			<input type = "submit" name = "submit" onclick="return confirm('Are you sure you want to update?');">
		</form>
	</body>
</html>
<?php endif; ?>