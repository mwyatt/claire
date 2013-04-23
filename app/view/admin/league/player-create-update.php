<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content <?php echo $this->urlSegment(2); ?> <?php echo ($this->get('model_ttplayer') ? 'update' : 'create'); ?>" data-id="<?php echo $this->get('model_ttplayer', 'id'); ?>">
	<h1><?php echo ($this->get('model_ttplayer') ? 'Update ' . ucfirst($this->urlSegment(2)) . ' ' . $this->get('model_ttplayer', 'title') : 'Create new ' . ucfirst($this->urlSegment(2))); ?></h1>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="first_name" placeholder="First Name" maxlength="75" value="<?php echo $this->get('model_ttplayer', 'first_name'); ?>">
			<input class="required" type="text" name="last_name" placeholder="Last Name" maxlength="75" value="<?php echo $this->get('model_ttplayer', 'last_name'); ?>">
		</div>			

		<div class="row">			
			<input class="required" type="text" name="rank" placeholder="Rank (eg 1800)" maxlength="75" value="<?php echo $this->get('model_ttplayer', 'rank'); ?>">
		</div>			

<?php if ($this->get('model_ttdivision')): ?>

		<div class="row division">
			<select name="division_id">
				<option value="0"></option>
				 
	<?php foreach ($this->get('model_ttdivision') as $division): ?>
		
				<option value="<?php echo $this->get($division, 'id'); ?>" <?php echo ($this->get($division, 'id') == $this->get('model_ttplayer', 'division_id') ? 'selected' : false); ?>><?php echo $this->get($division, 'name'); ?></option>

	<?php endforeach ?>

			</select>
		</div>
	
<?php endif ?>

		<div class="row team">
			<select name="team_id">
				<option value="0"></option>

<?php if ($this->get('model_ttteam')): ?>
	<?php foreach ($this->get('model_ttteam') as $team): ?>
		
				<option value="<?php echo $this->get($team, 'id'); ?>" <?php echo ($this->get($team, 'id') == $this->get('model_ttplayer', 'team_id') ? 'selected' : false); ?>><?php echo $this->get($team, 'name'); ?></option>

	<?php endforeach ?>
<?php endif ?>

			</select>
		</div>
	

		<input name="form_<?php echo ($this->get('model_ttplayer') ? 'update' : 'create'); ?>" type="hidden" value="true">
	</form>
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>