<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div id="content" class="league team">
	
	<h2>Teams</h2>

	<nav>
		<ul>
			<li>
				<a href="<?php echo $this->urlCurrent(); ?>new/" title="New Team">New</a>
			</li>
		</ul>
	</nav>

	<?php echo $this->getFeedback(); ?>

	<?php if ($ttTeam->getData()) : ?>	

	<table class="main" width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th>Checkbox</th>
			<th>Name</th>
			<th>Players</th>
			<th>Home Night</th>
			<th>Venue</th>
			<th>Division</th>
			<th>Delete</th>
		</tr>

		<?php while ($ttTeam->nextRow()) : ?>

		<tr data-id="<?php echo $ttTeam->getRow('id'); ?>">

			<td>
				<input type="checkbox" name="id" value="<?php echo $ttTeam->getRow('id'); ?>">
			</td>

			<td>
				<a href="<?php echo $this->urlCurrent(); ?>?update=<?php echo $ttTeam->getRow('id'); ?>" title="Edit <?php echo $ttTeam->getRow('name'); ?>"><?php echo $ttTeam->getRow('name'); ?></a>
			</td>

			<td><?php echo $ttTeam->getRow('player_count'); ?></td>

			<td><?php echo $ttTeam->getRow('home_night'); ?></td>

			<td><?php echo $ttTeam->getRow('venue_name'); ?></td>

			<td><?php echo $ttTeam->getRow('division_name'); ?></td>

			<td><a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $ttTeam->getRow('id'); ?>" title="Delete <?php echo $ttTeam->getRow('name'); ?>">Delete</a></td>

		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>