<?php $teamLeft = $teams[$fixture->getTeamIdLeft()] ?>
<?php $teamRight = $teams[$fixture->getTeamIdRight()] ?>
<?php if (isset($fixtureResults[$fixture->getId()])): ?>
	<?php $fixtureResult = $fixtureResults[$fixture->getId()] ?>
	<?php $scoreLeft = $fixtureResult->score_left ?>
	<?php $scoreRight = $fixtureResult->score_right ?>

<a href="<?php echo $this->buildArchiveUrl(array('fixture', $teamLeft->getName() . ' vs ' . $teamRight->getName())) ?>" class="fixture">
	<span class="fixture-score-left"><?php echo $scoreLeft ?></span>
	<span class="fixture-team-left"><?php echo $teamLeft->getName() ?></span>
	<span class="fixture-score-right"><?php echo $scoreRight ?></span>
	<span class="fixture-team-right"><?php echo $teamRight->getName() ?></span>
</a>

<?php endif ?>
