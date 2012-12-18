<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div id="content" class="post press new">

	<h1>New Press Release</h1>

	<form class="main" method="post">

		<div class="row">			
			<input class="required" type="text" name="title" placeholder="Title" maxlength="75">
		</div>			

		<p class="slug"><a href="#"></a></p>

		<div class="row">
			<textarea rows="4" cols="50"></textarea>
		</div>

		<div class="row attachments">			
			<h2>Attachments</h2>
			<a href="#">Add</a>
		</div>			

		<div class="row division">

			<select name="division_id">
				<option value="0">01</option>
			</select>

		</div>

		<div class="row team">
			<select name="team_id">
				<option value="0"></option>
			</select>
		</div>

		<input name="form_post_new" type="hidden" value="true">
		<input name="type" type="hidden" value="post">

		<a href="#">Publish</a>
		
	</form>

</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>