<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="fixtures">
	
	<h2>fixtures</h2>

	<nav>
		<ul>
			<li>
				<a href="#" title="(Ajax) Open New Panel">New</a>
			</li>
		</ul>
	</nav>

	<?php if ($ttFixture->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th>Select</th>
			<th>Name</th>
			<th>Rank</th>
			<th>Team</th>
			<th>Action</th>
		</tr>

		<?php while ($ttFixture->nextRow()) : ?>

		<tr data-id="<?php echo $ttFixture->getRow('player_id'); ?>">

			<td>
				<input type="checkbox" name="player_id" value="<?php echo $ttFixture->getRow('player_id'); ?>">
			</td>

			<td>
				<a href="#" title="(Ajax) Open Edit Panel"><?php echo $ttFixture->getRow('player_name'); ?></a>
			</td>

			<td title="(Ajax) Turn in to a input field and OK button"><?php echo $ttFixture->getRow('player_rank'); ?></td>

			<td><?php echo $ttFixture->getRow('team_name'); ?></td>

			<td><?php echo $ttFixture->getRow('division_name'); ?></td>

			<td><a href="#" title="(Ajax) Delete Player">Delete</a></td>

		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>