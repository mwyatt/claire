<?php if (!empty($fixtureResults[$fixture->id]) && !empty($teams[$fixture->teamIdLeft]) && !empty($teams[$fixture->teamIdRight])) : ?>

<a href="<?php echo $this->url->generate('fixture/single', ['yearName' => $yearSingle->name, 'teamLeftSlug' => $teams[$fixture->teamIdLeft]->slug, 'teamRightSlug' => $teams[$fixture->teamIdRight]->slug]) ?>" class="fixture">
	<span class="fixture-score-left"><?php echo $fixtureResults[$fixture->id]->scoreLeft ?></span>
	<span class="fixture-team-left"><?php echo $teams[$fixture->teamIdLeft]->name ?></span>
	<span class="fixture-score-right"><?php echo $fixtureResults[$fixture->id]->scoreRight ?></span>
	<span class="fixture-team-right"><?php echo $teams[$fixture->teamIdRight]->name ?></span>
	<span class="fixture-time-fulfilled"><?php echo date('d/m/y', $fixtureResults[$fixture->id]->timeFulfilled) ?></span>
</a>

<?php endif ?>
