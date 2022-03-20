<?php	
	require_once("connection.php");
	$query = "select Int_ID, I_First_Name, I_Last_name from Interviewer;";
	$response = mysqli_query($dbc, $query);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Veterans</title>
	</head>

	<body>
		<?php require_once("nav.php");?>
		<h1>Interviewers</h1>
		<?php if($response): ?>
			<table>
				<thead>
					<th>First Name</th>
					<th>Last Name</th>
				</thead>
				<?php while($row = mysqli_fetch_assoc($response)): ?>
					<tr>
						<td><?= $row['I_First_Name'] ?></td>
						<td><?= $row['I_Last_name'] ?></td>						
						<td> <a href = "interviewerInfo.php?intID=<?= $row['Int_ID'] ?>">More Info</a>  </td>
					</tr>
				<?php endwhile; ?>
			</table>
		<?php endif; ?>
	</body>
</html>
