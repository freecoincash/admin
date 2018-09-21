<section id="form-page">

<div class="container">

<div class="row">

<div class="col-md-12" >
<div class="panel panel-default" id="duh">
<div class="panel-body">

<h2>Edit Profile. <span class="text-muted">Customize.</span></h2>

Customize your profile and personalize your experience at our website.

<br>
<br>

<form action="edit-profile" method="post">

<div class="form-group">
<label class="control-label" for="email">Account Email:</label>
<input type="text" name="email" class="form-control" id="email" value="<?php echo $_SESSION['user_email']; ?>">
</div>

<input type="submit" name="change_email_details" value="Change Email" class="btn btn-primary">

</form>

<br>
<br>

<form action="edit-profile" method="post">

<div class="form-group">
<label class="control-label" for="password">New Password:</label>
<input type="password" name="password" class="form-control" id="password" placeholder="Enter a new password to change your password.">
</div>

<div class="form-group">
<label class="control-label" for="password_repeat">New Password (Repeat):</label>
<input type="password" name="password_repeat" class="form-control" id="password_repeat" placeholder="Repeat it please.">
</div>

<input type="submit" name="change_password_details" value="Change Password" class="btn btn-primary">

</form>

<br>
<br>

<?php

if(isset($_POST['change_address'])) {
	
$address = filterData($_POST['last_used_wallet']);

if(validateBTCAddress($address) == true) {

mysqli_query($con,"UPDATE users SET last_used_wallet = '{$address}' WHERE user_id = '{$_SESSION['user_id']}'");
mysqli_query($con,"UPDATE withdrawals SET address = '{$address}' WHERE user_id = '{$_SESSION['user_id']}'");

echo '<div class="alert alert-success">
Address has been changed successfully.
</div>';
	
} else {
	
echo '<div class="alert alert-danger">
You have used an invalid Bitcoin address.
</div>';
	
}
	
}

?>

<form action="edit-profile" method="post">

<div class="form-group">
<label class="control-label" for="last_used_wallet">Bitcoin Address:</label>
<input type="text" name="last_used_wallet" class="form-control" id="last_used_wallet" value="<?php echo loadAccDetails("user_id",$_SESSION['user_id'],"last_used_wallet"); ?>">
</div>

<input type="submit" name="change_address" value="Change Address" class="btn btn-primary">

</form>

</div>
</div>
</div>


</div>
</div>
</div>
</section>