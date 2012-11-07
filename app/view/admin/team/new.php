<?php require_once($this->pathView() . 'admin/header.php'); ?>

	<?php echo $this->getFeedback(); ?>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="name" placeholder="Name" maxlength="75">
		</div>			

		<div class="row">

			<select name="venue_id">

				<option value="0"></option>

				<?php while ($ttVenue->nextRow()) : ?>
			
				<option value="<?php echo $ttVenue->getRow('id'); ?>"><?php echo $ttVenue->getRow('name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<div class="row">

			<select name="home_night">

				<?php foreach ($ttTeam->getWeekDays() as $value => $name) : ?>

				<option value="<?php echo $value; ?>"><?php echo $name; ?></option>

				<?php endforeach; ?>

			</select>

		</div>

		<div class="row">

			<select name="division_id">

				<option value="0"></option>

				<?php while ($ttDivision->nextRow()) : ?>
			
				<option value="<?php echo $ttDivision->getRow('division_id'); ?>"><?php echo $ttDivision->getRow('division_name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<input class="" name="form_team_new" type="submit">
		
	</form>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>