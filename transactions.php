<!DOCTYPE html>
<html>
<head>
	<title>Transactions</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<style type="text/css">
		.well
		{
			margin-top: 60px;
			background-color: white;
			border: 2px solid #27ae60;
		}
	</style>
</head>
<body>
	<div class="row">
		<div class="col-sm-3">
			<div class="row" style="margin-top: 60px;">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<center>
						<input type="button" name="" value="Back" onclick="location.href='home.html';" class="btn btn-primary" style="font-size: 18px;">
					</center>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="well" style="height: 100vh; overflow-y: auto;">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<center><h1 style="color: blue;">Transactions Details</h1></center>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<table class="table table-hover" style="font-size: 16px;">
    						<thead>
      							<tr>
									<th>Sender</th>
									<th>Receiver</th>
									<th>Amount</th>
								</tr>
    						</thead>
    						<tbody>
      							<?php
      								$conn = mysqli_connect('localhost', 'root', 'shrutp', 'bank');
      								$select = "SELECT * FROM tbl_transactions";
      								$result = $conn->query($select);

      								if($result->num_rows > 0)
      								{
      									while($row = $result->fetch_assoc())
      									{
      										echo "<tr><td>" . $row["payer"] . "</td><td>" . $row["payee"] . "</td><td>" . $row["amount"] . "</td></tr>";
      									}
      								}
      							?>
    						</tbody>
  						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>