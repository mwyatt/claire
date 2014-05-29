<?php include($this->pathView('_header')) ?>

<div class="content home">

<?php if ($skills): ?>

	<div class="panel skills">

	<?php foreach ($skills as $skill): ?>

		<div class="skill">

		<?php echo $skill->name ?>

		</div>

	<?php endforeach ?>

	</div>

<?php endif ?>

</div>

<?php include($this->pathView('_footer')) ?>
