<?php	
	require_once("connection.php");
	$query = "select Vet_ID, V_First_Name, V_Last_Name from Veteran;";
	$response = mysqli_query($dbc, $query);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Veterans</title>
	</head>

	<body>
		<?php require_once("nav.php");?>
		<h1>Veterans</h1>
		<?php if($response): ?>
			<table>
				<thead>
					<th>First Name</th>
					<th>Last Name</th>
				</thead>
				<?php while($row = mysqli_fetch_assoc($response)): ?>
					<tr>
						<td><?= $row['V_First_Name'] ?></td>
						<td><?= $row['V_Last_Name'] ?></td>						
						<td> <a href = "veteranInfo.php?vetID=<?= $row['Vet_ID'] ?>">More Info</a>  </td>
					</tr>
				<?php endwhile; ?>
			</table>
		<?php endif; ?>
	</body>
</html>
