<?php require_once($this->pathView() . 'admin/header.php'); ?>

	<?php echo $this->getFeedback(); ?>

	<h1>Add New Player</h1>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="first_name" placeholder="First Name" maxlength="75">
			<input class="required" type="text" name="last_name" placeholder="Last Name" maxlength="75">
		</div>			

		<div class="row">			
			<input class="required" type="text" name="rank" placeholder="Rank (eg 1800)" maxlength="75">
		</div>			

		<div class="row division">

			<select name="division_id">

				<option value="0"></option>

				<?php while ($ttDivision->nextRow()) : ?>
			
				<option value="<?php echo $ttDivision->getRow('division_id'); ?>"><?php echo $ttDivision->getRow('division_name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<div class="row team">
			<select name="team_id">
				<option value="0"></option>
			</select>
		</div>

		<input class="" name="form_player_new" type="submit">
		
	</form>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>