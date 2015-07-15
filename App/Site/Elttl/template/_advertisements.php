<div class="advertisements">

<?php $campaign->setSource('advertisements') ?>
<?php $campaign->setMedium('referral') ?>
<?php foreach ($ads as $ad): ?>
	<?php $campaign->setCampaign($ad->name) ?>

	<a href="<?php echo $campaign->get($ad->url) ?>" class="advertisement">
		<h2 class="advertisement-title"><?php echo $ad->name ?></h2>
		<p class="advertisement-description"><?php echo $ad->description ?></p>
	</a>

<?php endforeach ?>

</div>