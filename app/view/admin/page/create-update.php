<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content page <?php echo ($this->get('model_maincontent') ? 'update' : 'create'); ?>">
	<h1><?php echo ($this->get('model_maincontent') ? 'Update' : 'Create'); ?> Page</h1>
	<form class="main" method="post">
		<div class="row">			
			<input class="required" type="text" name="title" placeholder="Title" maxlength="75" value="<?php echo $this->get('model_maincontent', 'title'); ?>">
		</div>			
		<div class="row">
			<div id="toolbar" style="display: none;">
				<a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
				<a data-wysihtml5-command="italic" title="CTRL+I">italic</a>
				<a data-wysihtml5-action="change_view">switch to html view</a>
			</div>
			<textarea id="textarea" placeholder="Enter text ..." name="html" value="<?php echo $this->get('model_maincontent', 'html'); ?>"></textarea>
		</div>
		<div class="row">
			<label for="status">Visibility</label>
			<input id="status" type="checkbox" name="status" value="<?php echo $this->get('model_maincontent', 'status'); ?>">
		</div>
		<input name="form_page_<?php echo ($this->get('model_maincontent') ? 'update' : 'create'); ?>" type="hidden" value="true">
		<a href="#" onclick="this.submit()">Save</a>
		<input type="submit">
	</form>
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>