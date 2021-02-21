<?php 
	$message = "";
	if(isset($_POST['submit']))
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		$msg = $_POST['msg'];
		$conn = mysqli_connect('localhost', 'root', 'shrutp', 'bank');
		$conn->query("INSERT into tbl_contact values ('$name', '$email', '$contact', '$msg')");
		echo "<script>alert('Submitted Successfully');</script>";
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Contact Us</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans&family=Playfair+Display&display=swap" rel="stylesheet">
	<style type="text/css">
		body
		{
			background-image: url('contact.jpg');
			background-size: cover;
			background-repeat: no-repeat;
		}
    form
    {
	    margin-top: 70px;
	    border: 2px solid #343a40!important;
	    padding: 20px;
	    font-family: 'Roboto', sans-serif;
	    color: black;
	    font-size: 18px;
    }
    .btn-outline-primary
    {
	    font-weight: bold;
	    font-size: 18px;
    }
	</style>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Online Banking</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="home.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="transactions.php">Transactions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact Us</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="row">
	  <div class="col-sm-2"></div>
	  <div class="col-sm-3">
		  <form method="post" action="">
			  <div class="form-group">
          <label for="name">Name: </label>
          <input type="text" class="form-control" placeholder="Enter name" id="name" name="name">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" placeholder="Enter email" id="email" name="email">
        </div>
        <div class="form-group">
          <label for="contact">Contact:</label>
          <input type="text" class="form-control" placeholder="Enter contact" id="contact" name="contact">
        </div>
        <div class="form-group">
          <label for="msg">Message:</label>
          <textarea placeholder="Enter your message" class="form-control" id="msg" name="msg"></textarea>
        </div>
        <center><input type="submit" class="btn btn-primary" name="submit"></center>
		  </form>
	  </div>
  </div>
</body>
</html>