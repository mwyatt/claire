<?php if (isset($teams) && isset($fixtures) && isset($fixtureResults)) : ?>

<table class="elttl-table division-overview-fixture-table">
	<tr class="elttl-table-row">
		<th class="elttl-table-cell elttl-table-heading"></th>

	<?php foreach ($teams as $teamRight) : ?>
		
		<th class="elttl-table-cell elttl-table-heading" title="<?php echo $teamRight->getName() ?>">
			<a href="<?php echo $this->buildArchiveUrl(array('team', $teamRight->getName())) ?>"><?php echo $teamRight->getName() ?></a>
		</th>

	<?php endforeach ?>

	</tr>

	<?php foreach ($teams as $teamLeft) : ?>
		
	<tr class="elttl-table-row">
		<th class="elttl-table-cell elttl-table-heading" title="<?php echo $teamLeft->getName() ?>">
			<a href="<?php echo $this->buildArchiveUrl(array('team', $teamLeft->getName())) ?>"><?php echo $teamLeft->getName() ?></a>
		</th>
		
		<?php foreach ($teams as $teamRight) : ?>
			<?php if ($teamLeft->getId() == $teamRight->getId()) : ?>
			
		<td class="elttl-table-cell is-blank"></td>

			<?php
else : ?>

		<td class="elttl-table-cell" title="<?php echo $teamLeft->getName() . ' vs ' . $teamRight->getName() ?>">

			<?php foreach ($fixtures as $fixture) : ?>
				<?php if ($fixture->getTeamIdLeft() == $teamLeft->getId() && $fixture->getTeamIdRight() == $teamRight->getId()) : ?>
					<?php include($this->getTemplatePath('_fixture')) ?>
				<?php
endif ?>
			<?php endforeach ?>

		</td>

			<?php
endif ?>
		<?php endforeach ?>
		
	</tr>

	<?php endforeach ?>

</table>

<?php endif ?>
