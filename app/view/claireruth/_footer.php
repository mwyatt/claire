        </div> <!-- .container-site -->
		<footer class="container-footer clearfix">
			<div class="container-footer-inner">
				<div id="search">

<?php include($this->pathView('_search')) ?>

				</div>
				<div id="menu">

<?php include($this->pathView('_menu')) ?>

				</div>
					
<?php //include($this->pathView('_calling-card')) ?>

			</div>
		</footer>

		</div> <!-- .container -->
        <script src="<?php echo $this->getUrlJs('exclude.jquery-2.1.1.js?v=1') ?>"></script>
        <script src="<?php echo $this->getUrl() ?>asset/main.min.js?v=1"></script>
    </body>
</html>
