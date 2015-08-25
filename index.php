<?php include("config.php");?>
<!DOCTYPE html>
<html>
<head>
	<title>Lead Form</title>
</head>
<body>
<form name="lead" method="post" action="leadInsert.php">
	<label>First Name : </label>
	<input type="text" name="fname">
	<label>Last Name :</label>
	<input type="text" name="lname"><br>
	<label>Email :</label>
	<input type="email" name="email"><br>
	<label>Mobile :</label>
	<input type="tel" name="phone"><br>
	<label>Message</label>
	<textarea name="message"></textarea><br><br>
	<input type="submit" name="save" value="Save">
	<input type="reset" name="Cancel">
	

</form>


</body>
</html>