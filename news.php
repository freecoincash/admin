<section id="form-page">

<div class="container">
<div id="duh">
<div class="page-header">
<h1>News</h1>
</div>

<?php

$news = mysqli_query($con,"SELECT * FROM news ORDER BY published DESC LIMIT 60");

if(mysqli_num_rows($news) < 0.99) {
	
echo '<div class="alert alert-info">
There are no news articles to show.
</div>';
	
} else {
	
while($n = mysqli_fetch_array($news)) {
	
echo '<div class="panel panel-primary">';	
echo '<div class="panel-body">';	
	
echo '<h3><b>' . $n['title'] . '</b></h3>';
echo '<em>Published on <b>' . $n['published'] . '</b></em>';

echo '<br>';
echo '<br>';

echo '<p>' . nl2br($n['content']) . '</p>';
	
echo '</div>';
echo '</div>';
	
}	
	
}

?>

</div>
</div>
</section>