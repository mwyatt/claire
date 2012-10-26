<?php require_once($this->skin_dir . '/frontend/common/header.tpl'); ?>

<div id="content" class="page">
	<div class="wrap">
 
		<h1>Contact</h1>
		
		<div class="content">

			<h2>Our Information</h2>
			
			<div class="left col-300">
		
				<div itemscope itemtype="http://schema.org/LocalBusiness">
					<b itemprop="name">Simply Spectral</b>
					<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
						
						<p>
							<span itemprop="streetAddress">Unit 5, The Sidings,</span>
							<br><span itemprop="addressLocality">New Line Industrial Estate,</span>
							<br><span itemprop="addressRegion">Bacup, Lancs,</span>
							<br>OL13 9RW
						</p>
					</div>
				</div>
		
			</div>
		
			<div class="left col-300">
		
				<p><b>Sales Number</b>
				<br>01234 567 891</p>		
		
				<p><b>Opening Hours</b>
				<br>Monday - Friday: 9am - 5pm
				<br>Saturday : 10am - 5pm
				<br>Sunday: Closed</p>		
		
			</div>
			
			<div class="left col-300 last">
			
				<h2 class="enquiry">Make Enquiry</h2>
				
				<?php if ($error) : ?>	
					<div class="message">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>					
				
				<form enctype="multipart/form-data" class="main" method="post" name="formContact" action="/contact">
				
					<div class="row">			
						<input class="required" type="text" name="name" data-default="Full Name" value="Full Name" maxlength='255'>
					</div>			
					
					<div class="row">			
						<input class="required" type="text" name="email" data-default="Email Address" value="Email Address" maxlength='255'>
					</div>			
					
					<div class="row">			
						<input class="required" type="text" name="subject" data-default="Subject" value="Subject" maxlength='255'>
					</div>			
					
					<div class="row">			
						<textarea name="message" placeholder="Your Message"></textarea>
					</div>			
			
					<input class="right" type="image" src="<?php echo $baseUrl; ?>image/main/btn-send.jpg" name="Submit" alt="Send" value="Submit">
					
				</form>		
		
			</div>
			
			<div class="clearfix"></div>
			
			<?php require_once($this->skin_dir . '/frontend/common/location.tpl'); ?>

		</div>
		
	</div>
</div> <!-- content -->

<?php require_once($this->skin_dir . '/frontend/common/footer.tpl'); ?>