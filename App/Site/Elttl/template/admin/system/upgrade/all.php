<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title">System/Upgrade</h1>

<?php if (!empty($versionsUnpatched)) : ?>

	<div class="typography">
		<h2>Upgrade Available</h2>
		<p>There are <?php echo count($versionsUnpatched) ?> new update(s).</p>
	</div>
	<table class="table mb1">

	<?php foreach ($versionsUnpatched as $patch) : ?>
		
		<tr>
			<td><?php echo $patch['filename'] ?></td>
		</tr>

	<?php endforeach ?>

	</table>
	<form>
		<button name="update" value="true" class="button-primary">Upgrade</button>
	</form>

<?php else : ?>

	<div class="blankslate">
		<p>No upgrades currently.</p>
	</div>

<?php endif ?>

</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
