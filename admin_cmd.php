<style>

.h5 {
	background-color: white;
}
</style>

<div class="container">

<?php

$page = filterData($_GET['page']);

if($page == "settings") { ?>
	
<div class="page-header">	
<h1>Settings:</h1>
</div>

<?php

if(isset($_POST['update_settings'])) {
	
foreach($_POST as $key => $value) {
	
$key = filterData($key);

if($key == "claimPageCode" OR $key == "footerAdCode" OR $key == "sidebarLeft" OR $key == "sidebarRight") {

$value = mysqli_real_escape_string($con,$_POST[$key]);

} else {
	
$value = filterData($_POST[$key]);
	
}

mysqli_query($con,"UPDATE settings SET value = '{$value}' WHERE name = '{$key}'");

}

echo '<div class="alert alert-dismissable alert-success">
Updated the settings ^.^
</div>';	
	
}

?>

<form action="" method="post">

<?php

if(isset($_GET['reset_bitcoin_secret'])) {
	
$bitcoinSecretCode = uniqid() . uniqid() . time() . uniqid() . uniqid();
	
mysqli_query($con,"UPDATE settings SET value = '{$bitcoinSecretCode}' WHERE name = 'bitcoinSecretCode'");
mysqli_query($con,"UPDATE users SET deposit_address = '' WHERE deposit_address <> ''");	

echo '<div class="alert alert-success">
Changed to <b>' . $bitcoinSecretCode . '</b>. Bitcoin deposit addresses reset.
</div>';
	
}

?>

<a href="admin_cmd?page=settings&reset_bitcoin_secret=1" class="btn btn-primary btn-sm pull-right" id="rbtcs" style="width:auto;">Reset Bitcoin Addresses</a>

<br>

<h3><b>Site Details:</b></h3>

<br>

<h4>Website Name:</h4>
<input type="text" name="website_name" value="<?php echo settings('website_name'); ?>" class="form-control">

<br>

<h4>Website URL:</h4>
<input type="text" name="website_url" value="<?php echo settings('website_url'); ?>" class="form-control">

<br>

<h4>No Reply Email Addr:</h4>
<input type="text" name="noReplyEmail" value="<?php echo settings('noReplyEmail'); ?>" class="form-control">

<br>

<h4>Contact Email</h4>
<input type="text" name="contactEmail" value="<?php echo settings('contactEmail'); ?>" class="form-control">

<br>

<h4>Remember-Me (Stay Logged-In) Length (in days):</h4>
<input type="text" name="StayLoggedDAYS" value="<?php echo settings('StayLoggedDAYS'); ?>" class="form-control">

<br>

<h4>Forums:</h4>
<select name="Forums" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('Forums') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>

<br>

<h4>Registration Email Confirmation:</h4>
<select name="emailConfirmation" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('emailConfirmation') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>

<br>

<h4>Chatting System:</h4>
<select name="ChatEnabled" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('ChatEnabled') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>

<br>

<h4>Cron Key:</h4>
<input type="text" name="cronKey" value="<?php echo settings('cronKey'); ?>" class="form-control">

<br>

<h3><b>Captcha Settings:</b></h3>

<br>

<h4>Google ReCaptcha:</h4>
<select name="googleReCaptcha" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('googleReCaptcha') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>

<br>

<h4>ReCaptcha Public (Site) Key:</h4>
<input type="text" name="googleRecaptcha_PUBLICkey" value="<?php echo settings('googleRecaptcha_PUBLICkey'); ?>" class="form-control">
<br>

<h4>ReCaptcha Secret (Server) Key:</h4>
<input type="text" name="googleRecaptcha_SECRETkey" value="<?php echo settings('googleRecaptcha_SECRETkey'); ?>" class="form-control">
<br>

<h4>SolveMedia C Key:</h4>
<input type="text" name="SolveMedia_C" value="<?php echo settings('SolveMedia_C'); ?>" class="form-control">

<br>

<h4>SolveMedia V Key:</h4>
<input type="text" name="SolveMedia_V" value="<?php echo settings('SolveMedia_V'); ?>" class="form-control">

<br>

<h4>SolveMedia H Key:</h4>
<input type="text" name="SolveMedia_H" value="<?php echo settings('SolveMedia_H'); ?>" class="form-control">

<br>

<h3><b>Faucet and Satoshi Snakes:</b></h3>

<br>

<h4>Faucet Status:</h4>
<select name="faucetStatus" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('faucetStatus') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>

<br>

<h4>Pay Amount:</h4>
<input type="text" name="payAmount" value="<?php echo settings('payAmount'); ?>" class="form-control">

<br>

<h4>Pay Pause Time-Period (Minutes):</h4>
<input type="text" name="payTimePeriod" value="<?php echo settings('payTimePeriod'); ?>" class="form-control">

<br>

<h4>Referral Percentage:</h4>
<input type="text" name="refPercentageFaucet" value="<?php echo settings('refPercentageFaucet'); ?>" class="form-control">

<br>

<h4>Satoshi Snake Status:</h4>
<select name="gameSatoshiSnake" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('gameSatoshiSnake') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>

<br>

<h4>Pay Amount:</h4>
<input type="text" name="snakeScoreSatoshi" value="<?php echo settings('snakeScoreSatoshi'); ?>" class="form-control">

<br>

<h4>Daily Limit (Maximum Rounds):</h4>
<input type="text" name="snakesLimitDaily" value="<?php echo settings('snakesLimitDaily'); ?>" class="form-control">

<br>

<h4>Maximum Score per Round</h4>
<input type="text" name="maximumRoundScore" value="<?php echo settings('maximumRoundScore'); ?>" class="form-control">

<br>

<h3><b>Withdrawal Settings:</b></h3>

<br>

<h4>Instant Payouts:</h4>
<select name="instantPayout" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('instantPayout') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>

<br>

<h4>Minimum Withdrawal:</h4>
<input type="text" name="minimumWithdrawal" value="<?php echo settings('minimumWithdrawal'); ?>" class="form-control">

<br>

<h4>CoinPayments API Key:</h4>
<input type="text" name="CoinPaymentsAPIKey" value="<?php echo settings('CoinPaymentsAPIKey'); ?>" class="form-control">

<br>

<h4>CoinPayments API Secret:</h4>
<input type="text" name="CoinPaymentsAPISecret" value="<?php echo settings('CoinPaymentsAPISecret'); ?>" class="form-control">

<br>

<h4>CoinPayments Merchant ID:</h4>
<input type="text" name="CoinPaymentsMerchantID" value="<?php echo settings('CoinPaymentsMerchantID'); ?>" class="form-control">

<br>

<h4>CoinPayments IPN Secret:</h4>
<input type="text" name="CoinPaymentsIPNSecret" value="<?php echo settings('CoinPaymentsIPNSecret'); ?>" class="form-control">


<br>

<h3><b>Ad-Code Settings:</b></h3>

<br>

<h4>Claim Code Source:</h4>
<textarea class="form-control" name="claimPageCode" rows="6"><?php echo settings("claimPageCode"); ?></textarea>

<br>

<h4>Footer Code Source:</h4>
<textarea class="form-control" name="footerAdCode" rows="6"><?php echo settings("footerAdCode"); ?></textarea>

<br>

<h4>Sidebar (Left) Source:</h4>
<textarea class="form-control" name="sidebarLeft" rows="6"><?php echo settings("sidebarLeft"); ?></textarea>

<br>

<h4>Sidebar (Right) Source:</h4>
<textarea class="form-control" name="sidebarRight" rows="6"><?php echo settings("sidebarRight"); ?></textarea>

<br>

<h3><b>Roll Dice:</b></h3>

<br>

<h4>0 - 9885 (Winning Amount):</h4>
<input type="text" name="rollDice_level1" value="<?php echo settings('rollDice_level1'); ?>" class="form-control">

<br>

<h4>9886 - 9985 (Winning Amount):</h4>
<input type="text" name="rollDice_level2" value="<?php echo settings('rollDice_level2'); ?>" class="form-control">

<br>

<h4>9986 - 9993 (Winning Amount):</h4>
<input type="text" name="rollDice_level3" value="<?php echo settings('rollDice_level3'); ?>" class="form-control">

<br>

<h4>9994 - 9997 (Winning Amount):</h4>
<input type="text" name="rollDice_level4" value="<?php echo settings('rollDice_level4'); ?>" class="form-control">

<br>

<h4>9998 - 9999 (Winning Amount):</h4>
<input type="text" name="rollDice_level5" value="<?php echo settings('rollDice_level5'); ?>" class="form-control">

<br>

<h4>10000 (Winning Amount):</h4>
<input type="text" name="rollDice_level6" value="<?php echo settings('rollDice_level6'); ?>" class="form-control">

<br>

<h4>Game Pause Time-Period (Minutes):</h4>
<input type="text" name="rollTimePeriod" value="<?php echo settings('rollTimePeriod'); ?>" class="form-control">

<br>

<h4>Raffle Tickets Reward:</h4>
<input type="text" name="rollRaffleAmount" value="<?php echo settings('rollRaffleAmount'); ?>" class="form-control">

<br>

<h4>Referral Percentage:</h4>
<input type="text" name="refPercentageRoll" value="<?php echo settings('refPercentageRoll'); ?>" class="form-control">

<br>

<h3><b>Roll Hi-Lo Dice:</b></h3>

<br>

<h4>Maximum Profit (Per Bet):</h4>
<input type="text" name="maxBetWin" value="<?php echo settings('maxBetWin'); ?>" class="form-control">

<br>

<h4>Referral Percentage:</h4>
<input type="text" name="refPercentageDice" value="<?php echo settings('refPercentageDice'); ?>" class="form-control">

<br>

<h3><b>Fortune Hunter:</b></h3>

<br>

<h4>Minimum Bet:</h4>
<input type="text" name="treasureGame_minBet" value="<?php echo settings('treasureGame_minBet'); ?>" class="form-control">

<br>

<h4>Maximum Bet:</h4>
<input type="text" name="treasureGame_maxBet" value="<?php echo settings('treasureGame_maxBet'); ?>" class="form-control">

<br>

<h4>Referral Percentage:</h4>
<input type="text" name="refPercentageTreasureGame" value="<?php echo settings('refPercentageTreasureGame'); ?>" class="form-control">

<br>

<h4>Game Return Percentage:</h4>
<input type="text" name="treasureGame_ReturnPer" value="<?php echo settings('treasureGame_ReturnPer'); ?>" class="form-control">

<br>

<small>N.B.: Put a value bigger than 100 in game return percentage as this includes both the bet amount and profit. For instance, if you want to double the user coins, put 200 in the field.</small>

<br>

<h3><b>Raffle Settings:</b></h3>

<br>

<h4>Ticket Cost:</h4>
<input type="text" name="ticketCost" value="<?php echo settings('ticketCost'); ?>" class="form-control">

<br>

<h4>Raffle Round Time-Period (Hours):</h4>
<input type="text" name="raffleHours" value="<?php echo settings('raffleHours'); ?>" class="form-control">

<br>

<h4>Raffle (First Winner) Winning Percentage</h4>
<input type="text" name="raffle_first_per" value="<?php echo settings('raffle_first_per'); ?>" class="form-control">

<br>

<h4>Raffle (Second Winner) Winning Percentage</h4>
<input type="text" name="raffle_second_per" value="<?php echo settings('raffle_second_per'); ?>" class="form-control">

<br>

<h4>Raffle (Third Winner) Winning Percentage</h4>
<input type="text" name="raffle_third_per" value="<?php echo settings('raffle_third_per'); ?>" class="form-control">

<br>

<h4>Raffle (Fourth Winner) Winning Percentage</h4>
<input type="text" name="raffle_fourth_per" value="<?php echo settings('raffle_fourth_per'); ?>" class="form-control">

<br>

<h4>Raffle (Fifth Winner) Winning Percentage</h4>
<input type="text" name="raffle_fifth_per" value="<?php echo settings('raffle_fifth_per'); ?>" class="form-control">

<br>

<h4>Raffle (Sixth Winner) Winning Percentage</h4>
<input type="text" name="raffle_sixth_per" value="<?php echo settings('raffle_sixth_per'); ?>" class="form-control">

<br>

<h4>Raffle (Seventh Winner) Winning Percentage</h4>
<input type="text" name="raffle_seventh_per" value="<?php echo settings('raffle_seventh_per'); ?>" class="form-control">

<br>

<h4>Raffle (Eighth Winner) Winning Percentage</h4>
<input type="text" name="raffle_eighth_per" value="<?php echo settings('raffle_eighth_per'); ?>" class="form-control">

<br>

<h4>Raffle (Nineth Winner) Winning Percentage</h4>
<input type="text" name="raffle_nineth_per" value="<?php echo settings('raffle_nineth_per'); ?>" class="form-control">

<br>

<h4>Raffle (Tenth Winner) Winning Percentage</h4>
<input type="text" name="raffle_tenth_per" value="<?php echo settings('raffle_tenth_per'); ?>" class="form-control">

<br>

<h3><b>API Settings:</b></h3>

<br>

API function deprecated in 2016 Christmas update.

<br>
<br>

<input type="submit" class="btn btn-primary btn-lg" value="Update" name="update_settings">

</form>
	
<?php } elseif($page == "all_users") { ?>

<div class="page-header">	
<h1>All Users:</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(user_id) AS id FROM users ORDER BY user_id DESC");
$numrows = mysqli_fetch_array($rc);

$refs = 50;
$total_pages = ceil($numrows['id'] / $refs);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $refs;

$query = mysqli_query($con,"SELECT user_id,user_name,user_email,registration_datetime,balance,total_referred FROM users ORDER BY user_id DESC LIMIT $offset, $refs");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">    
    <th>Username</th>
    <th>Email</th>
    <th>Registration Datetime</th>
    <th>Balance</th>
    <th>Total Earned (from refs.)</th>
    <th>Control</th>
    </tr>
  </thead>
  <tbody>';
  
while($usr = mysqli_fetch_array($query)) {	 
 
echo '<tr class="success">';
echo  '<td>' . $usr['user_name'] . '</td>';	
echo  '<td>' . $usr['user_email'] . '</td>';
echo  '<td>' . $usr['registration_datetime'] . '</td>';
echo  '<td>' . $usr['balance'] . '</td>';
echo  '<td>' . $usr['total_referred'] . '</td>';
echo '<td><a href="admin?fetchusrdetails=1&user=' . $usr['user_id'] . '&matcher=user_id">View</a> | <a href="admin?editusrdetails=1&user=' . $usr['user_id'] . '&matcher=user_id">Edit</a> | <a href="admin?deleteuser=1&user=' . $usr['user_id'] . '&matcher=user_id" onclick="return confirm(\'Are you sure that you want to delete this user?\');">Delete</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
	$prev = $req_page - 1;
  echo '<li><a href="?page=all_users&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?page=all_users&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;

echo '<li><a href="?page=all_users&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';
	
} else {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Bad thing! No user has registered.
</div>';
	
}

?>
	
<?php } elseif($page == "banned_users") { ?>

<div class="page-header">	
<h1>Banned Users:</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(user_id) AS id FROM users WHERE account_status = 0 ORDER BY user_id DESC");
$numrows = mysqli_fetch_array($rc);

$refs = 50;
$total_pages = ceil($numrows['id'] / $refs);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $refs;

$query = mysqli_query($con,"SELECT user_id,user_name FROM users WHERE account_status = 0 ORDER BY user_id DESC LIMIT $offset, $refs");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">    
    <th>Username</th>
    <th>Reason</th>
    <th>Control</th>
    </tr>
  </thead>
  <tbody>';
  
while($usr = mysqli_fetch_array($query)) {	 
 
echo '<tr class="success">';
echo  '<td>' . $usr['user_name'] . '</td>';
$load_reason = mysqli_query($con,"SELECT reason FROM ban_logs WHERE user_id = '{$usr['user_id']}'");
$reason = mysqli_fetch_array($load_reason);
echo  '<td>' . $reason['reason'] . '</td>';
echo '<td><a href="admin?unbanuser=1&user=' . $usr['user_id'] . '&matcher=user_id">Unban</a> | <a href="admin?editusrdetails=1&user=' . $usr['user_id'] . '&matcher=user_id">Edit</a> | <a href="admin?deleteuser=1&user=' . $usr['user_id'] . '&matcher=user_id" onclick="return confirm(\'Are you sure that you want to delete this user?\');">Delete</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="?page=banned_users&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?page=banned_users&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;

echo '<li><a href="?page=banned_users&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';
	
} else {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Good thing! No user has been banned.
</div>';
	
}

?>

<?php } elseif($page == "memberships") { ?>

<div class="page-header">	
<h1>Account Memberships:</h1>
</div>

<?php

$query = mysqli_query($con,"SELECT * FROM account_groups ORDER BY id DESC");

echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>ID</th>
    <th>Name</th>
	<th>Control</th>
    </tr>
</thead>
<tbody>';

while($acc = mysqli_fetch_array($query)) {
	
echo '<tr class="success">';
echo  '<td>' . $acc['id']  . '</td>';	
echo  '<td>' . $acc['name'] . '</td>';	
echo  '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=memberships&delete_membership=' . $acc['id'] . '">DELETE</a> | <a href="admin_cmd?page=memberships&edit=' . $acc['id'] . '">EDIT</a></td>';
echo '</tr>';	
	
}  

echo '</tbody></table>';

echo '<br>';
echo '<br>';

if(isset($_GET['delete_membership'])) {
	
$membership = filterData($_GET['delete_membership']);

if($membership == 1) {
	
echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">X</button>
Level #1 cannot be deleted.
</div>';
	
} else {
	
mysqli_query($con,"UPDATE users SET type = 1 WHERE type = '{$membership}'");
mysqli_query($con,"DELETE FROM account_groups WHERE id = '{$membership}'");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Deleted successfully; users within this group downgraded to level 1.
</div>';	
	
}	
	
}

if(isset($_POST['submit'])) {
	
$name = filterData($_POST['name']);
$status = filterData($_POST['status']);
	
mysqli_query($con,"INSERT INTO account_groups (name,status) VALUES ('$name','$status')");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Kewl! Account membership created.
</div>';

}

elseif(isset($_GET['edit'])) {
	
$id = filterData($_GET['edit']);
$load = mysqli_query($con,"SELECT * FROM account_groups WHERE id = '{$id}'");
$load = mysqli_fetch_array($load);

if(isset($_POST['s_submit'])) {
	
$id = filterData($_POST['id']);
$name = filterData($_POST['name']);
$status = filterData($_POST['status']);
	
mysqli_query($con,"UPDATE account_groups SET name = '{$name}', status = '{$status}' WHERE id = '{$id}'");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Kewl! Account membership updated.
</div>';
	
}
	
echo '<form action="" method="post">';

echo '<input type="hidden" name="id" value="' . $id . '">';
echo '<input type="text" name="name" value="' . $load['name'] . '" class="form-control">';
echo '<br>';
echo '<select class="form-control" name="status">';
echo '<option value="1">Enabled</option>';
echo '<option value="0">Disabled (Users won\'t be able to login)</option>';
echo '</select>';
echo '<br>';
echo '<br>';
echo '<input type="submit" name="s_submit" value="Submit" class="form-control btn btn-danger">';
echo '</form>';	
	
} else {

echo '<form action="" method="post">';

echo '<input type="text" name="name" placeholder="Name of the account group" class="form-control">';
echo '<br>';
echo '<select class="form-control" name="status">';
echo '<option value="1">Enabled</option>';
echo '<option value="0">Disabled (Users won\'t be able to login)</option>';
echo '</select>';
echo '<br>';
echo '<br>';
echo '<input type="submit" name="submit" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

}

?>

<?php } elseif($page == "forums") { ?>

<div class="page-header">
<h1>Forums</h1>
</div>

<?php 

$get_forums = mysqli_query($con,"SELECT * FROM categories ORDER BY sort_lvl DESC");

if(mysqli_num_rows($get_forums) < 1) {

echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Ouch! No forum has been created.
</div>';

} else {
	
echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>Name</th>
    <th>Description</th>
	<th>Topics</th>
	<th>Posts</th>
	<th>Sort Level</th>
	<th>Delete</th>
    </tr>
  </thead>
  <tbody>';

while($forum = mysqli_fetch_array($get_forums)) {	
	
echo '<tr class="success">';
echo '<td>' . $forum['name'] . '</td>';
echo '<td>' . $forum['description'] . '</td>';
echo '<td>' . $forum['topics'] . '</td>';
echo '<td>' . $forum['posts'] . '</td>';
echo '<td>' . $forum['sort_lvl'] . '</td>';
echo '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=forums&delete_forum=' . $forum['id'] . '">Delete</a></td>';
echo '</tr>';	
	
}

echo '</tbody>
</table>';

}

if(isset($_POST['create_forum'])) {

$name = filterData($_POST['forum_name']);
$description = filterData($_POST['forum_description']);
$sort_lvl = filterData($_POST['forum_lvl']);

$find_duplicate = mysqli_query($con,"SELECT id FROM categories WHERE name = '$name'");

if($name == "") {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Forum name is left blank.
</div>';
	
}

elseif(mysqli_num_rows($find_duplicate) > 0.9) {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Forum with that name already exists.
</div>';
	
}

elseif($description == "") {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Forum description is left blank.
</div>';		
	
}

elseif($sort_lvl == "") {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Sort level is left blank.
</div>';	
	
}

elseif(is_numeric($sort_lvl) == false) {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Only integers accepted in sort level.
</div>';		
	
} else {
	
$slug = slug($name) . '-' . mt_rand(1,1000);
	
mysqli_query($con,"INSERT INTO categories (name,slug,description,topics,posts,sort_lvl) VALUES ('$name','$slug','$description','0','0','$sort_lvl')");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The forum has been created successfully.
</div>';	
	
}

}

if(isset($_GET['delete_forum'])) {
	
$id = filterData($_GET['delete_forum']);

mysqli_query($con,"DELETE FROM categories WHERE id = '$id'");
mysqli_query($con,"DELETE FROM topics WHERE topic_cat = '$id'");
mysqli_query($con,"DELETE FROM posts WHERE post_category = '$id'");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The forum has been deleted successfully.
</div>';	
	
}

?>

<form method="post" action="admin_cmd?page=forums">

<b>Forum Name:</b>
<input type="text" name="forum_name" class="form-control" placeholder="Desired forum name.">
<br>
<b>Description:</b>
<input type="text" name="forum_description" class="form-control" placeholder="Desired forum description.">
<br>
<b>Sort Level:</b>
<input type="text" name="forum_lvl" class="form-control" placeholder="7">
<br>
<br>
<input type="submit" name="create_forum" class="form-control btn btn-danger" value="Create forum">

</form>

<?php } elseif($page == "eval") { ?>

<div class="page-header">
<h1>EVAL</h1>
</div>

<?php

if($eval_enabled == 1) { ?>

<div class="alert alert-dismissable alert-danger">
EVAL IS DANGEROUS AND DISASTROUS. IT IS ADVISED TO KEEP EVAL OFF (BY EDITING THE CONFIGURATION FILE), EVAL CAN CAUSE A GREAT DAMAGE AND COMPROMISE SITE AND SERVER'S SECURITY INCASE A BAD ADMIN TAKES OVER. PLEASE USE AND ENABLE IT AT YOUR OWN RISK, THE SCRIPT AUTHOR CANNOT BE HELD RESPONSIBLE FOR THE DAMAGES.
</div>

<br>

<?php

if(isset($_POST['submit'])) {
	
eval($_POST['command']);	
	
echo '<br>';	 
echo '<br>';	

}

?>

<h4>&lt;?php</h4>
<h4>$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);</h4>

<form action="admin_cmd?page=eval" method="post">

<textarea name="command" class="form-control" rows="5">echo 'Hello world!';</textarea>

<h4>mysqli_close($con);</h4>
<h4>?&gt;</h4>

<br>

<input type="submit" class="form-control btn btn-danger" name="submit" value="Submit">

</form>

<?php } else { ?>

<div class="alert alert-dismissable alert-success">
EVAL is disabled. Keep it disabled, it's a good practise.
</div>

<?php } ?>

