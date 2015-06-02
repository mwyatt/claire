<?php include $this->getTemplatePath('admin/_header') ?>
	<?php $urlCreate = $this->url->generate('admin/user/create') ?>

<div class="page user-all">
	<div class="page-actions">
		<a class="page-action button-primary right" href="<?php echo $urlCreate ?>" title="Create a new User">Create</a>
	</div>
	<h1 class="page-primary-title">Users</h1>

<?php if ($users): ?>

<table class="table">
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Registered</th>
		<th>Level</th>
		<th>Action</th>
	</tr>

	<?php foreach($users as $user): ?>
		<?php $urlEdit = $this->url->generate('admin/user/single', ['id' => $user->getId()]) ?>

	<tr class="user js-user">
		<td><a href="<?php echo $urlEdit ?>"><?php echo $user->getNameFull() ?></a></td>
		<td><a href="mailto:<?php echo $user->getEmail() ?>"><?php echo $user->getEmail() ?></a></td>
		<td><?php echo $user->getTimeRegistered() ?></td>
		<td><?php echo $user->getLevel() ?></td>
		<td>
			<a class="button-edit" href="<?php echo $urlEdit ?>">Edit</a>
			<a class="button-delete" href="<?php echo $this->url->generate('admin/user/all', ['delete' => $user->getId()]) ?>">Delete</a>
		</td>
	</tr>

	<?php endforeach; ?>

</table>

<?php else: ?>
	
	<div class="blankslate typography">
		<p>No users have been created yet, why not <a href="<?php echo $urlCreate ?>">create</a> one now?</p>
	</div>
	
<?php endif ?>
		
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
