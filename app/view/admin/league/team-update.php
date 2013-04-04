<?php require_once($this->pathView() . 'admin/header.php'); ?>

	<?php echo $this->getFeedback(); ?>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="name" placeholder="Name" maxlength="75" value="<?php echo $ttTeam->get('name'); ?>">
		</div>			

		<div class="row">

			<select name="venue_id">

				<option value="0"></option>

				<?php while ($ttVenue->nextRow()) : ?>
			
				<option value="<?php echo $ttVenue->getRow('id'); ?>" <?php echo ($ttTeam->get('venue_id') == $ttVenue->getRow('id') ? 'selected' : false); ?>><?php echo $ttVenue->getRow('name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<div class="row">

			<select name="home_night">

				<?php foreach ($ttTeam->getWeekDays() as $value => $name) : ?>

				<option value="<?php echo $value; ?>" <?php echo ($ttTeam->get('home_night') == $value ? 'selected' : false); ?>><?php echo $name; ?></option>

				<?php endforeach; ?>

			</select>

		</div>

		<div class="row">

			<select name="division_id">

				<option value="0"></option>

				<?php while ($ttDivision->nextRow()) : ?>
			
				<option value="<?php echo $ttDivision->getRow('division_id'); ?>" <?php echo ($ttDivision->getRow('division_id') == $ttTeam->get('division_id') ? 'selected' : false); ?>><?php echo $ttDivision->getRow('division_name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<div class="row">

			<label for="">Secretary</label>

			<select name="secretary_id">

				<option value="0">None</option>

				<?php while ($ttSecretary->nextRow()) : ?>
			
				<option value="<?php echo $ttSecretary->getRow('id'); ?>" <?php echo ($ttSecretary->getRow('id') == $ttTeam->get('secretary_id') ? 'selected' : false); ?>><?php echo $ttSecretary->getRow('full_name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<div class="row">
			
			<input name="form_team_update" type="submit">
			
		</div>
		
	</form>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>