<?php } elseif($page == "admins") { ?>

<div class="page-header">
<h1>Administrators</h1>
</div>

<?php

$load = mysqli_query($con,"SELECT user_id,user_name,forum_posts FROM users WHERE admin_powers = 1");

if(mysqli_num_rows($load) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-success">
Whoops, no admin to show c:
</div>';
	
} else {

echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>User ID</th>
    <th>User Name</th>
	<th>Forum Posts</th>
	<th>Manage</th>
    </tr>
</thead>
<tbody>';

while($mod = mysqli_fetch_array($load)) {	
	
echo '<tr class="success">';
echo '<td>' . $mod['user_id'] . '</td>';
echo '<td>' . $mod['user_name'] . '</td>';
echo '<td>' . $mod['forum_posts'] . '</td>';
echo '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=admins&delete_mod=' . $mod['user_id'] . '">Downgrade</a></td>';
echo '</tr>';	
	
}

echo '</tbody>
</table>';

}

echo "<hr>";

if(isset($_GET['delete_mod'])) {
	
$id = filterData($_GET['delete_mod']);

mysqli_query($con,"UPDATE users SET admin_powers = 0 WHERE user_id = '{$id}' AND admin_powers = 1");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The mod has been downgraded successfully.
</div>';	
	
}

if(isset($_POST['submit_new'])) {
	
$user_name = filterData($_POST['user_name']);
	
mysqli_query($con,"UPDATE users SET admin_powers = 1 WHERE user_name = '{$user_name}' AND admin_powers = 0");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The user has been upgraded successfully.
</div>';	
	
}

echo '<br>';
echo '<br>';

echo '<form action="" method="post">';
echo '<input type="text" name="user_name" placeholder="What\'s the username you wish to upgrade to admin?" class="form-control">';
echo '<br>';
echo '<input type="submit" name="submit_new" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

?>

<?php } elseif($page == "mass_mail") { ?>

<div class="page-header">
<h1>Mass-Mail</h1>
</div>

<?php

if(isset($_POST['submit_new'])) {

$subject = $_POST['subject'];
$body = $_POST['body'];

$q = mysqli_query($con,"SELECT user_email FROM users WHERE user_verified = 1");

$x = 0;

while($queue = mysqli_fetch_array($q)) {

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
  
$mail->Subject = $subject;
$mail->SetFrom(settings("noReplyEmail"), $website_name);
$mail->SMTPDebug = false;
$mail->do_debug = 0;
$mail->MsgHTML($body);
$address = $queue['user_email'];
$mail->AddAddress($address);
$mail->Send();

$x = $x + 1;

}

echo '<div class="alert alert-dismissable alert-success">
Email sent to ' . $x . ' users!
</div>';

}

echo '<form action="" method="post">';

echo '<input type="text" name="subject" placeholder="What\'s the subject?" class="form-control">';
echo '<br>';
echo '<textarea class="form-control" name="body" placeholder="Your message to the users" rows="6"></textarea>';
echo '<br>';
echo '<input type="submit" name="submit_new" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

?>

<?php } elseif($page == "forum_mods") { ?>

<div class="page-header">
<h1>Forum Moderators</h1>
</div>

<?php

$load = mysqli_query($con,"SELECT user_id,user_name,forum_posts FROM users WHERE forum_powers = 1");

if(mysqli_num_rows($load) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-success">
Whoops, no moderator to show c:
</div>';
	
} else {

echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>User ID</th>
    <th>User Name</th>
	<th>Forum Posts</th>
	<th>Manage</th>
    </tr>
</thead>
<tbody>';

while($mod = mysqli_fetch_array($load)) {	
	
echo '<tr class="success">';
echo '<td>' . $mod['user_id'] . '</td>';
echo '<td>' . $mod['user_name'] . '</td>';
echo '<td>' . $mod['forum_posts'] . '</td>';
echo '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=forum_mods&delete_mod=' . $mod['user_id'] . '">Downgrade</a></td>';
echo '</tr>';	
	
}

echo '</tbody>
</table>';

}

echo "<hr>";

if(isset($_GET['delete_mod'])) {
	
$id = filterData($_GET['delete_mod']);

mysqli_query($con,"UPDATE users SET forum_powers = 0 WHERE user_id = '{$id}' AND forum_mod = 1");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The mod has been downgraded successfully.
</div>';	
	
}

if(isset($_POST['submit_new'])) {
	
$user_name = filterData($_POST['user_name']);
	
mysqli_query($con,"UPDATE users SET forum_powers = 1 WHERE user_name = '{$user_name}' AND forum_mod = 0");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The user has been upgraded successfully.
</div>';	
	
}

echo '<br>';
echo '<br>';

echo '<form action="" method="post">';
echo '<input type="text" name="user_name" placeholder="What\'s the username you wish to upgrade to moderator?" class="form-control">';
echo '<br>';
echo '<input type="submit" name="submit_new" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

?>

<?php } elseif($page == "roll_dice") { ?>

<div class="page-header">
<h1>Roll Dice</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM roll_wins ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 300;
$total_pages = ceil($numrows['id'] / $records);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $records;

$query = mysqli_query($con,"SELECT id,datetime,win_amount,raffle_tickets,roll_number FROM roll_wins ORDER BY id DESC LIMIT $offset, $records");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
<thead>
<tr class="success">    
<th>Time</th>
<th>Win Amount</th>
<th>Raffle Tickets</th>
<th>Roll Number</th>
<th>Manage</th>
</tr>
</thead>
<tbody>';
  
while($r = mysqli_fetch_array($query)) {	 
 
echo '<tr class="primary">';
echo  '<td>' . $r['datetime'] . '</td>';	
echo  '<td>' . $r['win_amount'] . ' BTC</td>';
echo  '<td>' . $r['raffle_tickets'] . '</td>';
echo  '<td>' . $r['roll_number'] . '</td>';
echo '<td><a href="programmer?method=show_roll_details&id=' . $r['id'] . '" target="_blank">Seeds</a> / <a href="verify?method=roll&id=' . $r['id'] . '" target="_blank">Verify</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="admin_cmd?page=roll_dice&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="admin_cmd?page=roll_dice&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="admin_cmd?page=roll_dice&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';	

} else {
	
echo 'Nothing to show. No transactions here.';
	
}

?>

<?php } elseif($page == "hi_lo") { ?>

<div class="page-header">
<h1>Hi-Lo Dice</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM dice_wins ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 300;
$total_pages = ceil($numrows['id'] / $records);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $records;

$query = mysqli_query($con,"SELECT id,datetime,bet_amt,win_amount,win,roll_number FROM dice_wins ORDER BY id DESC LIMIT $offset, $records");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
<thead>
<tr class="success">    
<th>Time</th>
<th>Roll Number</th>
<th>Bet Amount</th>
<th>Won Amount</th>
<th>Result</th>
<th>Manage</th>
</tr>
</thead>
<tbody>';
  
while($r = mysqli_fetch_array($query)) {	

$victory = "<span class='label label-danger'>Lose</span>";

if($r['win'] == 1) {
	
$victory = "<span class='label label-success'>Win</span>";
	
} 
 
echo '<tr class="primary">';
echo  '<td>' . $r['datetime'] . '</td>';	
echo  '<td>' . $r['roll_number'] . '</td>';
echo  '<td>' . $r['bet_amt'] . '</td>';
echo  '<td>' . $r['win_amount'] . '</td>';
echo  '<td>' . $victory . '</td>';
echo '<td><a href="programmer?method=show_dice_details&id=' . $r['id'] . '" target="_blank">Details</a> / <a href="verify?method=dice&id=' . $r['id'] . '" target="_blank">Verify</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="admin_cmd?page=hi_lo&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="admin_cmd?page=hi_lo&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="admin_cmd?page=hi_lo&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';	

} else {
	
echo 'Nothing to show. No transactions here.';
	
}

?>

<?php } elseif($page == "fortune") { ?>

<div class="page-header">
<h1>Fortune Hunter</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM treasure_wins ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 300;
$total_pages = ceil($numrows['id'] / $records);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $records;

$query = mysqli_query($con,"SELECT id,datetime,bet_amt,win_amount,win,roll_number FROM treasure_wins ORDER BY id DESC LIMIT $offset, $records");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
<thead>
<tr class="success">    
<th>Time</th>
<th>Roll Number</th>
<th>Bet Amount</th>
<th>Won Amount</th>
<th>Result</th>
<th>Manage</th>
</tr>
</thead>
<tbody>';
  
while($r = mysqli_fetch_array($query)) {	

$victory = "<span class='label label-danger'>Lose</span>";

if($r['win'] == 1) {
	
$victory = "<span class='label label-success'>Win</span>";
	
} 
 
echo '<tr class="primary">';
echo  '<td>' . $r['datetime'] . '</td>';	
echo  '<td>' . $r['roll_number'] . '</td>';
echo  '<td>' . $r['bet_amt'] . '</td>';
echo  '<td>' . $r['win_amount'] . '</td>';
echo  '<td>' . $victory . '</td>';
echo '<td><a href="programmer?method=show_hunt_details&id=' . $r['id'] . '" target="_blank">Details</a> / <a href="verify?method=hunt&id=' . $r['id'] . '" target="_blank">Verify</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="admin_cmd?page=hi_lo&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="admin_cmd?page=hi_lo&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="admin_cmd?page=hi_lo&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';	

} else {
	
echo 'Nothing to show. No transactions here.';
	
}

?>

<?php } elseif($page == "withdrawals") { ?>

<div class="page-header">
<h1>Withdrawal</h1>

<a href="admin_cmd?page=withdrawals&status=0">Pending</a> | <a href="admin_cmd?page=withdrawals&status=1">Paid</a> | <a href="admin_cmd?page=withdrawals&status=2">Rejected</a>

<br>

<?php

$iii = 0;

$load = mysqli_query($con,"SELECT amount FROM withdrawals WHERE status = 0");

while($x = mysqli_fetch_array($load)) {
	
$iii = $iii + $x['amount'];
	
}

$iii = sprintf("%.8f",$iii);

?>

Pending Payments: <?php echo $iii; ?> BTC.

<a href="admin_cmd?page=withdrawals&pay_all=1" class="btn btn-sm btn-success pull-right">Pay All</a>

</div>

<?php

$status = 0;

if(isset($_GET['status'])) {
	
$status = filterData($_GET['status']);
	
}

$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM withdrawals WHERE status = '{$status}' ORDER BY date DESC");
$numrows = mysqli_fetch_array($rc);

$refs = 300;
$total_pages = ceil($numrows['id'] / $refs);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $refs;

if(isset($_GET['pending'])) {
	
$id = filterData($_GET['pending']);

mysqli_query($con,"UPDATE withdrawals SET status = 0 WHERE id = '{$id}'");
	
echo '<div class="alert alert-dismissable alert-success">
Marked as pending.
</div>';	
	
} elseif(isset($_GET['reject'])) {
	
$id = filterData($_GET['reject']);

$load = mysqli_fetch_array(mysqli_query($con,"SELECT user_id FROM withdrawals WHERE id = '{$id}'"));
$email = loadAccDetails("user_id",$load['user_id'],"user_email");

$body = "Hello,

<br>
<br>

The administrator has rejected your withdrawal. Contact us to know why.

<br>
<br>
Regards,
<br>
{$website_name}";

sendMail($email,"Your withdrawal has been rejected",$body);

mysqli_query($con,"UPDATE withdrawals SET status = 2 WHERE id = '{$id}'");
	
echo '<div class="alert alert-dismissable alert-success">
Marked as rejected.
</div>';	
	
} elseif(isset($_GET['paid'])) {
	
$id = filterData($_GET['paid']);

mysqli_query($con,"UPDATE withdrawals SET status = 1 WHERE id = '{$id}'");
	
echo '<div class="alert alert-dismissable alert-success">
Marked as paid.
</div>';	
	
} elseif(isset($_GET['pay'])) {
	
$id = filterData($_GET['pay']);

$load = mysqli_fetch_array(mysqli_query($con,"SELECT amount,address FROM withdrawals WHERE id = '{$id}'"));
$balance = $load['amount'];
$address = $load['address'];

$btc_amt = $balance;
$error = false;

$request = coinpayments_api_call("create_withdrawal",array("currency" => "btc", "amount" => $btc_amt, "address" => $address, "auto_confirm" => 1));	

if($request['error'] != "ok") {

$core_system_messages[] = 'There was an issue processing your withdrawal.';
$error = true;
	
}

if($error == false) {
	
mysqli_query($con,"UPDATE withdrawals SET status = 1 WHERE id = '{$id}'");
	
echo '<div class="alert alert-success">
The withdrawal has been successfully. The transaction would soon be reflected in blockchain.
</div>';

} else {
	
echo '<div class="alert alert-danger">
The payout has failed.
</div>';

}	
	
} elseif(isset($_GET['pay_all'])) {
	
$load = mysqli_query($con,"SELECT id,amount,address FROM withdrawals WHERE status = 0 ORDER BY id ASC");

$ss = 0;
$ff = 0;

while($q = mysqli_fetch_array($load)) {

$balance = $q['amount'];
$address = $q['address'];
	
$btc_amt = $balance;
$error = false;

$request = coinpayments_api_call("create_withdrawal",array("currency" => "btc", "amount" => $btc_amt, "address" => $address, "auto_confirm" => 1));	

if($request['error'] != "ok") {

$core_system_messages[] = 'There was an issue processing your withdrawal.';
$error = true;
	
}

if($error == false) {
	
mysqli_query($con,"UPDATE withdrawals SET status = 1 WHERE id = '{$q['id']}'");
	
$ss = $ss + 1;	

} else {

$ff = $ff + 1;	

}	
	
}

echo '<div class="alert alert-success">
Paid: ' . $ss . ' withdrawals successfully, while as ' . $ff . ' withdrawals failed. 
</div>';

}

$query = mysqli_query($con,"SELECT * FROM withdrawals WHERE status = '{$status}' ORDER BY date DESC LIMIT $offset, $refs");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">    
    <th>User</th>
    <th>Date</th>
    <th>Amount</th>
    <th>Address</th>
    <th>Control</th>
    </tr>
  </thead>
  <tbody>';
  
while($usr = mysqli_fetch_array($query)) {	 
 
echo '<tr class="success">';
echo  '<td>' . $usr['user_id'] . ' / ' . loadAccDetails("user_id",$usr['user_id'],"user_name") . '</td>';	
echo  '<td>' . $usr['date'] . '</td>';
echo  '<td>' . $usr['amount'] . '</td>';
echo  '<td>' . $usr['address'] . '</td>';
if($status == 0) {
echo  '<td><b><a href="admin_cmd?page=withdrawals&status=' . $status . '&offset=' . $req_page . '&pay=' . $usr['id'] . '">Pay</a></b> | <b><a href="admin_cmd?page=withdrawals&status=' . $status . '&offset=' . $req_page . '&reject=' . $usr['id'] . '">Move to Rejected</a></b> | <b><a href="admin_cmd?page=withdrawals&status=' . $status . '&offset=' . $req_page . '&paid=' . $usr['id'] . '">Move to Paid</a></b></td>';	
} elseif($status == 2) {
echo  '<td><b><a href="admin_cmd?page=withdrawals&status=' . $status . '&offset=' . $req_page . '&pending=' . $usr['id'] . '">Move to Pending</a></b> | <b><a href="admin_cmd?page=withdrawals&status=' . $status . '&offset=' . $req_page . '&paid=' . $usr['id'] . '">Move to Paid</a></b></td>';	
} else {
echo  '<td>-</td>';	
}
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
	$prev = $req_page - 1;
  echo '<li><a href="?page=withdrawals&status=' . $status . '&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?page=withdrawals&status=' . $status . '&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;

echo '<li><a href="?page=withdrawals&status=' . $status . '&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';
	
} else {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
No withdrawals found.
</div>';
	
}

?>

<?php } elseif($page == "deposits") { ?>

<div class="page-header">
<h1>Deposits</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM deposits ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 300;
$total_pages = ceil($numrows['id'] / $records);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $records;

$query = mysqli_query($con,"SELECT * FROM deposits ORDER BY id DESC LIMIT $offset, $records");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
<thead>
<tr class="success">    
<th>ID</th>
<th>User ID</th>
<th>User Name</th>
<th>Amount</th>
</tr>
</thead>
<tbody>';
  
while($r = mysqli_fetch_array($query)) {	

echo '<tr class="primary">';
echo  '<td>' . $r['id'] . '</td>';	
echo  '<td>' . $r['user_id'] . '</td>';
echo  '<td>' . loadAccDetails("user_id",$r['user_id'],"user_name") . '</td>';
echo  '<td>' . $r['amount'] . ' BTC</td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="admin_cmd?page=deposits&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="admin_cmd?page=deposits&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="admin_cmd?page=deposits&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';	

} else {
	
echo 'Nothing to show. No deposits here.';
	
}

?>

<?php } elseif($page == "news") { ?>

<div class="page-header">
<h1>News</h1>
</div>

<?php

if(isset($_GET['delete'])) {
	
$delete = filterData(intval($_GET['delete']));

mysqli_query($con,"DELETE FROM news WHERE id = '{$delete}'");	

echo '<div class="alert alert-info">
Deleted successfully.
</div>';	
	
}

$news = mysqli_query($con,"SELECT id,title,published FROM news ORDER BY published DESC LIMIT 60");

if(mysqli_num_rows($news) < 0.99) {
	
echo '<div class="alert alert-info">
There are no news articles to show.
</div>';
	
} else {
	
echo '<table class="table table-striped table-hover">
<thead>
<tr class="danger">    
<th>#</th>
<th>Title</th>
<th>Date</th>
<th>Control</th>
</tr>
</thead>
<tbody>';

while($usr = mysqli_fetch_array($news)) {	 
 
echo '<tr class="success">';
echo  '<td>' . $usr['id'] . '</td>';	
echo  '<td>' . $usr['title'] . '</td>';
echo  '<td>' . $usr['published'] . '</td>';
echo '<td><a href="?page=news&delete=' . $usr['id'] . '">Delete</a> | <a href="?page=news&edit=' . $usr['id'] . '">Edit</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';
	
}

echo '<br>';

if(isset($_GET['edit'])) {
	
$edit = filterData(intval($_GET['edit']));

$load = mysqli_query($con,"SELECT title,content FROM news WHERE id = '{$edit}'");
$edit = mysqli_fetch_array($load);

$no_load = true;

if(isset($_POST['updatenews'])) {
	
$title = filterData($_POST['title']);
$content = nl2br(filterData($_POST['content']));

if($title == "" OR $content == "") {
	
echo '<div class="alert alert-info">
Title or content is blank.
</div>';
	
} else {
	
mysqli_query($con,"UPDATE news SET title = '{$title}', content = '{$content}' WHERE id = '{$edit}'");
	
echo '<div class="alert alert-success">
Updated successfully.
</div>';
	
}	
	
}

echo '<form action="" method="post">

<div class="form-group">
<label class="control-label">Title</label>
<input type="text" name="title" class="form-control" value="' . $edit['title'] . '">
</div>

<div class="form-group">
<label class="control-label">Content</label>
<textarea name="content" class="form-control">' . $edit['content'] . '</textarea>
</div>

<input type="submit" value="Update News" name="updatenews" class="btn btn-success btn-lg">

</form>';
	
}

if(isset($_POST['submit'])) {
	
$title = filterData($_POST['title']);
$content = nl2br(filterData($_POST['content']));

if($title == "" OR $content == "") {
	
echo '<div class="alert alert-info">
Title or content is blank.
</div>';
	
} else {
	
mysqli_query($con,"INSERT INTO news (title,content,published) VALUES ('{$title}','{$content}','" . date("Y-m-d") . "')");
	
echo '<div class="alert alert-success">
Published successfully.
</div>';
	
}
	
}

if(!isset($no_load)) {

echo '<h3>Add a News Article:</h3>';

echo '<form action="" method="post">

<div class="form-group">
<label class="control-label">Title</label>
<input type="text" name="title" class="form-control">
</div>

<div class="form-group">
<label class="control-label">Content</label>
<textarea name="content" class="form-control"></textarea>
</div>

<input type="submit" value="Submit" name="submit" class="btn btn-success btn-lg">

</form>';

}

?>

<?php } ?>

</div>

<br>
<br>