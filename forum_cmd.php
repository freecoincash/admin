<section id="forum-page">
<div class="container">
<div id="duh">
<div class="page-header">
<h1><a href="forums.php">Forums</a></h1>
</div>

<?php

$encryption_key = settings("EncryptionKey");

if(isset($_POST['reply'])) {
	
$topic_details = filterData($_POST['code']);
$topic_decrypt = decrypt($topic_details,$encryption_key);

$reply = filterData($_POST['reply_content']);
$reply = preg_replace("/\r\n|\r|\n/",'<br/>',$reply);

$time = date('Y-m-d H:i:s');

if($reply == "") {
	
echo '<div class="alert alert-dismissable alert-info">
You have left the reply field blank.
</div>';	

echo '<meta http-equiv="refresh" content="6;URL=' . $website_url . 'topic?slug=' . $topic_decrypt . '">';
	
} elseif(strlen($reply) < 3) {
	
echo '<div class="alert alert-dismissable alert-info">
The reply should be atleast 3 characters.
</div>';

echo '<meta http-equiv="refresh" content="6;URL=' . $website_url . 'topic?slug=' . $topic_decrypt . '">';
	
} else {
	
$fetch_topic = mysqli_query($con,"SELECT topic_id,topic_cat FROM topics WHERE topic_slug = '$topic_decrypt'");

if(mysqli_num_rows($fetch_topic) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-info">
Well, couldn\'t find that topic.
</div>';		
	
echo '<meta http-equiv="refresh" content="6;URL=' . $website_url . 'forums">';
	
} else {

$topiced = mysqli_fetch_array($fetch_topic);
	
mysqli_query($con,"INSERT INTO posts (post_content,post_topic,post_category,post_date,post_by) VALUES ('$reply','{$topiced['topic_id']}','{$topiced['topic_cat']}','$time','{$_SESSION['user_id']}')");
mysqli_query($con,"UPDATE users SET forum_posts = forum_posts + 1 WHERE user_id = '{$_SESSION['user_id']}'");
mysqli_query($con,"UPDATE categories SET posts = posts + 1 WHERE id = '{$topiced['topic_cat']}'");
mysqli_query($con,"UPDATE topics SET replies = replies + 1 WHERE topic_id = {$topiced['topic_id']}");

echo '<meta http-equiv="refresh"  content="0;URL=' . $website_url . 'topic?slug=' . $topic_decrypt . '">';

echo '<div class="alert alert-dismissable alert-success">
Your reply has been posted. Redirecting you back to the topic.
</div>';

}

}

}

elseif(isset($_POST['post'])) {
	
$category = filterData($_POST['category']);
$subject = filterData($_POST['subject']);
$text = filterData($_POST['text']);
$text = preg_replace("/\r\n|\r|\n/",'<br/>',$text);

$attempt = mysqli_query($con,"SELECT name FROM categories WHERE id = '$category' LIMIT 1");

if(mysqli_num_rows($attempt) < 0.9) {
	
echo '<div class="alert alert-dismissable alert-info">
The forum does not exist.
</div>';

echo '<meta http-equiv="refresh"  content="6;URL=' . $website_url . 'forums">';
	
} 

elseif($subject == "") {
	
echo '<div class="alert alert-dismissable alert-info">
You have missed the subject of the post.
</div>';

echo '<meta http-equiv="refresh"  content="6;URL=' . $website_url . 'forums">';
	
}

elseif(strlen($subject) < 7) {
	
echo '<div class="alert alert-dismissable alert-info">
The subject of the post should be at least 7 characters.
</div>';	

echo '<meta http-equiv="refresh"  content="6;URL=' . $website_url . 'forums">';
	
}

elseif(strlen($subject) > 250) {
	
echo '<div class="alert alert-dismissable alert-info">
The subject of the post should not be more than 250 characters.
</div>';

echo '<meta http-equiv="refresh"  content="6;URL=' . $website_url . 'forums">';
	
}

elseif($text == "") {
	
echo '<div class="alert alert-dismissable alert-info">
You have submitted an invalid textbox.
</div>';

echo '<meta http-equiv="refresh"  content="6;URL=' . $website_url . 'forums">';
	
}

elseif(strlen($text) < 10) {
	
echo '<div class="alert alert-dismissable alert-info">
The text should be at-least 10 characters.
</div>';	
	
echo '<meta http-equiv="refresh"  content="6;URL=' . $website_url . 'forums">';
	
} else {
	
$slug = slug($subject) . "-" . mt_rand(1,1000);
$datetime = date("Y-m-d H:i:s");

mysqli_query($con,"INSERT INTO topics (topic_slug,topic_cat,topic_content,topic_name,topic_date,topic_by,topic_views) VALUES ('$slug','$category','$text','$subject','$datetime','{$_SESSION['user_id']}','1')");
mysqli_query($con,"UPDATE users SET forum_posts = forum_posts + 1 WHERE user_id = '{$_SESSION['user_id']}'");
mysqli_query($con,"UPDATE categories SET topics = topics + 1 WHERE id = '$category'");

echo '<meta http-equiv="refresh"  content="0;URL=' . $website_url . 'topic?slug=' . $slug . '">';

echo '<div class="alert alert-dismissable alert-success">
Your message has been posted. Redirecting you to the post.
</div>';

}	
	
}

