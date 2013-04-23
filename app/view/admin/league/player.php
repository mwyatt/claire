<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div id="content" class="league player">
	
	<h2>Players</h2>

	<a class="new" href="<?php echo $this->urlCurrent(); ?>new/" title="Add a new Player">New</a>

<?php if ($this->get('model_ttplayer')) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="text-left">Select</th>
			<th class="text-left">Name</th>
			<th class="text-center">Rank</th>
			<th class="text-left">Team</th>
			<th class="text-left">Division</th>
			<th>Action</th>
		</tr>

	<?php foreach ($this->get('model_ttplayer') as $player): ?>

		<tr data-id="<?php echo $this->get($player, 'id'); ?>">

			<td>
				<input type="checkbox" name="id" value="<?php echo $this->get($player, 'id'); ?>">
			</td>

			<td>
				<a href="<?php echo $this->urlCurrent(); ?>?edit=<?php echo $this->get($player, 'id'); ?>" title="Edit Player <?php echo $this->get($player, 'full_name'); ?>"><?php echo $this->get($player, 'full_name'); ?></a>
			</td>

			<td class="text-center"><?php echo $this->get($player, 'rank'); ?></td>

			<td><?php echo $this->get($player, 'team_name'); ?></td>

			<td><?php echo $this->get($player, 'division_name'); ?></td>

			<td class="action">
				<a href="<?php echo $this->urlCurrent(); ?>?edit=<?php echo $this->get($player, 'id'); ?>" title="Edit <?php echo $this->get($player, 'full_name'); ?>">Edit</a>
				<a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $this->get($player, 'id'); ?>" title="Delete <?php echo $this->get($player, 'full_name'); ?>">Delete</a>
			</td>

		</tr>		

	<?php endforeach ?>

	</table>
	
<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>