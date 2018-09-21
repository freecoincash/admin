<section id="forum-page">
<div class="container">
<div id="duh">
<div class="page-header">
<h1><a href="forums">Forums</a></h1>
</div>

<?php

$board_slug = filterData($_GET['slug']);
$fetch_data = mysqli_query($con,"SELECT id,name FROM categories WHERE slug = '{$board_slug}' LIMIT 1");

$data = mysqli_fetch_array($fetch_data);

$rc = mysqli_query($con,"SELECT COUNT(topic_id) AS id FROM topics WHERE topic_cat = '{$data['id']}'");
$numrows = mysqli_fetch_array($rc);

$posts = 30;
$total_pages = ceil($numrows['id'] / $posts);

if(isset($_GET['page']) && is_numeric($_GET['page'])) {
$req_page = (int) cleanInput($_GET['page']);
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

echo '<div class="row">';

echo '<div class="col-md-10">';
echo '<h4><b>' . $data['name'] . '</b></h4>';
echo '</div>';

echo '<div class="col-md-1">';
echo '<a href="forum_cmd?create_topic=' . $data['id'] . '" class="btn btn-xs btn-success">Create a Topic</a>';
echo '</div>';

echo "</div>";

echo '<br>';

$fetch_topics = mysqli_query($con,"SELECT * FROM topics WHERE topic_cat = {$data['id']} ORDER BY topic_id DESC LIMIT $offset, $posts");

if(mysqli_num_rows($fetch_topics) > 0.9) {

echo '<table class="table table-striped table-hover">
<thead>
<tr class="danger">
<th>Read/Unread</th>
<th>Subject</th>
<th>Posted By</th>
<th>Replies</th>
<th>Views</th>
<th>Last Post</th>
</tr>
</thead>
<tbody>';

  
while($topics = mysqli_fetch_array($fetch_topics)) {

$id = $topics['topic_id'];
$name = $topics['topic_name'];
$slug = $topics['topic_slug'];
$topic_by = $topics['topic_by'];
$views = $topics['topic_views'];

echo '<tr class="success">
<td>' . ifRead($id,$_SESSION['user_id']) . '</td>
<td><a href="topic?slug=' . $slug . '">' . $name . '</a></td>
<td>' . loadAccDetails("user_id",$topic_by,"user_name") . '</td>
<td>' . getReplies($id) . '</td>
<td>' . $views . '</td>';

$find_post = mysqli_query($con,"SELECT * FROM posts WHERE post_category = {$data['id']} AND post_topic = {$id} ORDER BY post_id DESC LIMIT 1");

if(mysqli_num_rows($find_post) < 0.99) {
	
echo '<td>No replies</td>'; 

} else {
	
$post = mysqli_fetch_array($find_post);
echo '<td><b>by </b>' . loadAccDetails("user_id",$post['post_by'],"user_name") . ' in <b><a href="topic?slug=' . dbSlug($post['post_topic']) . '">' . getTopicName($post['post_topic']) . '</a></b></td>';

}

echo '</tr>';

}
  
echo '</tbody>
</table> ';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="?slug=' . $board_slug . '&page=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?slug=' . $board_slug . '&page=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;

echo '<li><a href="?slug=' . $board_slug . '&page=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';

} else {
	
echo '<div class="alert alert-warning">
There are no topics to show here.
</div>';	
	
}

?>

<br>

</div>
</div>
</section>