<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="players">
	
	<h2>Players</h2>

	<nav>
		<ul>
			<li>
				<a href="<?php echo $this->urlCurrent(); ?>new/" title="(Ajax) Open New Panel">New</a>
			</li>
		</ul>
	</nav>

	<?php echo $this->getFeedback(); ?>

	<?php if ($ttPlayer->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th>Select</th>
			<th>Name</th>
			<th>Rank</th>
			<th>Team</th>
			<th>Action</th>
		</tr>

		<?php while ($ttPlayer->nextRow()) : ?>

		<tr data-id="<?php echo $ttPlayer->getRow('id'); ?>">

			<td>
				<input type="checkbox" name="id" value="<?php echo $ttPlayer->getRow('id'); ?>">
			</td>

			<td>
				<a href="<?php echo $this->urlCurrent(); ?>?update=<?php echo $ttPlayer->getRow('id'); ?>" title="(Ajax) Open Edit Panel"><?php echo $ttPlayer->getRow('full_name'); ?></a>
			</td>

			<td title="(Ajax) Turn in to a input field and OK button"><?php echo $ttPlayer->getRow('rank'); ?></td>

			<td><?php echo $ttPlayer->getRow('team_name'); ?></td>

			<td><?php echo $ttPlayer->getRow('division_name'); ?></td>

			<td><a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $ttPlayer->getRow('id'); ?>" title="Delete <?php echo $ttPlayer->getRow('full_name'); ?>">Delete</a></td>

		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>