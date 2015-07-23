<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title">System/Tennis</h1>
	<form class="block-margins">
		<p>Creates a copy of previous year except for fixtures, encounters and moves the year forwards 1.</p>
		<button name="newSeason" value="true" class="button-primary">Create New Season</button>
	</form>
	<form class="block-margins">
		<p>Remove then generate all fixtures for current team configuration</p>
		<button name="generateFixtures" value="true" class="button-primary">Generate Fixtures</button>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
