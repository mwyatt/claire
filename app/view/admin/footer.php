<div class="line-top">
	<div class="container">
		
		<footer class="base">
		
			<p>Footer Since 1988</p>
		
		</footer>
		
	</div>
</div>


<!-- Scripts
================================================== -->

<script src="<?php echo $this->urlHome(); ?>asset/script/vendor/jquery-1.8.0.min.js"></script>
<script src="<?php echo $this->urlHome(); ?>asset/script/vendor/modernizr-2.6.1.min.js"></script>
<script src="<?php echo $this->urlHome(); ?>asset/script/main.js"></script>


<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo $view->urlHome(); ?>media/plugin/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks"
	});
</script>
<!-- /TinyMCE -->	
	
</body>
</html>