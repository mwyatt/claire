<?php include $this->getTemplatePath('_header') ?>

<div class="page fixture-single js-page-fixture-single">
	<p class="fixture-single-time">Fulfilled on <?php echo date('D jS F Y', $fixture->timeFulfilled); ?></p>
	<h1 class="page-primary-title"><?php echo $teamLeft->name ?> vs <?php echo $teamRight->name ?></h1>
	<!-- <p><?php echo $division->name ?> division</p> -->
	<table class="elttl-table is-encounter">

<?php include $this->getTemplatePath('_encounters') ?>

		<tr class="elttl-table-row">
			<td class="elttl-table-cell is-score-total" colspan="2"><?php echo $fixtureResult->scoreLeft ?></td>
			<td class="elttl-table-cell is-score-total" colspan="2"><?php echo $fixtureResult->scoreRight ?></td>
		</tr>
	</table>
</div>

<?php include $this->getTemplatePath('_footer') ?>