elseif(isset($_POST['make_changes'])) {
	
$topic_id = filterData($_POST['topic_id']);
$subject = filterData($_POST['subject']);
$text = filterData($_POST['text']);	
$text = preg_replace("/\r\n|\r|\n/",'<br/>',$text);

if(checkAdmin() == TRUE OR checkForumMod() == TRUE) {
$fetch_topic = mysqli_query($con,"SELECT topic_id,topic_slug FROM topics WHERE topic_id = '$topic_id'");
} else {
$fetch_topic = mysqli_query($con,"SELECT topic_id,topic_slug FROM topics WHERE topic_id = '$topic_id' AND topic_by = '{$_SESSION['user_id']}'");	
}

if(mysqli_num_rows($fetch_topic) > 0.99) {
	
$slugomnomnom = mysqli_fetch_array($fetch_topic);
	
}

if($topic_id == "") {
	
echo '<div class="alert alert-dismissable alert-info">
Invalid topic ID.
</div>';

echo '<meta http-equiv="refresh" content="6;URL=' . $website_url . 'topic?slug=' . $topic_decrypt . '">';
	
} elseif(mysqli_num_rows($fetch_topic) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-info">
The topic was not found.
</div>';	

echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'forums">';
	
} elseif($subject == "") {
	
echo '<div class="alert alert-dismissable alert-info">
The subject line is necessary.
</div>';	

echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . $slugomnomnom['topic_slug'] . '">';
	
}

elseif(strlen($subject) < 7) {
	
echo '<div class="alert alert-dismissable alert-info">
The subject should be atleast 7 characters.
</div>';

echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . $slugomnomnom['topic_slug'] . '">';
	
}

elseif(strlen($subject) > 250) {
	
echo '<div class="alert alert-dismissable alert-info">
The subject should not be more than 250 characters.
</div>';	

echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . $slugomnomnom['topic_slug'] . '">';
	
}

elseif($text == "") {
	
echo '<div class="alert alert-dismissable alert-info">
You\'re missing the text field.
</div>';

echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . $slugomnomnom['topic_slug'] . '">';
	
}

elseif(strlen($text) < 10) {
	
echo '<div class="alert alert-dismissable alert-info">
The text should be atleast 10 characters.
</div>';	
	
echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . $slugomnomnom['topic_slug'] . '">';
	
} else {
	
mysqli_query($con,"UPDATE topics SET topic_name = '$subject', topic_content = '$text' WHERE topic_id = '$topic_id'");	
	
echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . $slugomnomnom['topic_slug'] . '">';
	
echo '<div class="alert alert-dismissable alert-success">
The topic has been updated. Redirecting back to the topic in 3 seconds.
</div>';
	
}
	
}

