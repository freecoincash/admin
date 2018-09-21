<section id="admin-page">

<div class="container">
<div id="duh">
<div align="center">
<h1><?php echo $website_name; ?>: Admin CP</h1>
<big>Maintain your website, keep a check on users and everything else from one single place.</big>
<hr>
</div>

<div align="center">

<div class="btn btn-group-justified">
<a href="admin_cmd?page=settings" class="btn btn-success"><b>Settings</b></a>
<a href="admin_cmd?page=all_users" class="btn btn-success"><b>All Users</b></a>
<a href="admin_cmd?page=banned_users" class="btn btn-success"><b>Banned Users</b></a>
</div>

<div class="btn btn-group-justified">
<a href="admin_cmd?page=memberships" class="btn btn-success"><b>Account Memberships</b></a>
<a href="admin_cmd?page=forums" class="btn btn-success"><b>Forums</b></a>
<a href="admin_cmd?page=forum_mods" class="btn btn-success"><b>Forum Moderators</b></a>
<a href="admin_cmd?page=news" class="btn btn-success"><b>News</b></a>
</div>

<div class="btn btn-group-justified">
<a href="admin_cmd?page=deposits" class="btn btn-success"><b>Deposits</b></a>
<a href="admin_cmd?page=withdrawals" class="btn btn-success"><b>Withdrawals</b></a>
</div>

<div class="btn btn-group-justified">
<a href="admin_cmd?page=roll_dice" class="btn btn-success"><b>Roll Dice</b></a>
<a href="admin_cmd?page=hi_lo" class="btn btn-success"><b>Hi-Lo Dice</b></a>
<a href="admin_cmd?page=fortune" class="btn btn-success"><b>Fortune Hunters</b></a>
</div>

<div class="btn btn-group-justified">
<a href="admin?optimize_database" class="btn btn-success"><b>Optimize Database</b></a>
<a href="admin?backup_database" class="btn btn-success"><b>Backup Database</b></a>
<a href="admin_cmd?page=eval" class="btn btn-success"><b>EVAL (Command Execution)</b></a>
<a href="admin?clear_chat" class="btn btn-success"><b>Clear Chat</b></a>
</div>

<div class="btn btn-group-justified">
<a href="admin_cmd?page=admins" class="btn btn-success"><b>Administrators</b></a>
<a href="admin_cmd?page=admins" class="btn btn-success"><b>Add an Administrator</b></a>
<a href="admin_cmd?page=mass_mail" class="btn btn-success"><b>Mass-Mail</b></a>
</div>

</div>

<br>

<?php

$balance = 0;

$request = coinpayments_api_call("balances",array());	
$balance = $request['result']['BTC']['balancef'];

echo '<font size="5">Confirmed (Wallet) Balance: <b>' . $balance . ' BTC</b></font>';

echo '<br>';
echo '<br>';

?>

<br>

<?php

