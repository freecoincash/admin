<div id="modalForMsg" class="modal fade" role="dialog">
<div class="modal-dialog">

<div class="modal-content" style="overflow:none;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">More Information</h4>
</div>

<div class="modal-body" id="modal_msg" style="overflow:none;">

<ul>

<li>The tickets that you receivr must be allocated to the desired round.</li>
<li>You can buy lottery tickets, and keep them in your inventory, and allocate them whenever you want to.</li>
<li>The countdown bar at this page continues to roll down until the time of results come. It takes us around 1 to 5 minutes to process the current round and set open the next one.</li>
<li>When the round ends, the server automatically chooses the top ten winners randomly.</li>
<li>Having more tickets may increase the winning chance for the user.</li>
<li>A user can only win single prize in the contest.</li>
<li>After winning, the amount will be added to the users' balance and will be available for withdrawal immediately. We'll further send an email informing the user about their win.</li>

</ul>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

<?php

$r = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM raffle_rounds ORDER BY id DESC LIMIT 1"));
$total_amount_pool = $r['tickets_allocated'] * settings("ticketCost");
$first = sprintf("%.8f",($r['first'] / 100) * $total_amount_pool);
$second = sprintf("%.8f",($r['second'] / 100) * $total_amount_pool);
$third = sprintf("%.8f",($r['third'] / 100) * $total_amount_pool);
$fourth = sprintf("%.8f",($r['fourth'] / 100) * $total_amount_pool);
$fifth = sprintf("%.8f",($r['fifth'] / 100) * $total_amount_pool);
$sixth = sprintf("%.8f",($r['sixth'] / 100) * $total_amount_pool);
$seventh = sprintf("%.8f",($r['seventh'] / 100) * $total_amount_pool);
$eighth = sprintf("%.8f",($r['eighth'] / 100) * $total_amount_pool);
$nineth = sprintf("%.8f",($r['nineth'] / 100) * $total_amount_pool);
$tenth = sprintf("%.8f",($r['tenth'] / 100) * $total_amount_pool);

?>

<span style="font-size:58px;"><b>Raffle/Lottery</b></span>

<br>

Round #<?php echo $r['id']; ?>

<br>
<br>

<a onclick="loadModal();" class="btn btn-primary">More Information</a> &nbsp; <a href="history?id=4" class="btn btn-primary">Previous Rounds</a>

</center>

<br>
<br>

<script>

function loadModal() {
	
$("#modalForMsg").modal("show");		
	
}

</script>

<div class="row">
<div class="col-md-3 center-block" style="float:none;">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>FIRST</b></span>

<br>

<span style="font-size:16px;"><?php echo $first; ?> BTC</span>

</center>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 center-block" style="float:none;">

<div class="col-md-3"></div>

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>SECOND</b></span>

<br>

<span style="font-size:16px;"><?php echo $second; ?> BTC</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>THIRD</b></span>

<br>

<span style="font-size:16px;"><?php echo $third; ?> BTC</span>

</center>

</div>
</div>
</div>

</div>
</div>


<div class="row">
<div class="col-md-10 col-md-offset-2">

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>FOURTH</b></span>

<br>

<span style="font-size:16px;"><?php echo $fourth; ?> BTC</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>FIFTH</b></span>

<br>

<span style="font-size:16px;"><?php echo $fifth; ?> BTC</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>SIXTH</b></span>

<br>

<span style="font-size:16px;"><?php echo $sixth; ?> BTC</span>

</center>

</div>
</div>
</div>

</div>
</div>

<div class="row">

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>SEVENTH</b></span>

<br>

<span style="font-size:16px;"><?php echo $seventh; ?> BTC</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>EIGHTH</b></span>

<br>

<span style="font-size:16px;"><?php echo $eighth; ?> BTC</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>NINETH</b></span>

<br>

<span style="font-size:16px;"><?php echo $nineth; ?> BTC</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-body">

<center>

<span style="font-size:20px;"><b>TENTH</b></span>

<br>

<span style="font-size:16px;"><?php echo $tenth; ?> BTC</span>

</center>

</div>
</div>
</div>

</div>

<br>
<br>

<?php

if(isset($_POST['purchase'])) {
	
$amount = filterData(intval($_POST['amount']));
$balance = loadAccDetails("user_id",$_SESSION['user_id'],"balance");

$cost = $amount * settings("ticketCost");

if(!is_numeric($amount) || $amount < 1) {
	
echo '<div class="alert alert-info">
The amount you\'re trying to buy is not valid.
</div>';	
	
} elseif($cost > $balance) {
	
echo '<div class="alert alert-info">
The balance is not sufficient to complete this transaction.
</div>';	
	
} else {
	
mysqli_query($con,"UPDATE users SET balance = balance - {$cost}, raffle_tickets = raffle_tickets + {$amount} WHERE user_id = {$_SESSION['user_id']}");
	
echo '<div class="alert alert-success">
The tickets have been purchased successfully.
</div>';	
	
}	

}

