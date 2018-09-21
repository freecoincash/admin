<div id="modalForMsg" class="modal fade" role="dialog">
<div class="modal-dialog">

<?php

$server_seed = loadAccDetails("user_id",$_SESSION['user_id'],"server_seed");
$server_seed_hash = loadAccDetails("user_id",$_SESSION['user_id'],"server_seed_hash");

if($server_seed == "" OR $server_seed_hash == "") {
	
$server_seed = md5(bin2hex(openssl_random_pseudo_bytes(8)));
$server_seed_hash = hash("sha512",$server_seed);

mysqli_query($con,"UPDATE users SET server_seed = '{$server_seed}', server_seed_hash = '{$server_seed_hash}' WHERE user_id = {$_SESSION['user_id']}");

}

?>

<div class="modal-content" style="overflow:none;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Provably Fair</h4>
</div>
<div class="modal-body" id="modal_msg" style="overflow:none;">

Have you been wondering if this game is a scam or a legit one? Let's get it straight: <b>we're legit and we can prove it</b>.

<br>
<br>

This game can be proved fair, this means that we cannot choose a number in our favour. Your seeds for this session/round are below:

<br>
<br>

<b>Server Seed Hash: </b> <pre><?php echo $server_seed_hash; ?></pre>
<br>
<b>Client Seed: </b> <pre id="client_seed_read"></pre>
<br>
<b>Nonce: </b> <pre id="nonce_read"></pre>

<br>

<b><a href="verify">You can always verify your rolls here.</a></b>

<br>
<br>

<b>Process to Validate:</b>

<br>
<br>

<ul>

<li>First of all, obtain your seeds for the old round by clicking on <b>History</b>.</li>

<li>Create two strings:

<br>
<br>

$string1 = NONCE . ":" . SERVER_SEED . ":" . NONCE;
<br>
$string2 = NONCE . ":" . CLIENT_SEED . ":" . NONCE;

<br>
<br></li>

<li>Obtain a HMAC-SHA512 hash by hashing the <b>first string ($string1)</b> with the key <b>second string ($string2)</b>.

<li>Take the first 8 characters of the hexdecimal, and convert them to decimal.</li>

<li>Divide this decimal with <b>429496.7295</b> and round it to nearest whole number.</li>

<li>Your roll number is obtained, and it cannot be more than 10,000.</li>

</li>

</ul>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location = 'verify';">Verify Results</button> &nbsp; <button type="button" class="btn btn-default" data-dismiss="modal">Enough Said</button>
</div>
</div>

</div>
</div>

<section id="form-page">

<div class="container">

<div class="row">

<div class="col-md-12" >
<div class="panel panel-default" id="duh">
<div class="panel-body">

<div class="row">

<div class="col-md-3"><?php echo settings("sidebarLeft"); ?></div>

<div class="col-md-6">

<center>

<span style="font-size:58px;"><b>Roll</b></span>

<br>
<br>

<a href="history?id=2" class="btn btn-sm btn-success">History</a> &nbsp; <a onclick="proveFair();" class="btn btn-sm btn-success">Provably Fair</a>

<script>

function proveFair() {

$("#modalForMsg").modal("show");	
	
}

</script>

<br>
<br>

<?php

$captcha = settings("googleReCaptcha");

if($captcha == 1) {
	
echo '<p style="font-size:18px;">Please fill the captcha below and press the <b>Roll</b> button to receive your free Bitcoins. The amount of Bitcoins you win is depends upon the number you roll, and its paid according to its corresponding position in the payout table at bottom.';
	
} else {

echo '<p style="font-size:18px;">Please press the <b>Roll</b> button to receive your free Bitcoins. The amount of Bitcoins you win is depends upon the number you roll, and its paid according to its corresponding position in the payout table at bottom.';

}

?>

<br>
<br>

<div id="responseServer" style="display:none;">

<b><span id="responseMessage" style="font-size:15px;"></span></b>

<br>
<br>

</div>

<?php

$payTimePeriod = settings("rollTimePeriod");

$last_claim_roll = strtotime(loadAccDetails("user_id",$_SESSION['user_id'],"last_claim_roll"));
$time = strtotime(date("Y-m-d H:i:s"));
$difference = abs($last_claim_roll - $time);
$difference = round($difference / 60);

if($difference < $payTimePeriod) {
	
$rem = $payTimePeriod - $difference;	

echo '<span style="font-size:18px;"><b>' . $rem . " minutes left for next claim.</b></span>";
	
} else {
	
echo '<form method="post" onsubmit="return false;">';
	
echo '<div id="initialProcess">';

if($captcha == 1) {

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

echo '<br>

<input type="submit" class="btn btn-primary" onclick="processRoll();" value="Roll">';

echo '</div>';

echo '</form>';

}

?>

<input type="hidden" id="client_seed" value="">
<input type="hidden" id="nonce" value="">

<script>

function randomString(length, chars) {

    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;

}

nonce_gen = Math.floor(Math.random() * 10);
client_seed_gen = randomString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

document.getElementById("client_seed").value = client_seed_gen;
document.getElementById("nonce").value = nonce_gen;

document.getElementById("nonce_read").innerHTML = nonce_gen;
document.getElementById("client_seed_read").innerHTML = client_seed_gen;

function processRoll() {
	
<?php

if($captcha == 1) {

echo 'var g_res = grecaptcha.getResponse();';

} else {
	
echo 'var g_res = "null";';
	
}

?>

var client_seed = document.getElementById("client_seed").value;
var nonce = document.getElementById("nonce").value;

var http = new XMLHttpRequest();
var url = "programmer?method=roll";
var params = "g-recaptcha-response="+g_res+"&client_seed="+client_seed+"&nonce="+nonce;
http.open("POST", url, true);

http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

http.onreadystatechange = function() {
	
if(http.readyState == 4 && http.status == 200) {

document.getElementById("responseMessage").innerHTML = http.responseText;
document.getElementById("responseServer").style = "display:block;";
document.getElementById("initialProcess").style = "display:none;";

} else {

document.getElementById("responseMessage").innerHTML = "Calculating...";
document.getElementById("responseServer").style = "display:block;";

}

}

http.send(params);
	
}

</script>

<br>
<br>

<table class="table table-striped table-hover">
<thead>
<tr class="danger">
<th>Lucky Number</th>
<th>Payout Amount</th>
</tr>
</thead>
<tbody>

<tr class="success">
<td>0 - 9885</td>	
<td><?php echo settings("rollDice_level1"); ?> BTC</td>
</tr>	

<tr class="success">
<td>9886 - 9985</td>	
<td><?php echo settings("rollDice_level2"); ?> BTC</td>
</tr>	

<tr class="success">
<td>9986 - 9993</td>	
<td><?php echo settings("rollDice_level3"); ?> BTC</td>
</tr>	

<tr class="success">
<td>9994 - 9997</td>	
<td><?php echo settings("rollDice_level4"); ?> BTC</td>
</tr>	

<tr class="success">
<td>9998 - 9999</td>	
<td><?php echo settings("rollDice_level5"); ?> BTC</td>
</tr>	

<tr class="success">
<td>10000</td>	
<td><?php echo settings("rollDice_level6"); ?> BTC</td>
</tr>	

</tbody>
</table>

</center>

</div>

<div class="col-md-3"><?php echo settings("sidebarRight"); ?></div>

</div>


</div>
</div>
</div>


</div>
</div>
</section>