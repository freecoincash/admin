<section id="form-page">

<div class="container">

<div class="row">
<div class="col-md-6 col-md-offset-3 well" id="duh">

<div align="center">
<h2><b>Register an account</b></h2>
</div>

<br>
<br>
<br>

<form action="register" method="post">

<?php

if(isset($_GET['msg'])) {
	
echo '<div class="alert alert-warning">
You require an account at our website to claim satoshis.
</div>';
	
}

?>

<input type="text" name="username" class="form-control" id="username" placeholder="What should be your username?" required>
<label for="username"><span><span></label>

<br>
<br>

<input type="text" name="email" class="form-control" id="email" required placeholder="What's your email address?">


<br>
<br>

<input type="password" name="password" class="form-control" id="password" required placeholder="What should be your password?">


<br>
<br>

<input type="password" name="password_repeat" class="form-control" id="password_repeat" required placeholder="Repeat your desired password">


<br>
<br>

<input type="text" name="address" class="form-control" id="address" required placeholder="What's your Bitcoin address?">


<br>

<?php

if(settings("googleReCaptcha") == 1) {

echo "<script>
var onloadCallback = function() {
grecaptcha.render('captcha', {
'sitekey' : '" . settings("googleRecaptcha_PUBLICkey") . "',
'hl' : 'en-GB'
});
};
</script>
	
<script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit' async defer></script>";

echo '<div id="captcha"></div>';
	
}

?>

<input type="submit" name="register" value="Register" placeholder="Submit" class="btn btn-primary">

<br>
<br>

Already a user? Login to your <b><a href="login">account</a></b>.

</form>

</div>
</div>
</div>
</section>