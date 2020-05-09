<?php page_header("Sitemap"); ?>
<?php include(doc_root."nav.php"); ?>
<?php include(doc_root."banner.php"); ?>
	<!-- Regions -->
		<div class="container">
			<h2 class="head">Sitemap</h2>
		</div>
		<div class="sitemap-regions">
			<div class="container">
				<div class="sitemap-region-grid">
					<div class="sitemap-region">
						<h6><a href="<?php echo url_root."classified/furniture"; ?>">Furniture</a></h6>
						
					</div>
					<div class="sitemap-region">
						<h6><a href="<?php echo url_root."classified/bikes"; ?>">Bikes</a></h6>
						
					</div>
					<div class="sitemap-region">
						<h6><a href="<?php echo url_root."classified/electronics"; ?>">Electronics & Appliances</a></h6>
						
					</div>
				</div>
				<div class="sitemap-region-grid">		
					<div class="sitemap-region">
						<h6><a href="<?php echo url_root."classified/cars"; ?>">Cars</a></h6>
						
					</div>
					<div class="sitemap-region">
						<h6><a href="<?php echo url_root."classified/pets"; ?>">Pets</a></h6>
						
					</div>
					<div class="sitemap-region">
						<h6><a href="<?php echo url_root."classified/books-sports-hobbies"; ?>">Books, Sports & Hobbies</a></h6>
						
					</div>
				</div>
				<div class="sitemap-region-grid">
					<div class="sitemap-region">					
						<h6><a href="<?php echo url_root."classified/mobiles"; ?>">Mobiles</a></h6>
						
					</div>
					<div class="sitemap-region">					
						<h6><a href="<?php echo url_root."classified/kids"; ?>">Kids</a></h6>
						
					</div>
					<div class="sitemap-region">
						<h6><a href="<?php echo url_root."classified/fashion"; ?>">Fashion</a></h6>
						
					</div>
					
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

<?php include_script("jquery.min.js"); ?>
<?php include_script("bootstrap.min.js"); ?>
<?php include_script("bootstrap-select.js"); ?>
<?php include_script("jquery.leanModal.min.js");?>
<?php include_script("jquery.uls.data.js"); ?>
<?php include_script("jquery.uls.data.utils.js"); ?>
<?php include_script("jquery.uls.lcd.js"); ?>
<?php include_script("jquery.uls.languagefilter.js"); ?>
<?php include_script("jquery.uls.regionfilter.js"); ?>
<?php include_script("jquery.uls.core.js"); ?>
<?php include_script("jquery.flexisel.js"); ?>
<?php include(doc_root."footer.php");?>