if(isset($_POST['allocate'])) {
	
$amount = filterData(intval($_POST['amount']));
$raffle_tickets = loadAccDetails("user_id",$_SESSION['user_id'],"raffle_tickets");

if(!is_numeric($amount) || $amount < 1) {
	
echo '<div class="alert alert-info">
The amount you\'re trying to allocate is not valid.
</div>';	
	
} elseif($amount > $raffle_tickets) {
	
echo '<div class="alert alert-info">
The raffle tickets balance is not sufficient to complete this transaction.
</div>';	
	
} else {
	

mysqli_query($con,"UPDATE raffle_rounds SET tickets_allocated = tickets_allocated + {$amount} WHERE id = {$r['id']}");	
mysqli_query($con,"UPDATE rounds_allocation SET tickets = tickets + {$amount} WHERE user_id = {$_SESSION['user_id']} AND round_id = {$r['id']}");

if(mysqli_affected_rows($con) < 0.99) {
	
mysqli_query($con,"INSERT INTO rounds_allocation (user_id,tickets,round_id) VALUES ({$_SESSION['user_id']},{$amount},{$r['id']})");
	
}
	
mysqli_query($con,"UPDATE users SET raffle_tickets = raffle_tickets - {$amount} WHERE user_id = {$_SESSION['user_id']}");
	
echo '<div class="alert alert-success">
The tickets have been allocated successfully.
</div>';	
	
}	

}

?>

<center>

<script>

var end = new Date('<?php echo $r['end']; ?>');

var _second = 1000;
var _minute = _second * 60;
var _hour = _minute * 60;
var _day = _hour * 24;
var timer;

function showRemaining() {

var now = new Date();
offset = '<?php echo date('Z') / 3600; ?>';
utc = now.getTime() + (now.getTimezoneOffset() * 60000);
now = new Date(utc + (3600000*offset));

var distance = end - now;

if(distance < 0) {

clearInterval(timer);
document.getElementById('countdown').innerHTML = 'Round Over! Refresh in 5 minutes.';

return;

}

var days = Math.floor(distance / _day);
var hours = Math.floor((distance % _day) / _hour);
var minutes = Math.floor((distance % _hour) / _minute);
var seconds = Math.floor((distance % _minute) / _second);

document.getElementById('countdown').innerHTML = days + ' DAYS, ';
document.getElementById('countdown').innerHTML += hours + ' HOURS, ';
document.getElementById('countdown').innerHTML += minutes + ' MINUTES, ';
document.getElementById('countdown').innerHTML += seconds + ' SECONDS';

}

timer = setInterval(showRemaining, 1000);

</script>

<div class="col-md-8 panel panel-default center-block" style="float:none;">
<div class="panel-body">
<span style="font-size:25px;"><div id="countdown"></div></span>
</div>
</div>

</center>

<br>

<div class="col-md-6 center-block" style="float:none;">

<table class="table table-striped table-hover">
<thead>
<tr class="success">    
<th>Your Tickets</th>
<th>Total Tickets</th>
</tr>
</thead>
<tbody>

<?php

$q = mysqli_query($con,"SELECT tickets FROM rounds_allocation WHERE user_id = {$_SESSION['user_id']} AND round_id = {$r['id']}");

if(mysqli_num_rows($q) > 0.99) {
	
$qr = mysqli_fetch_array($q);
$tickets = $qr['tickets'];
$chance = sprintf("%.2f",($tickets/$r['tickets_allocated'])*100);

if($chance > 100) {
	
$chance = 99.99;
	
}
	
} else {
	
$tickets = 0;
$chance = 0.00;
	
}

?>

<tr class="primary">
<td><?php echo $tickets; ?></td>	
<td><?php echo $r["tickets_allocated"]; ?></td>	
</tr>

</tbody>
</table>

</div>

<br>
<br>

<div class="row">

<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-body">

<b>Purchase Tickets:</b>

<br>
<br>

<form action="" method="post">

<div class="form-group">
<label class="control-label">Ticket Amount</label>
<input type="number" name="amount" id="amount" class="form-control" placeholder="How many do you want to purchase?" onchange="calPrice();">
</div>

<div class="form-group">
<label class="control-label">Price per Ticket</label>
<input type="text" class="form-control" id="ticketCost" value="<?php echo settings("ticketCost"); ?>" disabled="">
</div>

<div class="form-group">
<label class="control-label">Total Cost</label>
<input type="text" class="form-control" value="0.00000000" id="ticketCostFull" disabled="">
</div>

<input type="submit" name="purchase" value="Purchase" class="btn btn-primary">

<script>

function calPrice() {
	
var ticketCost = document.getElementById("ticketCost").value;
var amount = document.getElementById("amount").value;

document.getElementById("ticketCostFull").value = parseFloat(amount * ticketCost).toFixed(8);
	
}

</script>

</form>

</div>
</div>
</div>

<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-body">

<b>Allocate Tickets:</b>

<br>
<br>

<form action="" method="post">

<div class="form-group">
<label class="control-label">Tickets Available</label>
<input type="text" class="form-control" id="ticketCost" value="<?php echo loadAccDetails("user_id",$_SESSION['user_id'],"raffle_tickets"); ?>" disabled="">
</div>

<div class="form-group">
<label class="control-label">Ticket Amount</label>
<input type="number" name="amount" id="amount" class="form-control" placeholder="How many do you want to allocate?">
</div>

<input type="submit" value="Allocate" name="allocate" class="btn btn-primary">

</form>

<br>
<br>
<br>
<br>

</div> 
</div>
</div>

</div>
</div>
</div>

</div>
</div>
</div>
</section>