if(isset($_GET['optimize_database'])) {
	
$alltables = mysqli_query($con,"SHOW TABLES");

while($table = mysqli_fetch_array($alltables)) {
foreach ($table as $db => $tablename) {
mysqli_query($con,"OPTIMIZE TABLE '$tablename'");
} 
}

echo '<div class="alert alert-dismissable alert-success">
Great! The database has been optimized.
</div>';	

} elseif(isset($_GET['clear_chat'])) {
	
mysqli_query($con,"TRUNCATE chat");
mysqli_query($con,"OPTIMIZE TABLE chat");
mysqli_query($con,"ALTER TABLE chat ENGINE=INNODB");

mysqli_query($con,"INSERT INTO chat (user,date,message) VALUES ('<span style=\'color:#2780e3\'>SERVER (BOT)</span>', '" . date("Y-m-d H:i:s") . "','The chat has been cleared.')");

echo '<div class="alert alert-dismissable alert-success">
Great! The chat has been cleared.
</div>';	
	
} elseif(isset($_GET['backup_database'])) {

$return = "";
$tables = "*";

	if($tables == '*')
	{
		$tables = array();
		$result = mysqli_query($con,'SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysqli_query($con,'SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		$return.= 'DROP TABLE IF EXISTS '.$table.';';
		$row2 = mysqli_fetch_row(mysqli_query($con,'SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}

$handle = fopen('backups/backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
fwrite($handle,$return);
fclose($handle);

echo '<div class="alert alert-dismissable alert-success">
<button type="button" class="close" data-dismiss="alert">X</button>
Great! The database has been backed up to <b>backups</b> folder.
</div>';	

} elseif(isset($_GET['fetchusrdetails'])) {
	
$input = filterData($_GET['user']);
$matcher = filterData($_GET['matcher']);

$matcher_array = array("user_name","user_id");
	
if($input == "") {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Input field is blank.
</div>';	
	
} elseif(in_array($matcher,$matcher_array) == FALSE) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Invalid match settings. Ah.
</div>';
	
} else {

if($matcher == "user_name") {
$user_query = mysqli_query($con,"SELECT * FROM users WHERE user_name = '{$input}' LIMIT 1");
} else {
$user_query = mysqli_query($con,"SELECT * FROM users WHERE user_id = '{$input}' LIMIT 1");	
}

if(mysqli_num_rows($user_query) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
No user found. Take a look at the inputs.
</div>';
	
} else {

$user_details = mysqli_fetch_array($user_query);

echo '<table class="table table-striped table-hover">';

echo '<tr class="success">
<td>User ID</td>
<td>' . $user_details['user_id'] . '</td>
</tr>';

echo '<tr class="success">
<td>User Name</td>
<td>' . $user_details['user_name'] . '</td>
</tr>';

echo '<tr class="success">
<td>Email</td>
<td>' . $user_details['user_email'] . '</td>
</tr>';

echo '<tr class="success">
<td>Registration Date</td>
<td>' . $user_details['registration_datetime'] . '</td>
</tr>';

echo '<tr class="success">
<td>Registration IP</td>
<td>' . $user_details['registration_ip'] . '</td>
</tr>';

echo '<tr class="success">
<td>Last Login</td>
<td>' . $user_details['last_logged_in'] . '</td>
</tr>';

echo '<tr class="success">
<td>Account Group</td>
<td>' . accountGroup($user_details['account_group'],"name") . '</td>
</tr>';	

echo '<tr class="success">
<td>Admin Powers</td>';
if($user_details['admin_powers'] == 1) {
echo '<td>Yes</td>';
} else {
echo '<td>No</td>';
}
echo '</tr>';

echo '<tr class="success">
<td>Avatar URL</td>';
echo '<td>' . $user_details['avatar_url'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Forum Posts</td>';
echo '<td>' . $user_details['forum_posts'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Account Status</td>';
if($user_details['account_status'] == 1) {
echo '<td>Active</td>';
} else {
echo '<td>Inactive</td>';
}
echo '</tr>';

echo '<tr class="success">
<td>Last Claim (Faucet)</td>';
echo '<td>' . $user_details['last_claim_faucet'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Last Claim (Faucet)</td>';
echo '<td>' . $user_details['last_claim_roll'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Balance</td>';
echo '<td>' . $user_details['balance'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Total Earned (from referrals)</td>';
echo '<td>' . $user_details['total_referred'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Bitcoin Address (Withdrawals)</td>';
echo '<td>' . $user_details['last_used_wallet'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Bitcoin Address (Deposits)</td>';
echo '<td>' . $user_details['deposit_address'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Raffle Tickets</td>';
echo '<td>' . $user_details['raffle_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>API Queries Today</td>';
echo '<td>' . $user_details['api_queries_today'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Referral</td>';
echo '<td>' . $user_details['referral'] . '</td>';
echo '</tr>';

echo '<tr class="success">
<td>Control</td>
<td><a href="admin?editusrdetails=1&user=' . $user_details['user_id'] . '&matcher=user_id">Edit</a> | <a href="admin?deleteuser=1&user=' . $user_details['user_id'] . '&matcher=user_id" onclick="return confirm(\'Are you sure that you want to delete this user?\');">Delete</a></td>
</tr>';

echo '</table>';
	
}

}
	
} elseif(isset($_GET['editusrdetails'])) {
	
$input = filterData($_GET['user']);
$matcher = filterData($_GET['matcher']);

$matcher_array = array("user_name","user_id");

if($input == "") {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Input field is blank.
</div>';	
	
} elseif(in_array($matcher,$matcher_array) == FALSE) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Invalid match settings. Ah.
</div>';
	
} else {

if($matcher == "user_name") {
$user_query = mysqli_query($con,"SELECT * FROM users WHERE user_name = '{$input}' LIMIT 1");
} else {
$user_query = mysqli_query($con,"SELECT * FROM users WHERE user_id = '{$input}' LIMIT 1");	
}

if(mysqli_num_rows($user_query) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
No user found. Take a look at the inputs.
</div>';
	
} else {

$user_details = mysqli_fetch_array($user_query);

echo '<form action="admin" method="post">';

echo '<input type="hidden" name="user_id" class="form-control" value="' . $user_details['user_id'] . '">';
echo '<b>User Name:</b>
<input type="text" name="user_name" class="form-control" value="' . $user_details['user_name'] . '">';
echo '<br>';
echo '<b>User Email:</b>
<input type="text" name="user_email" class="form-control" value="' . $user_details['user_email'] . '">';
echo '<br>';
echo '<b>User Active (Email Confirmation):</b>
<input type="text" name="user_verified" class="form-control" value="' . $user_details['user_verified'] . '">';
echo '<br>';
echo '<b>Account Membership:</b>';
$load_memberships = mysqli_query($con,"SELECT * FROM account_groups ORDER BY id DESC");
echo '<select name="type" class="form-control">';
while($membership = mysqli_fetch_array($load_memberships)) {

$status = "Disabled";

if($membership['status'] == 1) {	
$status = "Enabled";	
}

if($user_details['account_group'] == $membership['id']) {
echo '<option value="' . $membership['id'] . '" selected>' . $membership['name'] . ' | ' . $status . '</option>';
} else {
echo '<option value="' . $membership['id'] . '">' . $membership['name'] . ' | ' . $status . '</option>';
}

}
echo '</select>';
echo '<br>';
echo '<b>Avatar URL:</b>
<input type="text" name="avatar_url" class="form-control" value="' . $user_details['avatar_url'] . '">';
echo '<br>';
echo '<b>Forum Posts:</b>
<input type="text" name="forum_posts" class="form-control" value="' . $user_details['forum_posts'] . '">';
echo '<br>';
echo '<b>Balance:</b>
<input type="text" name="balance" class="form-control" value="' . $user_details['balance'] . '">';
echo '<br>';
echo '<b>Referral:</b>
<input type="text" name="referral" class="form-control" value="' . $user_details['referral'] . '">';
echo '<br>';
echo '<b>Raffle Tickets:</b>
<input type="text" name="raffle_tickets" class="form-control" value="' . $user_details['raffle_tickets'] . '">';
echo '<br>';
echo '<input type="submit" name="submit_change" class="form-control btn btn-danger" value="Confirm">';
echo '</form>';

}

}

} elseif(isset($_GET['unbanuser'])) {
	
$input = filterData($_GET['user']);
$matcher = filterData($_GET['matcher']);
$reason = filterData($_GET['reason']);

$matcher_array = array("user_name","user_id");

if($input == "") {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Input field is blank.
</div>';	
	
} elseif(in_array($matcher,$matcher_array) == FALSE) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Invalid match settings. Ah.
</div>';
	
} else {

if($matcher == "user_name") {
$user_query = mysqli_query($con,"SELECT user_id, user_name, account_status FROM users WHERE user_name = '{$input}' LIMIT 1");
} else {
$user_query = mysqli_query($con,"SELECT user_id, user_name, account_status FROM users WHERE user_id = '{$input}' LIMIT 1");	
}

if(mysqli_num_rows($user_query) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
No user found. Take a look at the inputs.
</div>';
	
} else {

$user_details = mysqli_fetch_array($user_query);

if($reason == "") {
$reason = "Admin has not specified any reason for this ban.";
}

if($user_details['account_status'] == 1) {
	
mysqli_query($con,"UPDATE users SET account_status = 0, rememberme_token = null WHERE user_id = '{$user_details['user_id']}'");
mysqli_query($con,"INSERT INTO ban_logs (user_id,reason) VALUES ('{$user_details['user_id']}','$reason')");

echo '<div class="alert alert-dismissable alert-success">
<button type="button" class="close" data-dismiss="alert">X</button>
User banned successfully.
</div>';
	
} else {
	
mysqli_query($con,"UPDATE users SET account_status = 1 WHERE user_id = '{$user_details['user_id']}'");
mysqli_query($con,"DELETE FROM ban_logs WHERE user_id = '{$user_details['user_id']}'");

echo '<div class="alert alert-dismissable alert-success">
<button type="button" class="close" data-dismiss="alert">X</button>
User unbanned successfully.
</div>';
	
}

}

}

} elseif(isset($_GET['deleteuser'])) {
	
$input = filterData($_GET['user']);
$matcher = filterData($_GET['matcher']);

$matcher_array = array("user_name","user_id");

if($input == "") {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Input field is blank.
</div>';	
	
} elseif(in_array($matcher,$matcher_array) == FALSE) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
Invalid match settings. Ah.
</div>';
	
} else {

if($matcher == "user_name") {
$user_query = mysqli_query($con,"SELECT user_id, user_name FROM users WHERE user_name = '{$input}' LIMIT 1");
} else {
$user_query = mysqli_query($con,"SELECT user_id, user_name FROM users WHERE user_id = '{$input}' LIMIT 1");	
}

if(mysqli_num_rows($user_query) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">X</button>
No user found. Take a look at the inputs.
</div>';
	
} else {

$user_details = mysqli_fetch_array($user_query);

mysqli_query($con,"DELETE FROM users WHERE user_id = '{$user_details['user_id']}'");

echo '<div class="alert alert-dismissable alert-success">
<button type="button" class="close" data-dismiss="alert">X</button>
User has been deleted successfully.
</div>';

}

}

} elseif(isset($_POST['submit_change'])) {
	
$user_id = filterData($_POST['user_id']);
$user_name = filterData($_POST['user_name']);
$user_email = filterData($_POST['user_email']);
$user_verified = filterData($_POST['user_verified']);
$type = filterData($_POST['type']);
$avatar_url = filterData($_POST['avatar_url']);
$forum_posts = filterData($_POST['forum_posts']);
$balance = filterData($_POST['balance']);
$referral = filterData($_POST['referral']);
$raffle_tickets = filterData($_POST['raffle_tickets']);
	
mysqli_query($con,"UPDATE users SET user_name = '$user_name', user_email = '$user_email', user_verified = '{$user_verified}', account_group = '$type', avatar_url = '$avatar_url', forum_posts = '{$forum_posts}', balance = '{$balance}', referral = '{$referral}', raffle_tickets = {$raffle_tickets} WHERE user_id = '$user_id'");

echo '<div class="alert alert-dismissable alert-success">
<button type="button" class="close" data-dismiss="alert">X</button>
User has been updated.
</div>';

}

?>

<br>
<br>

<h3>Load User Details:</h3>

<form method="get" action="admin">

<b>Input Query:</b>
<input type="text" name="user" class="form-control" placeholder="Will be used for finding the user.">
<br>
<b>What's that?:</b>
<select name="matcher" class="form-control">
<option value="user_name">A User Name</option>
<option value="user_id">A User ID</option>
</select>
<br>
<input type="submit" name="fetchusrdetails" class=" btn btn-primary" value="Find and Display">

</form>

<hr>

<h3>Edit a User:</h3>

<form method="get" action="admin">

<b>Input Query:</b>
<input type="text" name="user" class="form-control" placeholder="Will be used for finding the user.">
<br>
<b>What's that?:</b>
<select name="matcher" class="form-control">
<option value="user_name">A User Name</option>
<option value="user_id">A User ID</option>
</select>
<br>
<input type="submit" name="editusrdetails" class="btn btn-primary" value="Find and Edit">

</form>

<hr>

<h3>Ban/Unban User:</h3>

<form method="get" action="admin" onsubmit="return confirm('Are you sure that you want to ban/unban this user?');">

<b>Input Query:</b>
<input type="text" name="user" class="form-control" placeholder="Will be used for finding the user (User will be unbanned if already banned).">
<br>
<b>What's that?:</b>
<select name="matcher" class="form-control">
<option value="user_name">A User Name</option>
<option value="user_id">A User ID</option>
</select>
<br>
<b>Reason:</b>
<input type="text" name="reason" class="form-control" placeholder="What is the reason of this ban?">
<br>
<input type="submit" name="unbanuser" class=" btn btn-primary" value="Ban/Unban User">

</form>

<hr>

<h3>Delete a User:</h3>

<form method="get" action="admin" onsubmit="return confirm('Are you sure that you want to delete this user?');">

<b>Input Query:</b>
<input type="text" name="user" class="form-control" placeholder="Will be used for finding the user.">
<br>
<b>What's that?:</b>
<select name="matcher" class="form-control">
<option value="user_name">A User Name</option>
<option value="user_id">A User ID</option>
</select>
<br>
<input type="submit" name="deleteuser" class=" btn btn-primary" value="Delete User">

</form>

</div> 
</div>
</section>