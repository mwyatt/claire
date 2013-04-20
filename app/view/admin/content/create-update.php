<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content <?php echo ucfirst($this->urlSegment(2)); ?> <?php echo ($this->get('model_maincontent') ? 'update' : 'create'); ?>">
	<h1><?php echo ($this->get('model_maincontent') ? 'Update ' . ucfirst($this->urlSegment(2)) . ' ' . $this->get('model_maincontent', 'title') : 'Create new ' . ucfirst($this->urlSegment(2))); ?></h1>
	<form class="main" method="post"<?php echo ($this->urlSegment(2) == 'minutes' ? ' enctype="multipart/form-data"' : ''); ?>>
		<div class="row">			
			<input class="required" type="text" name="title" placeholder="Title" maxlength="75" value="<?php echo $this->get('model_maincontent', 'title'); ?>">
		</div>			

<?php if ($this->urlSegment(2) != 'minutes'): ?>

		<div class="row">
			<div id="toolbar" style="display: none;">
				<a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
				<a data-wysihtml5-command="italic" title="CTRL+I">italic</a>
				<a data-wysihtml5-action="change_view">switch to html view</a>
			</div>
			<textarea id="textarea" placeholder="Enter text ..." name="html"><?php echo $this->get('model_maincontent', 'html'); ?></textarea>
		</div>

<?php endif ?>

<?php if ($this->urlSegment(2) == 'minutes'): ?>

		<div class="row">
			<input type="file" name="attachments[]" multiple>
		</div>

<?php endif ?>

		<div class="row">
			<label for="status">Visibility</label>
			<input id="status" type="checkbox" name="status" value="visible"<?php echo ($this->get('model_maincontent', 'status') == 'visible' ? ' checked' : ''); ?>>
		</div>
		<input name="form_<?php echo ($this->get('model_maincontent') ? 'update' : 'create'); ?>" type="hidden" value="true">
		<input name="type" type="hidden" value="<?php echo $this->urlSegment(2); ?>">
		<a href="#" onclick="this.submit()">Save</a>
		<input type="submit">
	</form>
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>
