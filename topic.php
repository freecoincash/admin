<section id="forum-page">
<div class="container">
<div id="duh">
<div class="page-header">
<h1><a href="forums">Forums</a></h1>
</div>

<?php

$slug = filterData($_GET['slug']);

$fetch_data = mysqli_query($con,"SELECT * FROM topics WHERE topic_slug = '{$slug}' LIMIT 1");

$data = mysqli_fetch_array($fetch_data);

if(ifRead($data['topic_id'],$_SESSION['user_id']) == "New") {
	
mysqli_query($con,"INSERT INTO read_history (topic_id,user_id) VALUES ('{$data['topic_id']}','{$_SESSION['user_id']}')");
mysqli_query($con,"UPDATE topics SET topic_views = topic_views + 1 WHERE topic_slug = '{$slug}'");
	
}

$rc = mysqli_query($con,"SELECT COUNT(post_id) AS id FROM posts WHERE post_topic = {$data['topic_id']}");
$numrows = mysqli_fetch_array($rc);

$posts = 30;
$total_pages = ceil($numrows['id'] / $posts);

if(isset($_GET['page']) && is_numeric($_GET['page'])) {
$req_page = (int) ($_GET['page']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $posts;

$fetch_posts = mysqli_query($con,"SELECT post_id,post_date,post_by,post_content FROM posts WHERE post_topic = '{$data['topic_id']}' ORDER BY post_id DESC LIMIT $offset, $posts");

echo '<table class="table table-striped table-hover">
<thead>
<tr class="danger">
<th>Author</th>
<th>Topic: ' . $data['topic_name'] . '</th>
</tr>
</thead>
<tbody>';  
  
echo '<tr class="success">
<td>';

$url = loadAvatar($data['topic_by']);

echo '<img src="' . $url . '" height="80" width="80">';

echo '<br>';

echo '<b>' . loadAccDetails("user_id",$data['topic_by'],"user_name") . '</b>
<br>
<br>
Posts: ' . loadAccDetails("user_id",$data['topic_by'],"forum_posts") . '
</td>

<td>on <b>' . readableDate($data['topic_date']) . '</b> by <b>'. loadAccDetails("user_id",$data['topic_by'],"user_name") . '</b>
<br>
<br>' . nl2br($data['topic_content']);

if(checkAdmin() == TRUE OR checkAdmin() == TRUE OR $data['topic_by'] == $_SESSION['user_id']) {

echo "<br>";
echo "<br>";

echo '<div class="pull-right"><a href="forum_cmd?edit_topic=' . $data['topic_id'] . '" class="btn btn-success btn-xs">Edit</a> <a href="forum_cmd.php?delete_topic=' . $data['topic_id'] . '" class="btn btn-success btn-xs">Delete</a></div>';

}

echo '</td>
</tr>';

while($posts = mysqli_fetch_array($fetch_posts)) {
	
$pst_date = $posts['post_date'];
$pst_by = $posts['post_by'];
$pst_content = $posts['post_content'];

echo '<tr class="success">
<td>';

$url = loadAvatar($data['topic_by']);

echo '<img src="' . $url . '" height="80" width="80">';

echo '<br>
<b>' . loadAccDetails("user_id",$pst_by,"user_name") . '</b>
<br>
<br>
Posts: ' . loadAccDetails("user_id",$pst_by,"forum_posts") . '
</td>
<td>on <b>' . readableDate($pst_date) . '</b> by <b>'. loadAccDetails("user_id",$pst_by,"user_name") . '</b>
<br>
<br>' . nl2br($pst_content);

if(checkAdmin() == TRUE OR checkForumMod() == TRUE OR $pst_by == $_SESSION['user_id']) {
	
echo "<br>";
echo "<br>";
echo '<div class="pull-right"><a href="forum_cmd?edit_post=' . $posts['post_id'] . '" class="btn btn-success btn-xs">Edit</a> <a href="forum_cmd?delete_post=' . $posts['post_id']. '" class="btn btn-success btn-xs">Delete</a></div>';

}

echo '</td>
</tr>';	  

}
  
echo '</tbody>
</table> ';

echo '<br>';

if(UserLoggedIn() == true) {
	
$encryption_key = settings("EncryptionKey");
	
echo '<div class="panel panel-default">
<div class="panel-heading">Shoot a Reply:</div>
<div class="panel-body">
<form method="post" action="forum_cmd">
<input type="hidden" value="' . encrypt($slug,$encryption_key) . '" name="code">
<textarea class="form-control" rows="4" name="reply_content" placeholder="Please enter your reply to this topic."></textarea>
<br>
<input type="submit" name="reply" class="btn btn-success" value="Post">
</form>
</div>
</div>
</div>';
	
}

echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="?slug=' . $slug . '&page=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?slug=' . $slug . '&page=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;

echo '<li><a href="?slug=' . $slug . '&page=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';

?>

<br>

</div>
</div>
</section>