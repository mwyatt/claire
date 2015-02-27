<script type="text/javascript">
	var feedback = {
		message: '',
		type: ''
	};

<?php if (isset($feedback)): ?>

	feedback = {
		message: "<?php echo isset($feedback['message']) ? $feedback['message'] : '' ?>",
		type: '<?php echo isset($feedback['type']) ? $feedback['type'] : '' ?>'
	};

<?php endif ?>

</script>
