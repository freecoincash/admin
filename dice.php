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

<center>

<span style="font-size:58px;"><b>Hi-Lo</b></span>

<br>
<br>

<a href="history?id=3" class="btn btn-sm btn-success">History</a> &nbsp; <a onclick="proveFair();" class="btn btn-sm btn-success">Provably Fair</a>

<script>

function proveFair() {

$("#modalForMsg").modal("show");	
	
}

</script>

<br>
<br>

<p style="font-size:18px;">Increase your Bitcoins with our Hi-Lo game.</p>

</center>

<div id="panel1">
<div class="panel panel-default">
<div class="panel-body" style="padding: 5px;">

<center><h3>Roll the dice. Multiply your Bitcoin.</h3></center>

<br>

<center>

<div id="responseMessage" style="display:none;">

<ul class="pagination">
<li><a href="#" id="num1"><b>1</b></a></li>
<li><a href="#" id="num2"><b>0</b></a></li>
<li><a href="#" id="num3"><b>0</b></a></li>
<li><a href="#" id="num4"><b>0</b></a></li>
<li><a href="#" id="num5"><b>0</b></a></li>
</ul>

<p style="font-size:16px;"><b><span id="serverMessage">Processing...</span></b></font>

<br>

</div>

</center>

<br>

<style>
.btn.btn-primary {
	padding: 10px;
	font-size: 10pt;
	width: 20%;
}
</style>

<input type="hidden" id="balance" value="<?php echo $balance = loadAccDetails("user_id",$_SESSION['user_id'],"balance"); ?>">

<div class="col-md-8 center-block" style="float:none;">

<div class="row">

<div class="form-group col-md-8 col-xs-12">
<label class="control-label">Bet Amount</label>
<input type="text" class="form-control" id="bet_amt" value="0.000001" onkeyup="calculateAmounts(1);" onchange="calculateAmounts(6);" style="min-width:100%; border:1px solid #7EA927 !important;">
<div class="col-xs-12" style="padding-left:0px;">
<div class="input-group-btn" id="fourbtns">
<button class="btn btn-primary" type="button" onclick="setAmount(1);">/2</button>
<button class="btn btn-primary" type="button" onclick="setAmount(2);">2x</button>
<button class="btn btn-primary" type="button" onclick="setAmount(3);">MIN</button>
<button class="btn btn-primary" type="button" onclick="setAmount(4);">MAX</button>
</div>
</div>

</div>
<hr>
<div class="form-group col-md-4 col-xs-12" >
<div id="pwin">
<label class="control-label">Profit on Win</label>
<div class="input-group">
<input type="text" class="form-control" id="profit" disabled="" value="0.00000000">
</div>
</div>
</div>

</div>

<div class="row">

<div class="form-group col-md-8">
<div style="">
<label class="control-label">Payout (Multiplier)</label>
<div class="input-group" style="width:100%;">
<input type="text" class="form-control" value="1.01" id="payout" onkeyup="calculateAmounts(3);" onchange="calculateAmounts(3); calculateAmounts(5); calculateAmounts(6);">
</div>
</div>
</div>

<div class="form-group col-md-4">
<div style="float:right;">
<label class="control-label">Win Chance</label>
<div class="input-group">
<input type="text" class="form-control" value="94.06" id="win_chance" onchange="calculateAmounts(4); calculateAmounts(6); calculateAmounts(4); calculateAmounts(5); calculateAmounts(6);">
<span class="input-group-btn">
<button class="btn btn-primary" type="button" id="perc">%</button>
</span>
</div>
</div>
</div>

</div>

<br>

<big>In order to win, <b>BET HI</b> and get a number higher than <b><span id="high"></span></b>, and <b>BET LO</b> and get a number lower than <b><span id="low"></span></b>.</big>

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

function changeCounter() {
	
if(stop_counter != 1) {
	
document.getElementById("num1").innerHTML = Math.floor(Math.random() * 10);
document.getElementById("num2").innerHTML = Math.floor(Math.random() * 10);
document.getElementById("num3").innerHTML = Math.floor(Math.random() * 10);
document.getElementById("num4").innerHTML = Math.floor(Math.random() * 10);
document.getElementById("num5").innerHTML = Math.floor(Math.random() * 10);
	
setTimeout(changeCounter,200);

}	

}

