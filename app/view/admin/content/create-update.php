<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content <?php echo $this->urlSegment(2); ?> <?php echo ($this->get('model_maincontent') ? 'update' : 'create'); ?>" data-id="<?php echo $this->get('model_maincontent', 'id'); ?>">
	<h1><?php echo ($this->get('model_maincontent') ? 'Update ' . ucfirst($this->urlSegment(2)) . ' ' . $this->get('model_maincontent', 'title') : 'Create new ' . ucfirst($this->urlSegment(2))); ?></h1>
	<form class="main" method="post"<?php echo ($this->urlSegment(2) == 'minutes' ? ' enctype="multipart/form-data"' : ''); ?>>
		<div class="row">			
			<input class="required" type="text" name="title" placeholder="Title" maxlength="75" value="<?php echo $this->get('model_maincontent', 'title'); ?>">
		</div>			

<?php if ($this->urlSegment(2) != 'minutes'): ?>

		<div class="row">
			<input type="text" name="meta_title" placeholder="Meta Title" maxlength="75" value="<?php echo $this->get('model_maincontent', 'meta_title'); ?>">
		</div>

		<div class="row">
			<div id="toolbar" style="display: none;">
				<a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
				<a data-wysihtml5-command="italic" title="CTRL+I">italic</a>
				<a data-wysihtml5-action="change_view">switch to html view</a>
			</div>
			<textarea id="textarea" placeholder="Enter text ..." name="html"><?php echo $this->get('model_maincontent', 'html'); ?></textarea>
		</div>

<?php endif ?>

		<div class="row media">

<?php if (count($this->get('model_mainmedia')) < 2 || $this->urlSegment(2) != 'minutes'): ?>

			<input type="file" name="media[]"<?php echo ($this->urlSegment(2) == 'minutes' ? '' : ' multiple') ?>>

<?php endif ?>
<?php if ($this->get('model_mainmedia')): ?>

			<div class="attached">
				<h3>Attached Media</h3>
				
	<?php foreach ($this->get('model_mainmedia') as $media): ?>
		
				<div><a href="<?php echo $this->get($media, 'guid') ?>" target="_blank"><?php echo $this->get($media, 'filename') ?></a></div>

	<?php endforeach ?>

			</div>
	
<?php endif ?>

		</div>

		<div class="row">
			<label for="status">Visibility</label>
			<input id="status" type="checkbox" name="status" value="visible"<?php echo ($this->get('model_maincontent', 'status') == 'visible' ? ' checked' : ''); ?>>
		</div>
		<input name="form_<?php echo ($this->get('model_maincontent') ? 'update' : 'create'); ?>" type="hidden" value="true">
		<input name="type" type="hidden" value="<?php echo $this->urlSegment(2); ?>">
		<a href="#" class="submit button">Save</a>
		<input type="submit">
	</form>
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>
