<section id="form-page" style="background:url('assets/images/support-bg.jpg'); background-size: 100%">

<div class="container">

<div class="col-md-6 col-md-offset-3">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<?php

if(isset($_POST['submit'])) {
	
$email = filterData($_POST['email']);
$name = filterData($_POST['name']);
$message = htmlspecialchars($_POST['message']);

if($email == "" OR !filter_var($email,FILTER_VALIDATE_EMAIL)) {
	
echo '<div class="alert alert-dismissable alert-danger">
Looks like your email is not valid.
</div>';
	
} elseif($name == "") {
	
echo '<div class="alert alert-dismissable alert-danger">
Looks like you have left the name field blank.
</div>';
	
} elseif(strlen($message) < 25) {
	
echo '<div class="alert alert-dismissable alert-danger">
Your message is left than 25 characters.
</div>';
	
} else {
	
$mail = new PHPMailer();
if(EMAIL_USE_SMTP) {
$mail->IsSMTP();
$mail->SMTPAuth = EMAIL_SMTP_AUTH;
if(defined(EMAIL_SMTP_ENCRYPTION)) {
$mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
}
$mail->Host = EMAIL_SMTP_HOST;
$mail->Username = EMAIL_SMTP_USERNAME;
$mail->Password = EMAIL_SMTP_PASSWORD;
$mail->Port = EMAIL_SMTP_PORT;
} else {
$mail->IsMail();
}

$message = nl2br($message);

$body = "Hello!

<br>
<br>

{$name} ({$email}) has left the following message at the contact form:

<br>
<br>
<br>

{$message}";

$mail->AddReplyTo($email,$name);
$mail->SetFrom(settings("noReplyEmail"), $website_name);
$mail->Subject = $name . " left a message.";
$mail->SMTPDebug = false;
$mail->do_debug = 0;
$mail->MsgHTML($body);
$mail->AddAddress(settings("contactEmail"));
$mail->Send();	
	
echo '<div class="alert alert-dismissable alert-success">
Your message has been sent. We shall be in contact within a few hours.
</div>';
	
}	
	
}

?>

<form action="" name="" method="post">

<div class="input-group" style="width:100%">
<input type="text" class="form-control" placeholder="What's your name?" name="name">
</div>

<br>

<div class="input-group" style="width:100%;">
<input type="text" class="form-control" placeholder="What's your email address?" name="email">
</div>

<br>

<div class="input-group" style="width:100%">
<textarea name="message" class="form-control" placeholder="What do you wish to ask?" rows="6"></textarea>
</div>

<br>

<button type="submit" name="submit" class="btn btn-primary pull-left"><i class="fa fa-sign-in"></i> Submit</button>

</form>

</div>
</div>
</div>
</div>
</section>