elseif(isset($_POST['make_changes_post'])) {
	
$post_id = filterData($_POST['post_id']);
$text = filterData($_POST['reply_content']);
$text = preg_replace("/\r\n|\r|\n/",'<br/>',$text);

if(checkForumMod() == TRUE OR checkForumMod() == TRUE) {
$fetch_post = mysqli_query($con,"SELECT post_id,post_topic FROM posts WHERE post_id = '$post_id'");
} else {
$fetch_post = mysqli_query($con,"SELECT post_id,post_topic FROM posts WHERE post_id = '$post_id' AND post_by = '{$_SESSION['user_id']}'");	
}

if(mysqli_num_rows($fetch_post) > 0.99) {
	
$slugomnomnom = mysqli_fetch_array($fetch_post);

}

if($post_id == "") {
	
echo '<div class="alert alert-dismissable alert-info">
Invalid post ID.
</div>';

}
	
elseif(mysqli_num_rows($fetch_post) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-info">
The forum does not exist.
</div>';
	
}

elseif($text == "") {
	
echo '<div class="alert alert-dismissable alert-info">
You\'re missing the reply field.
</div>';	

echo '<meta http-equiv="refresh"  content="0;URL=' . $website_url . 'topic?slug=' . dbSlug($slugomnomnom['post_topic']) . '">';
	
}

elseif(strlen($text) < 10) {
	
echo '<div class="alert alert-dismissable alert-info">
The reply should be atleast 10 characters.
</div>';	

echo '<meta http-equiv="refresh"  content="0;URL=' . $website_url . 'topic?slug=' . dbSlug($slugomnomnom['post_topic']) . '">';
	
} else {
	
mysqli_query($con,"UPDATE posts SET post_content = '$text' WHERE post_id = '$post_id'");	
	
echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . dbSlug($slugomnomnom['post_topic']) . '">';
	
echo '<div class="alert alert-dismissable alert-success">
The post has been updated. Redirecting back to the topic in 3 seconds.
</div>';	
	
}

} elseif(isset($_GET['create_topic'])) {
	
$category = filterData($_GET['create_topic']);

$attempt = mysqli_query($con,"SELECT name FROM categories WHERE id = '$category' LIMIT 1");

if(mysqli_num_rows($attempt) < 0.9) {
	
echo '<div class="alert alert-dismissable alert-info">
The forum was not found.
</div>';

echo '<meta http-equiv="refresh"  content="0;URL=' . $website_url . 'forums">';
	
} else {
	
$attempt = mysqli_fetch_array($attempt);
	
echo '<h3>Create a Topic in <em>' . $attempt['name'] . '</em>:</h3>';
echo "<hr>";

echo '<form action="forum_cmd" method="POST">
	
<input type="hidden" name="category" value="' . $category . '">
	
<h2>Subject:</h2>
<input type="text" name="subject" placeholder="Perhaps, the title of the topic." class="form-control">

<br>

<h2>Text:</h2>
<textarea name="text" placeholder="Anything sensible that would prove beneficial to the forum." rows="6" class="form-control">Anything sensible that would prove beneficial to the forum.</textarea>

<br>

<input type="submit" name="post" class="btn btn-success btn-lg" value="Publish">

</form>';
	
}
	
}

elseif(isset($_GET['delete_topic'])) {
	
$topic_id = filterData($_GET['delete_topic']);
	
if(checkAdmin() == TRUE OR checkForumMod() == TRUE) {
$fetch_topic = mysqli_query($con,"SELECT topic_id FROM topics WHERE topic_id = '$topic_id'");
} else {
$fetch_topic = mysqli_query($con,"SELECT topic_id FROM topics WHERE topic_id = '$topic_id' AND topic_by = '{$_SESSION['user_id']}'");	
}
	
if($topic_id == "") {
	
echo '<div class="alert alert-dismissable alert-info">
Invalid topic ID.
</div>';	
	
} elseif(mysqli_num_rows($fetch_topic) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-info">
Whoops! The topic wasn\'t found or you don\'t have permission to access it.
</div>';	
	
} else {
	
$topic_cat_f = mysqli_query($con,"SELECT topic_cat FROM topics WHERE topic_id = '$topic_id'");
$topic_cat_f = mysqli_fetch_array($topic_cat_f);

mysqli_query($con,"UPDATE categories SET topics = topics - 1 WHERE id = '{$topic_cat_f['topic_cat']}'");
mysqli_query($con,"DELETE FROM topics WHERE topic_id = '$topic_id'");
$delete_posts = mysqli_query($con,"DELETE FROM posts WHERE post_topic = '$topic_id'");	
$aff = mysqli_affected_rows($delete_posts);
mysqli_query($con,"UPDATE categories SET posts = posts - '$aff' WHERE id = '{$topic_cat_f['topic_cat']}'");

echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'forums">';
	
echo '<div class="alert alert-dismissable alert-success">
The topic has been deleted.
</div>';	
	
}
	
}

