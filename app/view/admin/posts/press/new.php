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


<select id="mm" name="mm" tabindex="4">
	<option value="01">Jan</option>
	<option value="02">Feb</option>
	<option value="03">Mar</option>
	<option value="04">Apr</option>
	<option value="05">May</option>
	<option value="06">Jun</option>
	<option value="07">Jul</option>
	<option value="08">Aug</option>
	<option value="09">Sep</option>
	<option value="10">Oct</option>
	<option value="11">Nov</option>
	<option value="12">Dec</option>
</select>

<input type="text" id="jj" name="jj" value="22" size="2" maxlength="2" tabindex="4" autocomplete="off">, <input type="text" id="aa" name="aa" value="2012" size="4" maxlength="4" tabindex="4" autocomplete="off"> @ <input type="text" id="hh" name="hh" value="14" size="2" maxlength="2" tabindex="4" autocomplete="off"> : <input type="text" id="mn" name="mn" value="19" size="2" maxlength="2" tabindex="4" autocomplete="off">




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