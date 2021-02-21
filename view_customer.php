<?php
	if(isset($_POST['name'])){
		$name = $_POST['name'];
		$conn = mysqli_connect('localhost', 'root', 'shrutp', 'bank');
		$selectCust = "SELECT * FROM tbl_customers where name = '$name'";
		$resultCust = $conn->query($selectCust);
		$dataCust = $resultCust->fetch_assoc();
		$selectCusts = "SELECT name FROM tbl_customers where name != '$name'";
		$resultCusts = $conn->query($selectCusts);
		$selectSentTransactions = "SELECT payee, amount FROM tbl_transactions where payer = '$name'";
		$sentTransactions = $conn->query($selectSentTransactions);
		$selectReceivedTransactions = "SELECT payer, amount FROM tbl_transactions where payee = '$name'";
		$receivedTransactions = $conn->query($selectReceivedTransactions);
	}

	if(isset($_GET['paymentInfo']))
	{
		$ajaxVars = $_GET['paymentInfo'];
		$conn = mysqli_connect('localhost', 'root', 'shrutp', 'bank');
		$name = $ajaxVars["payer"];
		$payee = $ajaxVars["payee"];
		$amount = $ajaxVars["amount"];
		$selectPayerBalance = "SELECT balance FROM tbl_customers where name = '$name'";
		$resultPayerBalance = $conn->query($selectPayerBalance);
		$dataPayerBalance = $resultPayerBalance->fetch_assoc();
		
		if($dataPayerBalance >= $amount)
		{
			$conn->query("UPDATE tbl_customers SET balance=balance-'$amount' where name = '$name'");
			$conn->query("UPDATE tbl_customers SET balance=balance+'$amount' where name = '$payee'");
			$conn->query("INSERT into tbl_transactions values ('$name', '$payee', '$amount')");
			$response = 'success';
		}
		else
		{
			$response = 'error'; 
		}
		$selectCust = "SELECT * FROM tbl_customers where name = '$name'";
		$resultCust = $conn->query($selectCust);
		$dataCust = $resultCust->fetch_assoc();
		$selectCusts = "SELECT name FROM tbl_customers where name != '$name'";
		$resultCusts = $conn->query($selectCusts);
		$selectSentTransactions = "SELECT payee, amount FROM tbl_transactions where payer = '$name'";
		$sentTransactions = $conn->query($selectSentTransactions);
		$selectReceivedTransactions = "SELECT payer, amount FROM tbl_transactions where payee = '$name'";
		$receivedTransactions = $conn->query($selectReceivedTransactions);
		echo json_encode(['result'=>$response]);
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Customer</title>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		.jumbotron
		{
			margin-top: 55px;
			padding: 10px;
			border: 2px solid #e63082;
			
		}
		.jumbotron h2, .well h2
		{
			color: #7B51E0;
		}
		.well
		{
			margin-top: 55px;
			border: 2px solid #e63082;
		}
		#div1
		{
			height: 250px;
		}
		#div2
		{
			height: 300px;
		}
	</style>
</head>
<body>
	<div class="modal fade" id="empModal" role="dialog">
    	<div class="modal-dialog">
     		<div class="modal-content">
      			<div class="modal-header">
        			<h4 class="modal-title">Payment Status</h4>
        			<button type="button" class="close" data-dismiss="modal">&times;</button>
      			</div>
      			<div class="modal-body">
 
      			</div>
      			<div class="modal-footer">
       				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      			</div>
     		</div>
    	</div>
   </div>

	<div class="row">
		<div class="col-sm-2">
			<div class="row" style="margin-top: 50px;">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<center>
						<input type="button" name="" value="Back" onclick="location.href='customers.php';" class="btn btn-primary" style="font-size: 18px;">
					</center>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="jumbotron" id="div1">
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<center><h2>Customer Detail</h2></center>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-4">
						<table class="table table-hover" style="font-size: 16px;">
							<tbody>
								<tr id="payer">
									<td>Name</td>
									<td><?php echo $name ?></td>
								</tr>
								<tr>
									<td>Email</td>
									<td><?php echo $dataCust["email"] ?></td>
								</tr>
								<tr>
									<td>Balance</td>
									<td><?php echo $dataCust["balance"] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="jumbotron" id="div2">
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						<center><h2>Transfer Money</h2></center>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-3">
						<label>Select Customer</label>
					</div>
					<div class="col-sm-4">
						<div class="dropdown">
    						<select id="payee" name="payee">
    							<option disabled selected>--Select Payee--</option>
    							<?php
    								if($resultCusts->num_rows > 0)
      								{
      									while($dataCusts = $resultCusts->fetch_assoc())
      									{
      										echo "<option value='". $dataCusts['name'] ."'>" .$dataCusts['name'] ."</option>";
      									}
      								}
    							?>
    						</select>
  						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-3">
						<label>Amount</label>
					</div>
					<div class="col-sm-4">
						<input type="text" name="amount" id="amount" class="form-control" style="width: 130px;">
					</div>
				</div>
				<br>
				<br>
				<div class="row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<center><input type="submit" id="transfer" name="submit" value="Transfer" class="btn btn-success"></center>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-1"></div>
		<div class="col-sm-4">
			<div class="well" style="height: 400px; overflow-y: auto;">
				<table class="table table-hover" style="font-size: 16px;">
					<center><h2>Money Sent</h2></center>
					<br>
    				<thead>
      					<tr>
							<th>To</th>
							<th>Amount</th>
						</tr>
    				</thead>
    				<tbody>
      					<?php
      						if($sentTransactions->num_rows > 0)
      						{
      							while($row = $sentTransactions->fetch_assoc())
      							{
      								echo "<tr><td>" . $row["payee"] . "</td><td>" . $row["amount"] . "</td></tr>";
      							}
      						}
      					?>
    				</tbody>
 				</table>
			</div>
			<div class="well" style="height: 400px; overflow-y: auto;">
				<table class="table table-hover" style="font-size: 16px;">
					<center><h2>Money Received</h2></center>
					<br>
    				<thead>
      	 				<tr>
							<th>From</th>
							<th>Amount</th>
						</tr>
    				</thead>
    				<tbody>
      					<?php
      						if($receivedTransactions->num_rows > 0)
      						{
    							while($row = $receivedTransactions->fetch_assoc())
      							{
      								echo "<tr><td>" . $row["payer"] . "</td><td>" . $row["amount"] . "</td></tr>";
      							}
      						}
    					?>
    				</tbody>
  				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#transfer').click(function()
			{
				var row = document.getElementById('payer');
				var cells = row.getElementsByTagName("td");
				var payer = cells[1].innerText;
				var payee = document.getElementById('payee').value;
				var amount = document.getElementById('amount').value;
				var dataToSend = {
					'payer' : payer,
					'payee' : payee,
					'amount' : amount
				};

				$.ajax({
					type: 'get',
					dataType: 'json',
					data: {'paymentInfo' : dataToSend},
					success: function(response)
					{
						if(response.result == 'success')
						{
							$('.modal-body').html("Transaction Successful");
      						$('#empModal').modal('show');
						}
						else
						{
							$('.modal-body').html("Don't have enough balance");
      						$('#empModal').modal('show');
						}
					},
					error: function()
					{
						$('.modal-body').html("Error Occured");
      					$('#empModal').modal('show');
					}
				});

			});

			$('#empModal').on('hidden.bs.modal', function () {
				location.reload();
			});

		});
	</script>
</body>
</html>