elseif(isset($_GET['delete_post'])) {
	
$post_id = filterData($_GET['delete_post']);
	
if(checkAdmin() == TRUE OR checkForumMod() == TRUE) {
$fetch_post = mysqli_query($con,"SELECT post_id FROM posts WHERE post_id = '$post_id'");
} else {
$fetch_post = mysqli_query($con,"SELECT post_id FROM posts WHERE post_id = '$post_id' AND post_by = '{$_SESSION['user_id']}'");	
}

if($post_id == "") {
	
echo '<div class="alert alert-dismissable alert-info">
Invalid post ID.
</div>';	
	
}
	
elseif(mysqli_num_rows($fetch_post) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-info">
Whoops! The post wasn\'t found or you don\'t have permission to access it.
</div>';	
	
} else {
	
$post_cat_f = mysqli_query($con,"SELECT post_category,post_topic FROM posts WHERE post_id = '$post_id'");
$post_cat_f = mysqli_fetch_array($post_cat_f);

$pst_tpc = mysqli_query($con,"SELECT topic_slug FROM topics WHERE topic_id = '{$post_cat_f['post_topic']}'");
$pst_tpc = mysqli_fetch_array($pst_tpc);

mysqli_query($con,"UPDATE categories SET posts = posts - 1 WHERE id = '{$post_cat_f['post_category']}'");
mysqli_query($con,"DELETE FROM posts WHERE post_id = '$post_id'");

echo '<meta http-equiv="refresh" content="0;URL=' . $website_url . 'topic?slug=' . $pst_tpc['topic_slug'] . '">';
	
echo '<div class="alert alert-dismissable alert-success">
The post has been deleted. Redirecting back to the topic in 3 seconds.
</div>';	
	
}
	
}

elseif(isset($_GET['edit_topic'])) {
	
$topic_id = filterData($_GET['edit_topic']);

if(checkAdmin() == TRUE OR checkForumMod() == TRUE) {
$attempt = mysqli_query($con,"SELECT topic_name,topic_content FROM topics WHERE topic_id = '$topic_id' LIMIT 1");
} else {
$attempt = mysqli_query($con,"SELECT topic_name,topic_content FROM topics WHERE topic_id = '$topic_id' AND topic_by = '{$_SESSION['user_id']}' LIMIT 1");
}

if(mysqli_num_rows($attempt) < 0.9) {
	
echo '<div class="alert alert-dismissable alert-info">
Whoops! The topic wasn\'t found or you don\'t have permission to access it.
</div>';
	
} else {
	
$attempt = mysqli_fetch_array($attempt);
	
echo '<h3>Edit: <b>' . $attempt['topic_name'] . '</b></h3>';
echo "<hr>";

echo '<form action="forum_cmd" method="POST">
	
<input type="hidden" name="topic_id" value="' . $topic_id . '">
	
<h2>Subject:</h2>
<input type="text" name="subject" value="' . $attempt['topic_name'] . '" class="form-control">
<br>
<h2>Text:</h2>
<textarea name="text" rows="6" class="form-control">' . $attempt['topic_content'] . '</textarea>
<br>
<br>
<input type="submit" name="make_changes" class="btn btn-success btn-lg" value="Make Changes">	

<br>
<br>
	
</form>';
	
}
	
}

elseif(isset($_GET['edit_post'])) {
	
$post_id = filterData($_GET['edit_post']);

if(checkAdmin() == TRUE OR checkForumMod() == TRUE) {
$attempt = mysqli_query($con,"SELECT post_content FROM posts WHERE post_id = '$post_id' LIMIT 1");
} else {
$attempt = mysqli_query($con,"SELECT post_content FROM posts WHERE post_id = '$post_id' AND post_by = '{$_SESSION['user_id']}' LIMIT 1");
}

if(mysqli_num_rows($attempt) < 0.9) {
	
echo '<div class="alert alert-dismissable alert-info">
The post was not found.
</div>';
	
} else {
	
$attempt = mysqli_fetch_array($attempt);
	
echo '<form action="forum_cmd" method="POST">
	
<input type="hidden" name="post_id" value="' . $post_id . '">
	
<h2>Reply:</h2>
<textarea name="reply_content" rows="6" class="form-control">' . $attempt['post_content'] . '</textarea>
<br>
<br>
<input type="submit" name="make_changes_post" class="btn btn-success btn-lg" value="Make Changes">	

<br>
<br>
	
</form>';
	
}
	
}

?>

</div>
</div>
</section>