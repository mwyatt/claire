<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title">Years</h1>

<?php if (empty($years)) : ?>

	<div class="blankslate typography">
		<p>No years have been created yet.</p>
	</div>

<?php else : ?>
	
	<table class="table">
		<tr>
			<th>Name</th>
		</tr>

	<?php foreach ($years as $year) : ?>

		<tr>
			<td>

		<?php echo $year->name ?>
		<?php if ($year->id == $currentYearId) : ?>
			
				<span class="right">(Current)</span>

		<?php
endif ?>

			</td>
		</tr>

	<?php endforeach ?>

	</table>
	
<?php endif ?>
		
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
