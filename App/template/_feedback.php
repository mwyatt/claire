<?php if (isset($feedback)): ?>
	<?php if (isset($feedback['message']) && isset($feedback['type'])): ?>
		
<div class="feedback-container<?php echo isset($feedback['type']) ? ' is-' . $feedback['type'] : '' ?> js-dismiss" title="Dismiss me">
	<p class="feedback-description"><?php echo $feedback['message'] ?></p>
</div>

	<?php endif ?>
<?php endif ?>
