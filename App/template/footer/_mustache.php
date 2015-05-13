<?php if (isset($asset['mustache'])): ?>
	<?php foreach ($asset['mustache'] as $path): ?>
		
<script id="<?php echo str_replace('/', '-', $path) ?>" type="x-tmpl-mustache">

<?php echo file_get_contents(SITE_PATH . 'mustache/' . $path . '.mst') ?>

</script>
		
	<?php endforeach ?>
<?php endif ?>
