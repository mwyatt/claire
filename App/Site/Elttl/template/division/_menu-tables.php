<?php if (!empty($years)) : ?>
	
	<select name="year" class="js-select-year" class="select-years">
	
	<?php foreach ($years as $yearUnique) : ?>
	
		<option value="<?php echo $yearUnique->name ?>" <?php echo empty($year) ? '' : ($year->id == $yearUnique->id ? 'selected' : '') ?>>Season <strong><?php echo $yearUnique->getNameFull() ?></strong></option>

	<?php endforeach ?>

	</select>

<?php endif ?>
<?php if (isset($division)) : ?>
	<?php $menu = [
        'league' => 'League',
        'merit-doubles' => 'Doubles Merit',
        'merit' => 'Merit'
    ] ?>

<div class="block-clear menu-tables">

<?php foreach ($menu as $slug => $name) : ?>

	<div class="menu-tables-option-container">
		<a href="<?php echo $this->url->generate('result/year/division/' . $slug, ['yearName' => $yearSingle->name, 'divisionName' => strtolower($division->name)]) ?>" class="menu-tables-option button-primary"><?php echo $name ?></a>
	</div>

<?php endforeach ?>

</div>

<?php endif ?>