function sendBet(id) {
	
var client_seed = document.getElementById("client_seed").value;
var nonce = document.getElementById("nonce").value;
var bet_amt = document.getElementById("bet_amt").value;
var profit = document.getElementById("profit").value;
var payout = document.getElementById("payout").value;
var win_chance = document.getElementById("win_chance").value;
var selection = id;

var http = new XMLHttpRequest();
var url = "programmer?method=dice";
var params = "client_seed="+client_seed+"&nonce="+nonce+"&bet_amt="+bet_amt+"&profit="+profit+"&payout="+payout+"&win_chance="+win_chance+"&selection="+id;
http.open("POST", url, true);

http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

document.getElementById("balance").value = (+document.getElementById("balance").value) - (+bet_amt);
document.getElementById("balance_global").innerHTML = ((+document.getElementById("balance_global").innerHTML) - (+bet_amt)).toFixed(8);

if(document.getElementById("balance").value < 0 || document.getElementById("balance_global").innerHTML < 0) {
	
document.getElementById("balance").value = 0;
document.getElementById("balance_global").innerHTML = 0;
	
}

http.onreadystatechange = function() {
	
if(http.readyState == 4 && http.status == 200) {

var obj = $.parseJSON(http.responseText);

if(obj.num1 == "" || obj.num1 == null) {
	
document.getElementById("num1").style = "display:none;";
	
} else {
	
document.getElementById("num1").style = "display:block;";	
document.getElementById("num1").innerHTML = obj.num1;
	
}

if(obj.num2 == "" || obj.num2 == null) {
	
document.getElementById("num2").style = "display:none;";
	
} else {
	
document.getElementById("num2").style = "display:block;";	
document.getElementById("num2").innerHTML = obj.num2;
	
}
	
if(obj.num3 == "" || obj.num3 == null) {
	
document.getElementById("num3").style = "display:none;";
	
} else {
	
document.getElementById("num3").style = "display:block;";
document.getElementById("num3").innerHTML = obj.num3;
	
}

if(obj.num4 == "" || obj.num4 == null) {
	
document.getElementById("num4").style = "display:none;";
	
} else {
	
document.getElementById("num4").style = "display:block;";
document.getElementById("num4").innerHTML = obj.num4;
	
}

if(obj.num5 == "" || obj.num5 == null) {
	
document.getElementById("num5").style = "display:none;";
	
} else {
	
document.getElementById("num5").style = "display:block;";
document.getElementById("num5").innerHTML = obj.num5;
	
}

type = "LO";

stop_counter = 1;

if(id == 1) {
	
type = "HI";
	
}

if(obj.error == 1) {
	
document.getElementById("serverMessage").innerHTML = obj.errorMessage;
	
} else {
	
if(obj.win == 1) {

document.getElementById("serverMessage").innerHTML = "You have bet "+type+" and earned a profit of "+obj.amount+" BTC.";
document.getElementById("balance").value = (+document.getElementById("balance").value) + +bet_amt + +obj.amount;
document.getElementById("balance_global").innerHTML = ((+document.getElementById("balance_global").innerHTML) + +bet_amt + +obj.amount).toFixed(8);

} else {
	
document.getElementById("serverMessage").innerHTML = "You have bet "+type+" and lost "+obj.amount+" BTC.";
	
}

}

} else {

document.getElementById("num1").style = "display:block;";
document.getElementById("num2").style = "display:block;";
document.getElementById("num3").style = "display:block;";
document.getElementById("num4").style = "display:block;";
document.getElementById("num5").style = "display:block;";

document.getElementById("serverMessage").innerHTML = "Processing...";
document.getElementById("responseMessage").style = "display:block;";
stop_counter = 0;
changeCounter();

}

}

http.send(params);	
	
}

