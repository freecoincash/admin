<section id="form-page">

<div class="container">

<div class="row">

<div class="col-md-12" >
<div class="panel panel-default" id="duh">
<div class="panel-body">

<style>
h1 {
  font-family: 'Questrial';
  margin-bottom: 5px;
}
</style>

<center>

<h1>Referral System</h1>

<br>
<br>

<div class="row">

<div class="col-md-6">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<h1>Referred Users</h1>

<br>
<br>

<?php

$count = mysqli_query($con,"SELECT COUNT(user_id) as id FROM users WHERE referral = '{$_SESSION['user_name']}'");
$count = mysqli_fetch_array($count);
$count = $count['id'];

?>

<span style="font-size:26px;"><?php echo number_format($count); ?></span>

</center>

</div>
</div>
</div>

<div class="col-md-6">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<h1>Referred Earnings</h1>

<br>
<br>

<span style="font-size:26px;"><?php echo loadAccDetails("user_id",$_SESSION['user_id'],"total_referred"); ?> BTC</span>

</center>

</div>
</div>
</div>

</div>

<div class="row">

<?php if(settings("faucetStatus") == 1) { ?>

<div class="col-md-3">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<h1>Faucet</h1>

<br>
<br>

<span style="font-size:26px;"><?php echo settings("refPercentageFaucet"); ?>%</span>

</center>

</div>
</div>
</div>

<?php } ?>

<div class="col-md-3">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<h1>Roll</h1>

<br>
<br>

<span style="font-size:26px;"><?php echo settings("refPercentageRoll"); ?>%</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<h1>Hi-Lo</h1>

<br>
<br>

<span style="font-size:26px;"><?php echo settings("refPercentageDice"); ?>%</span>

</center>

</div>
</div>
</div>

<div class="col-md-3">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<h1>F-Hunt</h1>

<br>
<br>

<span style="font-size:26px;"><?php echo settings("refPercentageTreasureGame"); ?>%</span>

</center>

</div>
</div>
</div>

</div>

<style>

ul.share-buttons{
  list-style: none;
  padding: 0;
}

ul.share-buttons li{
  display: inline;
}

</style>

<?php $ref_url = $website_url . "?ref=" . $_SESSION['user_name']; ?>

<span style="font-size:18px; color:black;"><b>Link: </b> <?php echo $ref_url; ?></font>

<br>
<br>

<ul class="share-buttons">
<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($ref_url); ?>&t=" title="Share on Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><img src="assets/images/flat_web_icon_set/black/Facebook.png"></a></li>
<li><a href="https://twitter.com/intent/tweet?source=<?php echo urlencode($ref_url); ?>&text=<?php echo urlencode("Premium Bitcoin faucet, join today! " . $ref_url); ?>" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;"><img src="assets/images/flat_web_icon_set/black/Twitter.png"></a></li>
<li><a href="https://plus.google.com/share?url=<?php echo urlencode($ref_url); ?>" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><img src="assets/images/flat_web_icon_set/black/Google+.png"></a></li>
<li><a href="http://www.tumblr.com/share?v=3&u=<?php echo urlencode($ref_url); ?>&t=&s=" target="_blank" title="Post to Tumblr" onclick="window.open('http://www.tumblr.com/share?v=3&u=' + encodeURIComponent(document.URL) + '&t=' +  encodeURIComponent(document.title)); return false;"><img src="assets/images/flat_web_icon_set/black/Tumblr.png"></a></li>
<li><a href="https://getpocket.com/save?url=<?php echo urlencode($ref_url); ?>&title=" target="_blank" title="Add to Pocket" onclick="window.open('https://getpocket.com/save?url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><img src="assets/images/flat_web_icon_set/black/Pocket.png"></a></li>
<li><a href="http://www.reddit.com/submit?url=<?php echo urlencode($ref_url); ?>&title=" target="_blank" title="Submit to Reddit" onclick="window.open('http://www.reddit.com/submit?url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><img src="assets/images/flat_web_icon_set/black/Reddit.png"></a></li>
<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($ref_url); ?>&title=&summary=&source=<?php echo urlencode($ref_url); ?>" target="_blank" title="Share on LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><img src="assets/images/flat_web_icon_set/black/LinkedIn.png"></a></li>
<li><a href="http://wordpress.com/press-this.php?u=<?php echo urlencode($ref_url); ?>&t=&s=" target="_blank" title="Publish on WordPress" onclick="window.open('http://wordpress.com/press-this.php?u=' + encodeURIComponent(document.URL) + '&t=' +  encodeURIComponent(document.title)); return false;"><img src="assets/images/flat_web_icon_set/black/Wordpress.png"></a></li>
<li><a href="https://pinboard.in/popup_login/?url=<?php echo urlencode($ref_url); ?>&title=&description=" target="_blank" title="Save to Pinboard" onclick="window.open('https://pinboard.in/popup_login/?url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><img src="assets/images/flat_web_icon_set/black/Pinboard.png"></a></li>
<li><a href="mailto:?subject=&body=:%20<?php echo urlencode($ref_url); ?>" target="_blank" title="Email" onclick="window.open('mailto:?subject=' + encodeURIComponent(document.title) + '&body=' +  encodeURIComponent(document.URL)); return false;"><img src="assets/images/flat_web_icon_set/black/Email.png"></a></li>
</ul>

</div>

</div>
</div>
</div>


</div>
</div>
</section>