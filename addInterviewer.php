<?php
    $pageSubmitted = $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']);
    if($pageSubmitted){
        $fName = $lName = $maidenName = $address = $state = $zip = "NULL";
        $phoneNumber = $email = $organization = "NULL";
        if(isset($_POST['fName']))
            $fName = trim($_POST['fName']);
        if(isset($_POST['lName']))
            $lName = trim($_POST['lName']);
        if(isset($_POST['maidenName'])){
            $maidenName = trim($_POST['maidenName']);
            if($maidenName == "")
                $maidenName = "NULL";
        }
        if(isset($_POST['address']))
            $address = trim($_POST['address']);
        if(isset($_POST['state']))
            $state = trim($_POST['state']);
        if(isset($_POST['zip']))
            $zip = trim($_POST['zip']);
        if(isset($_POST['phoneNum'])){
            $phoneNum = trim($_POST['phoneNum']);
            if($phoneNum == "")
                $phoneNum = "NULL";
        }
        if(isset($_POST['email'])){
            $email = trim($_POST['email']);
            if($email == "")
                $email = "NULL";
        }
        if(isset($_POST['organization'])){
            $organization = trim($_POST['organization']);
            if($organization == "")
                $organization = "NULL";
        }
        require_once("functions.php");
        require_once("connection.php");
        $intID = getCharID();

        $query = "INSERT INTO Interviewer
        (Int_ID, I_First_Name,I_Last_name, I_Maiden_name, I_Address, I_State, 
        I_Zip, I_Phone_Num, I_Email, Organization)
        VALUES
        (?,?,?,?,?,?,?,?,?,?);
        ";
        $statement = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($statement, "ssssssssss", $intID, $fName, $lName, $maidenName, $address, $state, $zip, $phoneNumber, $email, $organization);
        mysqli_stmt_execute($statement);
        $affectedRows = mysqli_stmt_affected_rows($statement);
        $pageSubmitted = false;
    }
?>


<?php if(!$pageSubmitted): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Interviewer</title>
</head>
<body>
    <?php require_once("nav.php"); ?>
    <?php if(isset($affectedRows) && $affectedRows == 1): ?>
        <script>
            window.alert("You have successfully added an interviewer.")
        </script>
    <?php endif; ?>
    <h1>Add Interviewer</h1>
    <form action = "addInterviewer.php" method = "POST" autocomplete = "off">
        <p>First Name*
            <input type="text" maxlength = "25" name = "fName">
        </p>
        <p>Last Name*
            <input type="text" maxlength = "25" name = "lName">
        </p>
        <p>Maiden Name
            <input type="text" maxlength = "25" name = "maidenName">
        </p>
        <p>Address*
            <input type="text" maxlength = "25" name = "address">
        </p>
        <p>State*
            <input type="text" maxlength = "2" name = "state">
       </p>
       <p>Zip* 
            <input type="text" maxlength = "9" pattern = "[0-9]{5}" name = "zip">
       </p>
       <p>Phone Number
           <input type="tel" maxlength = "14" pattern = "[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder = "Format: 123-456-7890" name = "phoneNum">
       </p>
       <p>Email
            <input type="email" placeholder = "john.doe@example.com" maxlength = "50" name = "email">
       </p>
       <p>Organization
            <input type="text" maxlength = "100" name = "organization">
       </p>
        <input type="submit" value = "submit" name = "submit"> 
    </form>
</body>
</html>
<?php endif; ?>