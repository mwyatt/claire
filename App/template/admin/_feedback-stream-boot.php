<?php if (isset($feedback)): ?>

<script type="text/javascript">

	var feedback = {
		message: '<?php echo isset($feedback['message']) ? $feedback['message'] : '' ?>',
		type: '<?php echo isset($feedback['type']) ? $feedback['type'] : '' ?>'
	};
	var feedbackStream = new FeedbackStream;
	feedbackStream.createMessage(feedback);

</script>

<?php endif ?>
