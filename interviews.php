<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interviews</title>
</head>
<body>
    <?php require_once("nav.php"); ?>
    <h1>Interviews</h1>
    <?php
        require_once("connection.php");

        $query = "SELECT Interview_ID, 
        CONCAT(Veteran.V_First_Name,\" \" ,Veteran.V_Last_Name) AS vetName,
        CONCAT(Interviewer.I_First_Name,\" \" ,Interviewer.I_Last_name) AS intName
        FROM Interview
        INNER JOIN Veteran
        ON Veteran.Vet_ID = Interview.Vet_ID
        INNER JOIN Interviewer
        ON Interviewer.Int_ID = Interview.Int_ID
        ;";

        $response = mysqli_query($dbc, $query);
    ?>
    <table>
        <thead>
            <th>Veteran Name</th>
            <th>Interviewer Name</th>
        </thead>
        <?php while( $row = mysqli_fetch_assoc($response)):  ?>
            <tr>
                <td><?=$row['vetName']?></td>
                <td><?=$row['intName']?></td>
                <td><a href = "interviewInfo.php?interviewID=<?=$row['Interview_ID']?>">More Info</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>