<?php
    $intID = $_GET['intID'];
    $pageSubmitted = $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']);
    if($pageSubmitted){
        $fName = $lName = $maidenName = $address = $state = $zip = "NULL";
        $phoneNum = $email = $organization = "NULL";

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

        $query = "UPDATE Interviewer
        SET
        I_First_Name = ?, I_Last_name = ?, I_Maiden_name = ?, I_Address = ?,
        I_State = ?, I_Zip = ?, I_Phone_Num = ?, I_Email = ?, Organization = ?
        WHERE Int_ID = ? ";

        $statement = mysqli_prepare($dbc, $query);
        
        mysqli_stmt_bind_param($statement, "ssssssssss", $fName, $lName, $maidenName, $address, $state, $zip, $phoneNum, $email, $organization, $intID);
        
        mysqli_stmt_execute($statement);
        $affectedRows = mysqli_stmt_affected_rows($statement);
        $pageSubmitted = false;
    }
?>


<?php
    require_once("connection.php");

    $query = "SELECT * FROM Interviewer WHERE Int_ID = \"$intID\" ";
    
    $response = mysqli_query($dbc, $query);
    $int = mysqli_fetch_assoc($response); 

    
    $fName = $int['I_First_Name'];
    $lName = $int['I_Last_name'];
    $maidenName = $int['I_Maiden_name'];
    $address = $int['I_Address'];
    $state = $int['I_State'];
    $zip = $int['I_Zip'];
    $phoneNum = $int['I_Phone_Num'];
    $email = $int['I_Email'];
    $organization = $int['Organization'];


?>

<?php if(!$pageSubmitted): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interviewer Info</title>
</head>
<body>
    <?php require_once("nav.php"); ?>
    <?php if(isset($affectedRows) && $affectedRows == 1): ?>
        <script>
            window.alert("Update successful.")
        </script>
    <?php endif; ?>
    <h1>Interviewer Info</h1>
    <form action = "interviewerInfo.php?intID=<?= $intID ?>" method = "POST" autocomplete = "off">
        <p>First Name*
            <input required type="text" maxlength = "25" name = "fName" placeholder = "<?= $fName?>" value = "<?= $fName?>">
        </p>
        <p>Last Name*
            <input required  type="text" maxlength = "25" name = "lName" placeholder = "<?= $lName?>" value = "<?= $lName?>">
        </p>
        <p>Maiden Name
            <input type="text" maxlength = "25" name = "maidenName" placeholder = "<?= $maidenName?>"
            <?php
                if($maidenName != "NULL")
                    echo " value = \"$maidenName\" ";        
            ?>
            
             >
        </p>
        <p>Address*
            <input required  type="text" maxlength = "25" name = "address" placeholder = "<?= $address?>" value = "<?= $address?>">
        </p>
        <p>State*
            <input required  type="text" maxlength = "2" name = "state" placeholder = "<?= $state?>" value = "<?= $state?>">
       </p>
       <p>Zip* 
            <input required  type="text" maxlength = "9" pattern = "[0-9]{5}" name = "zip" placeholder = "<?= $zip ?>" value = "<?= $zip ?>">
       </p>
       <p>Phone Number
           <input type="tel" maxlength = "14" pattern = "[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder = "<?= $phoneNum?>"
           <?php 
                if($phoneNum != "NULL")
                    echo " value = \"$phoneNum\" ";
           ?>
           
           name = "phoneNum">
       </p>
       <p>Email
            <input type="email" placeholder = "<?= $email ?>" 
            <?php
                if($email != "NULL")
                    echo " value = \"$email\" ";
            ?>
            maxlength = "50" name = "email" >
       </p>
       <p>Organization
            <input type="text" maxlength = "100" name = "organization" placeholder = "<?= $organization ?>" 
            <?php
                if($organization != "NULL")
                    echo " value = \"$organization\" ";
            ?>
            >
       </p>
        <input type="submit" value = "submit" name = "submit" onclick = "return confirm('Are you sure you want to update?')" > 
    </form>
</body>
</html>
<?php endif; ?>