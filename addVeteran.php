<?php	
	$pageSubmitted = $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']);
	if( $pageSubmitted ){
		$dataMissing = array();
		$fName = $middle = $lName = $address = $city = "NULL";
		$state = $zip = $phoneNumber = $email = $birthPlace = "NULL";
		$gender = $race = $highestRank = $seriousInjury = "NULL";
		$pow = $birthDate = "NULL";
		
        if(isset($_POST['fName']))
			$fName = trim($_POST['fName']);
		if(isset($_POST['middle']))
			$middle = trim($_POST['middle']);
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

		$vetID = getCharID();

		$query = "INSERT INTO Veteran 
        (Vet_ID, V_First_Name, V_Middle_Name, V_Last_Name, V_Address, 
        V_City, V_State, V_Zip, V_Phone_Num, V_Email, Birth_Place, 
        Gender, Race_Ethnicity, Highest_Rank, Serious_Injury, POW, DOB) 
        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		
        $statement = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($statement, "ssssssssssssssiis", $vetID, $fName, $middle, $lName,$address, $city, $state, $zip, $phoneNumber, $email, $birthPlace, $gender, $race, $highestRank, $seriousInjury, $pow, $birthDate);    				
		mysqli_stmt_execute($statement);
		$affected_rows = mysqli_stmt_affected_rows($statement);
		$pageSubmitted = false;
	}
?>


<?php if(!$pageSubmitted): ?>
<!DOCTYPE html>
<html>	
	<head>
		<title>Add Veteran</title>
	</head>

	<body>
		<?php require_once("nav.php"); ?>
		<?php if(isset($affected_rows) && $affected_rows == 1): ?>
			<script>alert("You have successfully added a new veteran.")</script>
		<?php endif; ?>
		<h1>Add Veteran</h1>
		<form action = "addVeteran.php" method = "POST" autocomplete = "off">
			<p>First Name*
				<input type = "text" required name = "fName" maxlength = "25">
			</p>
			<p>Middle Name
				<input type = "text"  name = "middle" maxlength = "25">
			</p>
			<p>Last Name*
				<input type = "text" required name = "lName" maxlength = "25">
			</p>
			<p>Address*
				<input type = "text" required name = "address" maxlength = "50">
			</p>
			<p>City*
				<input type = "text" required name = "city" maxlength = "20">
			</p>
			<p>State*
				<input type = "text" required name = "state" maxlength = "2">
			</p>
			<p>Zip*
				<input  pattern="[0-9]{5}" type = "text" required name = "zip" maxlength = "9">
			</p>
			<p>Phone Number*		
				<input type = "tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder = "Format: 123-456-7890"   required name = "phoneNumber" maxlength = "14" >
			</p>
			<p>Email
				<input type = "email" placeholder = "john.doe@example.com" name = "email" maxlength = "150" >
			</p>
			<p>Birth Place*
				<input type = "text" required name = "birthPlace" maxlength = "50">
			</p>
			<p>Gender
				<input type = "radio" name = "gender" value = "m">Male
				<input type = "radio" name = "gender" value = "f">Female
				<input type = "radio" name = "gender" value = "o">Other
			</p>
			<p>Race/Ethnicity
				<select name = "race">
					<option disabled selected value>
					<option value = "White">White</option>
					<option value = "Black or African American" >Black or African American</option>
					<option value = "American Indian or Alaska Native">American Indian or Alaska Native</option>
					<option value = "Asian" >Asian</option>
					<option value = "Native Hawaiian or Other Pacific Islander">Native Hawaiian or Other Pacific Islander</option>
					<option value = "Other">Other</option>
				</select>
			</p>
			<p>Highest Rank
				<input type = "text" name = "highestRank" maxlength = "50">
			</p>
			<p>Serious Injury
				<input type = "checkbox" name = "seriousInjury">
			</p>
			<p>Prisoner of War
				<input type = "checkbox" name = "pow">
			</p>
			<p>Date of Birth 
				<input type = "date" name = "birthDate">
			</p>
			<input type = "submit" name = "submit">
		</form>
	</body>
</html>
<?php endif; ?>
