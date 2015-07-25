<?php if (!empty($division) && !empty($year)) : ?>

<a href="<?php echo $this->url->generate('result/year/division/single', ['yearName' => $year->name, 'divisionName' => strtolower($division->name)]) ?>" class="division">
	<span class="division-image"><?php include $this->getAssetPath('trophy.svg') ?></span>
	<span class="division-name"><?php echo $division->name ?></span>
</a>

<?php endif ?>
