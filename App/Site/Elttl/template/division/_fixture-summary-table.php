<?php if (!empty($fixtures) && !empty($teams) && !empty($fixtureResults)) : ?>

<table class="elttl-table division-overview-fixture-table">
	<tr class="elttl-table-row">
		<th class="elttl-table-cell elttl-table-heading"></th>

	<?php foreach ($teams as $teamRight) : ?>
		
		<th class="elttl-table-cell elttl-table-heading" title="<?php echo $teamRight->name ?>">
			<a class="link-primary" href="<?php echo $this->url->generate('team/single', ['yearName' => $year->name, 'teamSlug' => $teamRight->slug]) ?>"><?php echo $teamRight->name ?></a>
		</th>

	<?php
endforeach ?>

	</tr>

	<?php foreach ($teams as $teamLeft) : ?>
		
	<tr class="elttl-table-row">
		<th class="elttl-table-cell elttl-table-heading" title="<?php echo $teamLeft->name ?>">
			<a class="link-primary" href="<?php echo $this->url->generate('team/single', ['yearName' => $year->name, 'teamSlug' => $teamLeft->slug]) ?>"><?php echo $teamLeft->name ?></a>
		</th>
		
		<?php foreach ($teams as $teamRight) : ?>
			<?php if ($teamLeft->id == $teamRight->id) : ?>
			
		<td class="elttl-table-cell is-blank"></td>

			<?php
else : ?>

		<td class="elttl-table-cell" title="<?php echo $teamLeft->name . ' vs ' . $teamRight->name ?>">

			<?php foreach ($fixtures as $fixture) : ?>
				<?php if ($fixture->teamIdLeft == $teamLeft->id && $fixture->teamIdRight == $teamRight->id) : ?>
					<?php include($this->getTemplatePath('_fixture')) ?>
				<?php
endif ?>
			<?php
endforeach ?>

		</td>

			<?php
endif ?>
		<?php
endforeach ?>
		
	</tr>

	<?php
endforeach ?>

</table>

<?php else: ?>

	<div class="blankslate">No fixtures have been fulfilled yet.</div>

<?php endif ?>
