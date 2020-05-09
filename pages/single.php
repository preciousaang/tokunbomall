<?php
if(isset($action[1]) && isset($action[2])){
	$product = Products::find_product_by_id_with_slug($action[1], $action[2]);
	if(isset($product) && $product->approved){
		$product->views += 1;
		$product->update();
	}else{
		die404();
	}
}else{
	die404();
}

?>

<?php page_header($product->title); ?>
<?php include(doc_root."nav.php"); ?>
<?php include(doc_root."banner.php"); ?>
<?php $prod_user = User::find_by_id($product->user_id); ?>
<div class="single-page main-grid-border">
  <div class="container">
    <ol class="breadcrumb" style="margin-bottom: 5px;">
      <li><a href="<?php echo url_root; ?>">Home</a></li>
      <li><a href="<?php echo url_root. "classified/all"; ?>">All Ads</a></li>
      <li class="active"><?php echo $product->title;?></li>
    </ol>
    <div class="product-desc">
      <div class="col-md-7 product-view">
        <h2><?php echo $product->title; ?></h2>
        
        <p> <i class="glyphicon glyphicon-map-marker"></i><a href="#"><?php echo str_replace(" State", "", $product->find_product_state()); ?></a>, <a href="#"><?php echo $product->find_product_region(); ?></a>| Added at <?php echo $product->upload_time; ?>, Ad ID: <?php echo $product->id; ?></p>
        <div class="flexslider slides">
          <ul class="slides">
            <?php
        		$img_array = json_decode($product->product_image);
				foreach($img_array as $key=>$value):
				$test = explode('.', $value);
				if(strlen($test[1])>2){
        	?>
            <li data-thumb="<?php echo url_root.$product->upload_dir."/{$value}"; ?>"> <img src="<?php echo url_root.$product->upload_dir."/{$value}"; ?>" /> </li>
				<?php } endforeach; ?>
          </ul>
        </div>
        
        <!-- //FlexSlider -->
        <div class="product-details">
          <h4>Brand : <a href="#"><?php echo $product->title; ?></a></h4>
          <h4>Views : <strong><?php echo $product->views; ?></strong></h4>
          <p><strong>Summary</strong> : <?php echo nl2br(strip_tags($product->summary)); ?></p>
        </div>
      </div>
      <div class="col-md-5 product-details-grid">
        <div class="item-price">
          <div class="product-price">
            <p class="p-price">Price</p>
            <h3 class="rate">₦<?php echo number_format($product->price); ?></h3>
            <div class="clearfix"></div>
          </div>
          <div class="condition">
            <p class="p-price">Condition</p>
            <h4>Fairly used</h4>
            <div class="clearfix"></div>
          </div>
          <div class="itemtype">
            <p class="p-price">Item Type</p>
            <h4><?php echo $product->find_product_category(); ?></h4>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="interested text-center">
          <h4>Interested in this Ad?<small> Contact the Seller!</small></h4>
          <p><i class="glyphicon glyphicon-earphone"></i><?php echo $prod_user->phone; ?></p>
        </div>
        <div class="tips">
          <h4>Safety Tips for Buyers</h4>
          <ol>
            <li><a href="#">Do not pay before getting what you want to buy.</a></li>
            <li><a href="#">Thoroughly check what you want to buy before paying.</a></li>
            <li><a href="#">Always endeavour to meet in a public place to carry out any exchange.</a></li>
          </ol>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!--//single-page--> 
<!-- js -->
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
<?php include_script("jquery.flexslider.js"); ?>
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
	animation: "slide",
	controlNav: "thumbnails"
  });
});
</script> 
<script>
$('#myModal').modal('');	
</script> 
<script>
  $(document).ready(function () {
    var mySelect = $('#first-disabled2');

    $('#special').on('click', function () {
      mySelect.find('option:selected').prop('disabled', true);
      mySelect.selectpicker('refresh');
    });

    $('#special2').on('click', function () {
      mySelect.find('option:disabled').prop('disabled', false);
      mySelect.selectpicker('refresh');
    });

    $('#basic2').selectpicker({
      liveSearch: true,
      maxOptions: 1
    });
  });
</script> 
<script>
$( document ).ready( function() {
	$( '.uls-trigger' ).uls( {
		onSelect : function( language ) {
			var languageName = $.uls.data.getAutonym( language );
			$( '.uls-trigger' ).text( languageName );
		},
		quickList: ['en', 'hi', 'he', 'ml', 'ta', 'fr'] //FIXME
	} );
} );
</script>
<?php include(doc_root."footer.php")?>
