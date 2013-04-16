<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content page new">

	<h1>New Page</h1>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="title" placeholder="Title" maxlength="75">
		</div>			

		<p class="slug"><a href="#"></a></p>

		<div class="row">
			<div id="toolbar" style="display: none;">
				<a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
				<a data-wysihtml5-command="italic" title="CTRL+I">italic</a>
				<a data-wysihtml5-action="change_view">switch to html view</a>
			</div>
			<textarea id="textarea" placeholder="Enter text ..." name="html"></textarea>
		</div>

		<div class="row">
			<label for="status">Visibility</label>
			<input id="status" type="checkbox" name="status" value="visible">
		</div>

		<input name="form_page_new" type="hidden" value="true">
		<a href="#" onclick="this.submit()">Save</a>
		<input type="submit">
		
	</form>

</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>