<?php require_once('header.php'); ?>

<div id="content" class="dashboard">

	<form name="" method="post" action="<?php echo $this->urlHome(); ?>basket/add">

		<label for="form-name">Name</label><input type="text" id="review-name">
		<p class="clearfix"><label for="review-email">Email</label><input type="text" id="review-email"></p>
		<p class="clearfix"><label for="review-review">Review</label><textarea rows="4" cols="50" id="review-review"></textarea></p>
		<p class="clearfix"><label for="review-stars">Stars</label><input type="radio" name="review-stars" value="1"><input type="radio" name="review-stars" value="2"><input type="radio" name="review-stars" value="3"><input type="radio" name="review-stars" value="4"><input type="radio" name="review-stars" value="5"></p>
		<p class="clearfix action"><a href="#" class="button">Review it</a> and aid your fellow customers.</p>

	</form>

</div> <!-- .container -->

<?php require_once('footer.php'); ?>