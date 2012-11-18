<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div id="content" class="league player">
	
	<h2>Players</h2>

	<a class="new" href="<?php echo $this->urlCurrent(); ?>new/" title="Add a new Player">New</a>

	<?php if ($ttPlayer->getData()) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="text-left">Select</th>
			<th class="text-left">Name</th>
			<th class="text-center">Rank</th>
			<th class="text-left">Team</th>
			<th class="text-left">Division</th>
			<th>Action</th>
		</tr>

		<?php while ($ttPlayer->nextRow()) : ?>

		<tr data-id="<?php echo $ttPlayer->getRow('id'); ?>">

			<td>
				<input type="checkbox" name="id" value="<?php echo $ttPlayer->getRow('id'); ?>">
			</td>

			<td>
				<a href="<?php echo $this->urlCurrent(); ?>?update=<?php echo $ttPlayer->getRow('id'); ?>" title="Edit Player <?php echo $ttPlayer->getRow('full_name'); ?>"><?php echo $ttPlayer->getRow('full_name'); ?></a>
			</td>

			<td class="text-center"><?php echo $ttPlayer->getRow('rank'); ?></td>

			<td><?php echo $ttPlayer->getRow('team_name'); ?></td>

			<td><?php echo $ttPlayer->getRow('division_name'); ?></td>

			<td class="action"><a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $ttPlayer->getRow('id'); ?>" title="Delete <?php echo $ttPlayer->getRow('full_name'); ?>">Delete</a></td>

		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>