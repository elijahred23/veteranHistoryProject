<?php
    $pageSubmitted = $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']);

    if($pageSubmitted){
        $veteran = $interviewer = $length = $wordCount = $fileSize = $format = $date = $location = $time = "NULL";
        if(isset($_POST['veteran']))
            $veteran = trim($_POST['veteran']);
        if(isset($_POST['interviewer']))
            $interviewer = trim($_POST['interviewer']);
        if(isset($_POST['length']) && $_POST['length'] != "" )
            $length = trim($_POST['length']);
        if(isset($_POST['wordCount']) && $_POST['wordCount'] != "")
            $wordCount = trim($_POST['wordCount']);
        if(isset($_POST['fileSize']) && $_POST['fileSize'] != "")
            $fileSize = trim($_POST['fileSize']);
        if(isset($_POST['date']) && $_POST['date'] != "")
            $date = trim($_POST['date']);
        if(isset($_POST['location']) && $_POST['location'] != ""  )
            $location = trim($_POST['location']);
        if(isset($_POST['time']) && $_POST['time'] != "")
            $time = $_POST['time'];
        
            
        $time = date('0000-00-00 h:i:s');
        require_once("connection.php");
        require_once("functions.php");
        $interviewID = getCharID();
        

        $query = "INSERT INTO Interview 
        (Interview_ID, Length, Word_Count, File_Size, Recording_Format, Recording_Date, Recording_Location,  Recording_Time,
        Int_ID, Vet_ID)
        VALUES  
        (?,?,?,?,?,?,?,?,?,?); ";
        $statement = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($statement, "siiissssss", $interviewID, $length, $wordCount, $fileSize, $format, $date, $location, $time, $interviewer, $veteran);
        mysqli_stmt_execute($statement);
        $affectedRows = mysqli_stmt_affected_rows($statement);
        $pageSubmitted = false;
    }
    
?>

<?php
    $veteranQuery = "Select Vet_ID, V_First_Name, V_Middle_Name, V_Last_Name FROM Veteran";
    require_once("connection.php");
    $veteranQueryResponse = mysqli_query($dbc, $veteranQuery);

    $interviewerQuery = "SELECT Int_ID, I_First_Name, I_Last_name FROM Interviewer;";
    $interviewerQueryResponse = mysqli_query($dbc, $interviewerQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Interview</title>
</head>
<body>

    <?php if(isset($affectedRows) && $affectedRows == 1 ): ?>
        <script>alert("Insert was successful.");</script>
    <?php endif; ?>

    <?php require_once("nav.php") ?>
    <h1>Add Interview</h1>
    <form action="addInterview.php" method = "POST">
        <p>Veteran 
        <select name="veteran" >
            <?php while($row = mysqli_fetch_assoc($veteranQueryResponse)): ?>
                <?php
                    $fName = $row['V_First_Name'];
                    $mName = $row['V_Middle_Name'];
                    $lName = $row['V_Last_Name'];
                    $vetID = $row['Vet_ID'];
                    $name = $fName;
                    if($mName != "NULL")
                        $name .= " ". $mName;
                    $name .= " ". $lName;
                ?>
                
                <option value="<?=$vetID?>"  > <?= $name ?> </option>            
            <?php endwhile; ?>
        </select>

        </p>
        <p>Interviewer
        <select name="interviewer" >
            <?php while($row = mysqli_fetch_assoc($interviewerQueryResponse)): ?>
                <?php
                    $fName = $row['I_First_Name'];
                    $lName = $row['I_Last_name'];
                    $intID = $row['Int_ID'];
                    $name = $fName. " ". $lName;
                ?>    
                <option value="<?=$intID?>"  > <?= $name ?> </option>  
            <?php endwhile; ?>
        </select>
        </p>
        <p>Interview Length (minutes)
            <input type = "number" name = "length" step = "1">
        </p>
        <p>Word Count
            <input type = "number" name = "wordCount" step = "1">
        </p>
        <p>File Size (MegaBytes)
            <input type = "number" name = "fileSize" step = "0.01" min = "0" max = "9999.99">
        </p>
        <p>Recording Format
            <input type = "text" name = "format" maxLength = "25">
        </p>
        <p>Recording Date
            <input type = "date" name = "date">
        </p>
        <p>Recording Location
            <input type="text" name = "location" maxlength = "50">
        </p>
        <p>Recording Time
            <input type = "time" name = "time" step = "any">
        </p>
        <input type = "submit" name = "submit">
    </form>
</body>
</html>