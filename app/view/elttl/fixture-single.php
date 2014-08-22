<?php require_once($this->pathView('_header')) ?>

<div class="page fixture-single js-page-fixture-single">
	<h1 class="page-primary-title"><?php echo $teamLeft->getName() ?> vs <?php echo $teamRight->getName() ?></h1>
	<p><?php echo $division->getName() ?> division</p>
	<p class="fixture-single-time">Fulfilled on <?php echo date('D jS F Y', $fixture->getTimeFulfilled()); ?></p>
	<table class="elttl-table">

<?php include($this->pathView('_encounters')) ?>

		<tr class="elttl-table-row">
			<td class="elttl-table-cell" colspan="2"><?php echo $fixtureResult->score_left ?></td>
			<td class="elttl-table-cell" colspan="2"><?php echo $fixtureResult->score_right ?></td>
		</tr>
	</table>
</div>

<?php require_once($this->pathView('_footer')) ?>
