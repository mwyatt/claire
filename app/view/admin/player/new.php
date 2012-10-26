<?php require_once($this->pathView() . 'admin/header.php'); ?>

	<?php echo $this->getFeedback(); ?>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="first_name" placeholder="First Name" maxlength='75'>
			<input class="required" type="text" name="last_name" placeholder="Last Name" maxlength='75'>
		</div>			

		<div class="row">			
			<input class="required" type="text" name="rank" placeholder="Rank (eg 1800)" maxlength='75'>
		</div>			

		<select name="team">
		  <option value="4">Burnley Boys Club</option>
		</select>

		<div class="row">			
			<input type="reset" name="reset" value="Reset">
		</div>			

		<input class="" name="form_player_new" type="submit">
		
	</form>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>