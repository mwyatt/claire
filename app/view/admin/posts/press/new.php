<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div id="content" class="post press new">

	<h1>New Press Release</h1>

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
			<textarea id="textarea" placeholder="Enter text ..."></textarea>
		</div>

		<div class="row attachments">			
			<h2>Attachments</h2>
			<a class="add" href="#">Add</a>
		</div>			

		<input name="form_post_new" type="hidden" value="true">
		<input name="type" type="hidden" value="<?php echo $this->config->getUrl(2); ?>">

		<a href="#">Publish</a>
		
	</form>

</div>

<script src="<?php echo $this->urlHome(); ?>js/vendor/wysihtml5/simple.js"></script>
<script src="<?php echo $this->urlHome(); ?>js/vendor/wysihtml5/wysihtml5-0.4.0pre.js"></script>
<script>
  var editor = new wysihtml5.Editor("textarea", {
    toolbar:        "toolbar",
    parserRules:    wysihtml5ParserRules,
    useLineBreaks:  false
  });
</script>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>