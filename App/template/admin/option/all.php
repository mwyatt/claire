<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page option-all">
	<h1 class="page-heading">Settings</h1>

<?php if ($options): ?>

<table class="options-all-table js-options">
	<tr>
		<th>Name</th>
		<th>Value</th>
		<th>Action</th>
	</tr>

	<?php foreach($options as $option): ?>

	<tr class="option js-option" data-id="<?php echo $option->getId() ?>">
		<td><input type="text" class="js-option-input-name" value="<?php echo $option->getName() ?>"></td>
		<td><input type="text" class="js-option-input-value" value="<?php echo $option->getValue() ?>"></td>
		<td>
			<span class="button-delete js-delete">Delete</span>
		</td>
	</tr>

	<?php endforeach; ?>

</table>
	
<?php endif ?>
		
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
