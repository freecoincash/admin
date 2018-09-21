<section id="forum-page">
<div class="container">
<div id="duh">
<div class="page-header">
<h1>Forums</h1>
</div>

<?php

$query = mysqli_query($con,"SELECT * FROM categories ORDER BY sort_lvl ASC");

if(mysqli_num_rows($query) < 0.9) {
	
echo '<div class="alert alert-dismissable alert-info">
There are no categories to show. Please add forum categories to start using forums.
</div>';
	
} else {
	
echo '<table class="table table-striped table-hover">

<thead>
<tr class="danger">
<th>Board Name</th>
<th>Topics</th>
<th>Posts</th>
<th>Last Post</th>
</tr>
</thead>
<tbody>';

while($forum = mysqli_fetch_array($query)) {
	
$id = $forum['id'];
$name = $forum['name'];
$slug = $forum['slug'];
$description = $forum['description'];
$topics = $forum['topics'];
$posts = $forum['posts'];
	
echo '<tr class="success">
<td><a href="board?slug=' . $slug . '">' . $name . '</a>
<br>
<small>' . $description . '</small>
</td>
<td>' . $topics . '</td>
<td>' . $posts . '</td>';

$find_post = mysqli_query($con,"SELECT post_by,post_topic FROM posts WHERE post_category = '{$id} ORDER BY post_id DESC LIMIT 1");

if(mysqli_num_rows($find_post) < 0.9) {
	
$topic = mysqli_query($con,"SELECT topic_id,topic_by,topic_name,topic_slug FROM topics WHERE topic_cat = '{$id}' ORDER BY topic_id DESC LIMIT 1");

if(mysqli_num_rows($topic) < 0.99) {
	
echo '<td>No recently created posts.</td>';

} else {
	
$topic = mysqli_fetch_array($topic);
echo '<td><b>by </b>' . loadAccDetails("user_id",$topic['topic_by'],"user_name") . ' in <b><a href="topic?slug=' . $topic['topic_slug'] . '">' . getTopicName($topic['topic_id']) . '</a></b></td>';

}

} else {
	
$post = mysqli_fetch_array($find_post);
echo '<td><b>by </b>' . loadAccDetails("user_id",$post['post_by'],"user_name") . ' in <b><a href="topic?slug=' . dbSlug($post['post_topic']) . '">' . getTopicName($post['post_topic']) . '</a></b></td>';

}

echo '</tr>';
	
}

echo '</tbody>
</table>';

echo '<br>';

}

if(checkAdmin() == TRUE) {
	
echo '<div class="pull-right"><a href="admin_cmd?page=forums" class="btn btn-success">Edit Forums</a></div>
<br>
<br>
<br>';
	
}
 
?>

</div>
</div>
</section>