<?php if (isset($division)) : ?>

<div class="block-clear menu-tables">
	<a href="<?php echo $this->url->generate('result/year/division/league', ['yearName' => $year->name, 'divisionName' => strtolower($division->name)]) ?>" class="menu-tables-option button-primary">League</a>
	<a href="<?php echo $this->url->generate('result/year/division/merit-doubles', ['yearName' => $year->name, 'divisionName' => strtolower($division->name)]) ?>" class="menu-tables-option button-primary">Doubles Merit</a>
	<a href="<?php echo $this->url->generate('result/year/division/merit', ['yearName' => $year->name, 'divisionName' => strtolower($division->name)]) ?>" class="menu-tables-option button-primary">Merit</a>
</div>

<?php endif ?>
