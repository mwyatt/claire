<?php require_once($this->pathView() . 'admin/header.php'); ?>

	<?php echo $this->getFeedback(); ?>

	<form class="main" method="post">

		<input type="text" name="first_name" placeholder="First Name">
		
		<input type="text" name="last_name" placeholder="Last Name">
		
		<input type="text" name="rank" placeholder="Rank">
		
		<select name="team">
		
		  <option value="4">Burnley Boys Club</option>
		  
		</select>
		
		<input type="reset" name="reset" value="Reset">

		<input class="" name="form_player_new" type="submit">
		
	</form>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>