<div class="splash">
<div class="container">
<div class="row">
<div class="col-lg-12">

<div class="row">

<div class="col-md-3"><?php echo settings("sidebarLeft"); ?></div>

<div class="col-md-6">

<h1><b>Claim Bitcoins</b></h1>

<p style="font-size:15px;">Claim <b><?php echo $payAmount = settings("payAmount"); ?></b> BTC every <b><?php echo $payTimePeriod = settings("payTimePeriod"); ?></b> minutes.</p>

<?php

if(isset($_POST['claim'])) {
	
$privkey = settings("SolveMedia_V");
$hashkey = settings("SolveMedia_H");

$solvemedia_response = solvemedia_check_answer($privkey,
$_SERVER["REMOTE_ADDR"],
$_POST["adcopy_challenge"],
$_POST["adcopy_response"],
$hashkey);

$last_claim_faucet = strtotime(loadAccDetails("user_id",$_SESSION['user_id'],"last_claim_faucet"));
$time = strtotime(date("Y-m-d H:i:s"));
$difference = abs($last_claim_faucet - $time);
$difference = round($difference / 60);

if(settings("faucetStatus") == 0) {

echo '<div class="alert alert-danger">
The faucet status has been set to <b>disabled</b>. Please contact the administrator of the faucet.
</div>';	
	
} elseif(!$solvemedia_response->is_valid) {
	
echo '<div class="alert alert-danger">
The captcha you entered is not valid.
</div>';

} elseif($difference < $payTimePeriod) {
	
echo '<div class="alert alert-danger">
It has been less than ' . $payTimePeriod . ' minutes since your last claim. Take a break, while your limits replenish.
</div>';
	
} else {

$time = date("Y-m-d H:i:s");
$referral = loadAccDetails("user_id",$_SESSION['user_id'],"referral");

if($referral != "") {
	
$earnAmt = (settings("refPercentageFaucet") / 100) * $payAmount;
mysqli_query($con,"UPDATE users SET balance = balance + '{$earnAmt}', total_referred = total_referred + '{$earnAmt}' WHERE user_name = '{$referral}' AND account_status = 1");
	
}

mysqli_query($con,"UPDATE users SET last_claim_faucet = '{$time}', balance = balance + '{$payAmount}' WHERE user_id = '{$_SESSION['user_id']}'");
	
echo '<div class="alert alert-success">
Your claim was successfully, the payout amount <b>' . $payAmount . ' BTC</b> has been added to your account balance. Come back after ' . $payTimePeriod . ' minutes.
</div>';
	
}
	
}

$last_claim_faucet = strtotime(loadAccDetails("user_id",$_SESSION['user_id'],"last_claim_faucet"));
$time = strtotime(date("Y-m-d H:i:s"));
$difference = abs($last_claim_faucet - $time);
$difference = round($difference / 60);

if($difference < $payTimePeriod) {

$rem = $payTimePeriod - $difference;

$claimText = $rem . " minutes left for next claim.";

} else {
	
$claimText = "You can claim now.";
	
}

?>

<br>

<?php

$rand_form = uniqid() . uniqid() . mt_rand() . time() . "-AR2016";

?>

<div class="center-block" style="float: none; margin: 0 auto;">

<h3><?php echo $claimText; ?></h3>

<br>

<form action="" method="post" id="<?php echo $rand_form; ?>">

<input type="hidden" name="claim" value="Caught in the middle.">
<center><?php echo solvemedia_get_html(settings("SolveMedia_C")); ?></center>

<br>
<br>

<a onclick="document.getElementById('<?php echo $rand_form; ?>').submit();" class="btn btn-lg btn-primary"><i class='glyphicon glyphicon-fast-forward'></i> &nbsp; Claim Bitcoins</a>

</form>

<br>
<br>

</div>

</div>

<div class="col-md-3"><?php echo settings("sidebarRight"); ?></div>

</div>

</div>
</div>
</div>
</div>
</div>

<?php echo settings("claimPageCode"); ?>