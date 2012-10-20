<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="score-submit">
	
	<h2>Submit Scorecard</h2>

	<?php if ($ttdivision->getData()) : ?>	

	<form id="form-add_card" name="form_add" method="post">

		<select name="division" tabindex="1">

			<option value="0"></option>

			<?php while ($ttdivision->nextRow()) : ?>
		
			<option value="<?php echo $ttdivision->getRow('division_id'); ?>"><?php echo $ttdivision->getRow('division_name'); ?></option>

			<?php endwhile; ?>

		</select>

		<h2>Home Team</h2>
		<h2>Away Team</h2>
		<h3>Home Player 1</h3>
		<h3>Home Player 2</h3>
		<h3>Home Player 3</h3>
		<h3>Away Player 1</h3>
		<h3>Away Player 2</h3>
		<h3>Away Player 3</h3>
		<h4>9 Match Rows</h4>
		<h2>Totals</h2>

		<input class="" name="form_card_new" type="submit">

	</form>

	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>