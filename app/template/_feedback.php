<?php if (isset($feedback)): ?>
	<?php if (isset($feedback['message'])): ?>
		
<div class="feedback-container<?php echo (array_key_exists('positivity', $feedback) ? ' is-' . $feedback['positivity'] : '') ?> js-dismiss" title="Dismiss me">
	<p class="feedback-description"><?php echo $feedback['message'] ?></p>
</div>

	<?php endif ?>
<?php endif ?>
