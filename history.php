<section id="form-page">

<div class="container">

<div class="row">

<div class="col-md-12" >
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<span style="font-size:58px;"><b>History</b></span>

<br>
<br>

<?php

$id = intval($_GET['id']);

if($id == 1) {
	
$load = mysqli_query($con,"SELECT * FROM withdrawals WHERE user_id = '{$_SESSION['user_id']}' ORDER BY id DESC LIMIT 60");

if(mysqli_num_rows($load) < 0.99) {
	
echo '<div class="alert alert-info">
There are no withdrawals to show.
</div>';
	
} else {
	
echo '<table class="table table-striped table-hover">
<thead>
<tr class="danger">
<th>Date</th>
<th>Amount</th>
<th>Address</th>
<th>Status</th>
</tr>
</thead>
<tbody>';

while($q = mysqli_fetch_array($load)) {
	
echo '<tr class="success">';
echo '<td>' . $q['date'] . '</td>';	
echo '<td>' . $q['amount'] . '</td>';	
echo '<td>' . $q['address'] . '</td>';	
if($q['status'] == 1) {
echo '<td><span class="label label-success">Paid</span></td>';	
} elseif($q['status'] == 0) {
echo '<td><span class="label label-info">Pending</span></td>';	
} else {
echo '<td><span class="label label-danger">Rejected</span></td>';	
}
	
}	
	
echo '</tbody>
</table>';		
	
}	
	
} elseif($id == 2) {
	
$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM roll_wins WHERE user_id = {$_SESSION['user_id']} ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 50;
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

$query = mysqli_query($con,"SELECT id,datetime,win_amount,raffle_tickets,roll_number FROM roll_wins WHERE user_id = {$_SESSION['user_id']} ORDER BY id DESC LIMIT $offset, $records");

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
echo '<li><a href="?id=2&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?id=2&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="?id=2&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';	

}
	
} elseif($id == 3) {
	
$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM dice_wins WHERE user_id = {$_SESSION['user_id']} ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 50;
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

$query = mysqli_query($con,"SELECT id,datetime,bet_amt,win_amount,win,roll_number FROM dice_wins WHERE user_id = {$_SESSION['user_id']} ORDER BY id DESC LIMIT $offset, $records");

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
echo '<li><a href="?id=3&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?id=3&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="?id=3&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';	

}
	
} elseif($id == 4) {
	
$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM round_winners ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 1;
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

$query = mysqli_query($con,"SELECT * FROM round_winners ORDER BY id DESC LIMIT $offset, $records");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<div class="col-md-6 center-block" style="float:none;">';

$r = mysqli_fetch_array($query);

echo '<b>Round #' . $r['round_id'] . "</b>";

echo '<br>';

echo '<b>Total Tickets: ' . $r['total_tickets'] . "</b>";

echo '<br>';
echo '<br>';

echo '<table class="table table-striped table-hover">
<thead>
<tr class="success">    
<th>Rank</th>
<th>User</th>
<th>Amount Won</th>
<th>User Tickets</th>
</tr>
</thead>
<tbody>';  

echo '<tr class="primary">';
echo  '<td>First</td>';
echo  '<td>' . loadAccDetails("user_id",$r['first_user'],"user_name") . '</td>';
echo  '<td>' . $r['first_user_amount'] . '</td>';
echo  '<td>' . $r['first_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Second</td>';
echo  '<td>' . loadAccDetails("user_id",$r['second_user'],"user_name") . '</td>';
echo  '<td>' . $r['second_user_amount'] . '</td>';
echo  '<td>' . $r['second_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Third</td>';
echo  '<td>' . loadAccDetails("user_id",$r['third_user'],"user_name") . '</td>';
echo  '<td>' . $r['third_user_amount'] . '</td>';
echo  '<td>' . $r['third_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Fourth</td>';
echo  '<td>' . loadAccDetails("user_id",$r['fourth_user'],"user_name") . '</td>';
echo  '<td>' . $r['fourth_user_amount'] . '</td>';
echo  '<td>' . $r['fourth_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Fifth</td>';
echo  '<td>' . loadAccDetails("user_id",$r['fifth_user'],"user_name") . '</td>';
echo  '<td>' . $r['fifth_user_amount'] . '</td>';
echo  '<td>' . $r['fifth_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Sixth</td>';
echo  '<td>' . loadAccDetails("user_id",$r['sixth_user'],"user_name") . '</td>';
echo  '<td>' . $r['sixth_user_amount'] . '</td>';
echo  '<td>' . $r['sixth_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Seventh</td>';
echo  '<td>' . loadAccDetails("user_id",$r['seventh_user'],"user_name") . '</td>';
echo  '<td>' . $r['seventh_user_amount'] . '</td>';
echo  '<td>' . $r['seventh_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Eighth</td>';
echo  '<td>' . loadAccDetails("user_id",$r['eighth_user'],"user_name") . '</td>';
echo  '<td>' . $r['eighth_user_amount'] . '</td>';
echo  '<td>' . $r['eighth_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Nineth</td>';
echo  '<td>' . loadAccDetails("user_id",$r['nineth_user'],"user_name") . '</td>';
echo  '<td>' . $r['nineth_user_amount'] . '</td>';
echo  '<td>' . $r['nineth_user_tickets'] . '</td>';
echo '</tr>';

echo '<tr class="primary">';
echo  '<td>Tenth</td>';
echo  '<td>' . loadAccDetails("user_id",$r['tenth_user'],"user_name") . '</td>';
echo  '<td>' . $r['tenth_user_amount'] . '</td>';
echo  '<td>' . $r['tenth_user_tickets'] . '</td>';
echo '</tr>';
  
echo '</tbody>
</table>
</div>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="?id=4&offset=' . $prev . '">New Round</a></li>';
}

echo '<li class="disabled active"><a href="?id=4&offset=' . $req_page . '">Current Round</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="?id=4&offset=' . $next . '">Old Round</a></li>';

}
  
echo '</ul></div>';	

}
	
} elseif($id == 5) {
	

	
$rc = mysqli_query($con,"SELECT COUNT(id) AS id FROM dice_wins WHERE user_id = {$_SESSION['user_id']} ORDER BY id DESC");
$numrows = mysqli_fetch_array($rc);

$records = 50;
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

$query = mysqli_query($con,"SELECT id,datetime,bet_amt,win_amount,win,roll_number FROM treasure_wins WHERE user_id = {$_SESSION['user_id']} ORDER BY id DESC LIMIT $offset, $records");

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
echo '<li><a href="?id=5&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?id=5&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;
echo '<li><a href="?id=5&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';	

}	
	
}

?>


</div>
</div>
</div>


</div>
</div>
</section>