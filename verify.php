<div class="loader"></div>

<div class="container">
<div class="row">

<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:58px;" class="headline"><b>Verify Rolls</b></span>

<br>
<br>

<p style="font-size:20px;">Obtain your previous roll's details by going to <b>History</b> and then clicking <b>Seeds/Details</b> in the corresponding row. Fill out the variables there, and you'll notice that they will match and we did not use any unfair means to change the roll number in our favour.</p>
<p style="font-size:20px;">This tool is coded in Javascript and you can easily verify its source code (CTRL + U) or by clicking <b><a href="http://pastebin.com/WJQuqc5u">here</a></b>. The calculations are done right away in your browser.

<br>
<br>

</center>

<?php

if(isset($_GET['method']) && isset($_GET['id'])) {
	
$method = filterData($_GET['method']);
$id = filterData(intval($_GET['id']));
	
if($method == "roll") {
	
$load = mysqli_query($con,"SELECT client_seed,nonce,server_seed,server_seed_hash FROM roll_wins WHERE id = {$id} AND user_id = {$_SESSION['user_id']}");	

} elseif($method == "dice") {
	
$load = mysqli_query($con,"SELECT client_seed,nonce,server_seed,server_seed_hash FROM dice_wins WHERE id = {$id} AND user_id = {$_SESSION['user_id']}");	
	
} else {
	
$load = mysqli_query($con,"SELECT client_seed,nonce,server_seed,server_seed_hash FROM treasure_wins WHERE id = {$id} AND user_id = {$_SESSION['user_id']}");	
	
}
	
if(mysqli_num_rows($load) > 0.99) {
	
$r = mysqli_fetch_array($load);
	
}	
	
}

?>

<script src="assets/js/sha512.js"></script>

<div class="row">

<div class="form-group col-md-6">
<label class="control-label">Client Seed</label>
<div class="input-group" style="width:100%">
<input type="text" class="form-control" id="client_seed" placeholder="Paste your client seed here" value="<?php if(isset($r['client_seed'])) { echo $r['client_seed']; } ?>">
</div>
</div>

<div class="form-group col-md-6">
<label class="control-label">Nonce</label>
<div class="input-group" style="width:100%">
<input type="text" class="form-control" id="nonce" placeholder="Write your nonce here" value="<?php if(isset($r['nonce'])) { echo $r['nonce']; } ?>">
</div>
</div>

</div>

<div class="row">

<div class="form-group col-md-6">
<label class="control-label">Server Seed</label>
<div class="input-group" style="width:100%">
<input type="text" class="form-control" id="server_seed" placeholder="Paste your server seed here" value="<?php if(isset($r['server_seed'])) { echo $r['server_seed']; } ?>">
</div>
</div>

<div class="form-group col-md-6">
<label class="control-label">Server Seed Hash</label>
<div class="input-group" style="width:100%">
<input type="text" class="form-control" id="server_seed_hash" placeholder="Paste your server seed hash here" value="<?php if(isset($r['server_seed_hash'])) { echo $r['server_seed_hash']; } ?>">
</div>
</div>

</div>

<div id="manageResponseDiv" style="display:none;">

<br>

<center><span style="font-size:20px; font-weight:bold; text-align:center;" id="responseMessage"></span></center>

<br>

</div>

<center><button class="btn btn-primary" onclick="calculateHashes();">Calculate</button></center>

</div>

<script>

function calculateHashes() {
	
var client_seed = document.getElementById("client_seed").value;
var nonce = document.getElementById("nonce").value;
var server_seed = document.getElementById("server_seed").value;
var server_seed_hash = document.getElementById("server_seed_hash").value;
	
var shaObj = new jsSHA("SHA-512","TEXT");
shaObj.update(server_seed);
generate_server_seed_hash = shaObj.getHash("HEX");

if(generate_server_seed_hash == server_seed_hash) {
	
var shaObj = new jsSHA("SHA-512", "TEXT");
shaObj.setHMACKey(nonce + ":" + client_seed + ":" + nonce, "TEXT");
shaObj.update(nonce + ":" + server_seed + ":" + nonce);
var generated_hmac = shaObj.getHMAC("HEX");	
var series = generated_hmac.slice(0,8);
var decimal = parseInt(series, 16);
var roll_number = Math.round(decimal / 429496.7295);

document.getElementById("responseMessage").innerHTML = "The hashes match. The roll number is: " + roll_number + ".";
document.getElementById("manageResponseDiv").style = "display:block;";
	
} else {
	
document.getElementById("responseMessage").innerHTML = "The hashes do not match.";
document.getElementById("manageResponseDiv").style = "display:block;";
	
}	
	
}

</script>

</div>

</div>
</div>
</div>


</div>