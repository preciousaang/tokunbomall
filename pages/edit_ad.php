<?php
	$ref = urlencode($_SERVER['REQUEST_URI']);
	if(!$session->is_logged_in()){redirect_to(url_root."login?ref={$ref}");}
	if(!isset($_GET['id'])){
		$session->message("No product id given");
		redirect_to(url_root."myads");
	}
?>
<?php page_header("Edit Ad");?>
<?php include(doc_root."nav.php"); ?>
<?php
$product = Products::find_by_id($_GET['id']);
if(isset($_POST['submit'])){
  $category = trim((int)$_POST['category']);
  $title = trim($_POST['title']);
  $summary = trim($_POST['summary']);
  $price = trim($_POST['price']);
  $product->category_id = $category;
  $product->title = $title;
  $product->price = $price;
  $product->slug = str_replace(array(" ", "'"), array("-", ""), $title);
  $product->summary = $summary;
  if($product->save()){
     $session->message("Edited Successfully");
	 redirect_to(url_root."edit_ad?id=".urlencode($product->id));
  }else{
    $session->message($product->errors);
  }
}else{
  $title = "";
  $price = "";
  $summary = "";
}

?>
<?php include(doc_root."banner.php"); ?>
<!-- Submit Ad -->
<style>
#title-err, #summary-err, #category-error, #stateErr, #regionErr, #price-err {
	clear: both;
	padding-left: 20%;
}
</style>
<div class="submit-ad main-grid-border">
  <div class="container">
    <h2 class="head">Edit Your Ad</h2>
    <div class="post-ad-form">
    	<?php if(!empty($message)){
    		echo "<div class=\"alert alert-info\">{$message}</div>";
    	}?>
      <form enctype="multipart/form-data" action="<?php echo url_root."edit_ad?id=".urlencode($_GET['id']); ?>" method="post">
        <label>Select Category <span>*</span></label>
        <select data-validation="required" data-validation-error-msg="Select a category" data-validation-error-msg-container="#category-error" name="category">
          <option value="">Select Category</option>
          <?php $categories = Categories::find_all_by_order('title', 'asc'); ?>
          <?php foreach($categories as $category):?>
          <option <?php if($product->category_id==$category->id){echo " selected";}?> value="<?php echo $category->id;?>"><?php echo $category->title; ?></option>
          <?php endforeach; ?>
        </select>
        <div id="category-error" class="clearfix"></div>
        <label>Ad Title <span>*</span></label>
        <input data-validation="required" data-validation-error-msg-container="#title-err" name="title" type="text" class="phone" placeholder="" value="<?php echo htmlentities($product->title); ?>">
        <div id="title-err" class="clearfix"></div>
        <label>Price <span>*</span></label>
        <input data-validation="required" data-validation-error-msg-container="#price-err" name="price" type="text" class="phone" placeholder="" value="<?php echo htmlentities($product->price); ?>">
        <div id="price-err" class="clearfix"></div>
        <label>Ad Description <span>*</span></label>
        <textarea data-validation="required" data-validation-error-msg-container="#summary-err" name="summary" class="mess" placeholder="Write few lines about your product"><?php echo htmlentities($product->summary); ?></textarea>
        <div id="summary-err" class="clearfix"></div>
        <p class="post-terms">By clicking <strong>post Button</strong> you accept our <a href="terms.html" target="_blank">Terms of Use </a> and <a href="privacy.html" target="_blank">Privacy Policy</a></p>
        <input name="submit" type="submit" value="Post">
        <div class="clearfix"></div>
      </form>
    </div>
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
<?php include_script("easyResponsiveTabs.js"); ?>
<?php include_script("jquery.form-validator.min.js"); ?>
<?php include_script("mform.js"); ?>
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
	$.validate();
});
</script>
<?php include(doc_root."footer.php"); ?>
