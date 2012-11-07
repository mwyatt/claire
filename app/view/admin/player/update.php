<?php require_once($this->pathView() . 'admin/header.php'); ?>
<?php

// echo '<pre>';
// print_r($ttTeam);
// echo '</pre>';
// exit;


?>

	<?php echo $this->getFeedback(); ?>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="first_name" placeholder="First Name" maxlength="75" value="<?php echo $ttPlayer->get('first_name'); ?>">
			<input class="required" type="text" name="last_name" placeholder="Last Name" maxlength="75" value="<?php echo $ttPlayer->get('last_name'); ?>">
		</div>			

		<div class="row">			
			<input class="required" type="text" name="rank" placeholder="Rank (eg 1800)" maxlength="75" value="<?php echo $ttPlayer->get('rank'); ?>">
		</div>			

		<div class="row division">

			<select name="division_id">

				<option value="0"></option>

				<?php while ($ttDivision->nextRow()) : ?>
			
				<option value="<?php echo $ttDivision->getRow('division_id'); ?>" <?php echo ($ttDivision->getRow('division_id') == $ttPlayer->get('division_id') ? 'selected' : false); ?>><?php echo $ttDivision->getRow('division_name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<select name="team_id">

			<option value="0"></option>

			<?php while ($ttTeam->nextRow()) : ?>
			
			<option value="<?php echo $ttTeam->getRow('id'); ?>" <?php echo ($ttTeam->getRow('id') == $ttPlayer->get('team_id') ? 'selected' : false); ?>><?php echo $ttTeam->getRow('name'); ?></option>

			<?php endwhile; ?>

		</select>

		<div class="row">			
			<input type="reset" name="reset" value="Reset">
		</div>			

		<input name="form_player_update" type="submit">
		
	</form>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>