function calculateAmounts(id) {
	
var bet_amt = document.getElementById("bet_amt").value;
var profit = document.getElementById("profit").value;
var payout = document.getElementById("payout").value;
var win_chance = document.getElementById("win_chance").value;
	
if(id == 1) {
	
if(isNaN(bet_amt) == false) {

var cal = payout * 100;
var cal = cal / 100 * bet_amt;
var cal = cal - bet_amt;

function decimalAdjust(type, value, exp) {
		// If the exp is undefined or zero...
		if (typeof exp === 'undefined' || +exp === 0) {
			return Math[type](value);
		}
		value = +value;
		exp = +exp;
		// If the value is not a number or the exp is not an integer...
		if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
			return NaN;
		}
		// Shift
		value = value.toString().split('e');
		value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
		// Shift back
		value = value.toString().split('e');
		return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
	}

Math.floor10 = function(value, exp) {
return decimalAdjust('floor', value, exp);
}

toFixedf = function(num,precision) {
return Math.floor10(num, -precision).toFixed(precision);
}

document.getElementById("profit").value = toFixedf(cal,8);

} else {
	
document.getElementById("bet_amt").value = (0).toFixed(8);
document.getElementById("profit").value = (0).toFixed(8);
	
}	
	
} else if(id == 3) {
	
if(isNaN(payout) == false) {
	
var floatVar = parseFloat(payout);
var cal_pre = (9500/floatVar);

var cal = (cal_pre / 10000 * 100).toFixed(2);

document.getElementById("win_chance").value = parseFloat(cal).toFixed(2);

calculateAmounts(1);

} else {
	
document.getElementById("payout").value = (1.01).toFixed(2);
document.getElementById("win_chance").value = (94.06).toFixed(2);

calculateAmounts(1);
	
}	
	
} else if(id == 4) {
	
if(isNaN(win_chance) == false) {

var cal = 95 / win_chance;

document.getElementById("payout").value = (cal).toFixed(2);

calculateAmounts(3);
calculateAmounts(1);

} else {
	
document.getElementById("payout").value = (1.01).toFixed(2);
document.getElementById("win_chance").value = (94.06).toFixed(2);

calculateAmounts(3);
calculateAmounts(1);
	
}	
	
} else if(id == 5) {
	
if(document.getElementById("payout").value < 1.01) {
	
document.getElementById("payout").value = (1.01).toFixed(2);

calculateAmounts(3);
calculateAmounts(5);
calculateAmounts(6);
	
}

if(document.getElementById("payout").value > 4750.00) {

document.getElementById("payout").value = (4750.00).toFixed(2);

calculateAmounts(3);
calculateAmounts(5);
calculateAmounts(6);
	
}

if(document.getElementById("win_chance").value < 0.02) {
	
document.getElementById("win_chance").value = (0.02).toFixed(2);

calculateAmounts(4);
calculateAmounts(5);
calculateAmounts(6);
	
}

if(document.getElementById("win_chance").value > 94.06) {

document.getElementById("win_chance").value = (94.06).toFixed(2);

calculateAmounts(4);
calculateAmounts(5);
calculateAmounts(6);
	
}

calculateAmounts(1);
	
} else if(id == 6) {
	
document.getElementById("win_chance").value = parseFloat(win_chance).toFixed(2);
document.getElementById("payout").value = parseFloat(payout).toFixed(2);
	
var cal = document.getElementById("win_chance").value;
var cal = cal * 100;

document.getElementById("high").innerHTML = 10000 - cal;
document.getElementById("low").innerHTML = cal;
	
}
	
}

function setAmount(id) {
	
if(id == 1) {

var bet_amt = document.getElementById("bet_amt").value;
var burp = bet_amt / 2;

if(isNaN(burp) == false) {

document.getElementById("bet_amt").value = burp.toFixed(8);

} else {
	
document.getElementById("bet_amt").value = (0).toFixed(8);
	
}
	
} else if(id == 2) {

var bet_amt = document.getElementById("bet_amt").value;
var burp = bet_amt * 2;

if(isNaN(burp) == false) {

document.getElementById("bet_amt").value = burp.toFixed(8);

} else {
	
document.getElementById("bet_amt").value = (0).toFixed(8);
	
}
	
} else if(id == 3) {

document.getElementById("bet_amt").value = (0.00000001).toFixed(8);
	
} else {
	
if((document.getElementById("balance").value) >= <?php echo $maxBetWin = settings("maxBetWin"); ?>) {
	
var balance = document.getElementById("balance").value;

document.getElementById("bet_amt").value = parseFloat(balance).toFixed(8);
	
} else {
	
document.getElementById("bet_amt").value = (<?php echo ($maxBetWin - 1); ?>).toFixed(8);

}

}

calculateAmounts(1);	
	
}

calculateAmounts(1);
calculateAmounts(3);
calculateAmounts(4);
calculateAmounts(5);
calculateAmounts(6);

</script>

<br>
<br>

<center><a onclick="sendBet(1);" class="btn btn-primary btn-lg" id="betbtn">Bet <b>Hi</b></a> &nbsp; <a onclick="sendBet(2);" class="btn btn-primary btn-lg" id="betbtn">Bet <b>Lo</b></a></center>

</div>

</div>
</div>
</div>

<div id="panel2" style="display:none;">
<div class="panel panel-default">
<div class="panel-body">

Will be added in next version.

</div>
</div>
</div>

<script>

function setPanel(panel_id) {
	
if(panel_id == 1) {
	
document.getElementById("panel1").style = "display:block;";
document.getElementById("panel2").style = "display:none;";
document.getElementById("btn1").style = "opacity:0.7;";	
document.getElementById("btn2").style = "opacity:1;";	
	
} else {
	
document.getElementById("panel1").style = "display:none;";
document.getElementById("panel2").style = "display:block;";
document.getElementById("btn1").style = "opacity:1;";	
document.getElementById("btn2").style = "opacity:0.7;";
	
}	
	
}

</script>

</div>

</div>
</div>
</div>


</div>
</div>
</section>