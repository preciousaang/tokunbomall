<?php page_header("Sitemap"); ?>
<?php include(doc_root."nav.php"); ?>
<?php include(doc_root."banner.php"); ?>
	<!-- Feedback -->
	<div class="feedback main-grid-border">
		<div class="container">
			<h2 class="head">Feedback</h2>
			<div class="feed-back">
				<h3>Tell us what you think of us</h3>
				<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
				<div class="feed-back-form">
					
				
					<form action="<?php url_root."feedback" ?>" method="post">
					<span>User Details</span>
							<input type="text" value="Full Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Full Name';}">
							
							<input type="text" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}">
							
							<span>Is there anything you would like to tell us?</span>
							<textarea type="text" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message...';}" required>Message...</textarea>
							<input type="submit" value="submit">
						</form>
				</div>
			</div>
		</div>	
	</div>
	<!-- // Feedback -->
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