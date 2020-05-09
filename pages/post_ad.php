<?php
	$ref = urlencode($_SERVER['REQUEST_URI']);
	if(!$session->is_logged_in()){redirect_to(url_root."login?ref={$ref}");}
?>
<?php page_header("Create Ad");?>
<?php include(doc_root."nav.php"); ?>
<?php

if(isset($_POST['submit'])){
  $category = trim((int)$_POST['category']);
  $title = trim($_POST['title']);
  $summary = trim($_POST['summary']);
  $price = trim($_POST['price']);
  $product = new Products();
  $product->attach_file($_FILES['fileselect']);
  $product->category_id = $category;
  $product->title = $title;
  $product->approved=true;
  $product->price = $price;
  $product->region = trim((int)$_POST['region']);
  $product->slug = str_replace(array(" ", "'"), array("-", ""), $title);
  $product->summary = $summary;
  if($product->save()){
     $session->message("Product Created Successfully");
	 redirect_to(url_root."myads");
  }else{
    $session->message(join("<br>", $product->errors));
	redirect_to(url_root."post_ad");
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
    <h2 class="head">Post an Ad</h2>
    <div class="post-ad-form">
    	<?php if(!empty($message)){echo "<div class=\"alert alert-info\">{$message}</div>";}; ?>
      <form enctype="multipart/form-data" action="post_ad" method="post">
        <label>Select Category <span>*</span></label>
        <select  data-validation="required" data-validation-error-msg="Select a category" data-validation-error-msg-container="#category-error" name="category">
          <option value="">Select Category</option>
          <?php $categories = Categories::find_all_by_order('title', 'asc'); ?>
          <?php foreach($categories as $category):?>
          <option value="<?php echo $category->id;?>"><?php echo $category->title; ?></option>
          <?php endforeach; ?>
        </select>
        <div id="category-error" class="clearfix"></div>
        <label>Ad Title <span>*</span></label>
        <input data-validation="required" data-validation-error-msg-container="#title-err" name="title" type="text" class="phone" placeholder="" value="<?php echo htmlentities($title); ?>">
        <div id="title-err" class="clearfix"></div>
        <label>Price <span>*</span></label>
        <input data-validation="required number" data-validation-error-msg-number="You need to enter a number for price" data-validation-error-msg-container="#price-err" name="price" type="text" class="phone" placeholder="" value="<?php echo htmlentities($price); ?>">
        <div id="price-err" class="clearfix"></div>
        <label>Ad Description <span>*</span></label>
        <textarea data-validation="required" data-validation-error-msg-container="#summary-err" name="summary" class="mess" placeholder="Write few lines about your product"><?php echo htmlentities($summary); ?></textarea>
        <div id="summary-err" class="clearfix"></div>
        <div class="upload-ad-photos">
          <label>Photos for your ad (At Least 3 Pictures)<span>*</span></label>
          <div class="photos-upload-view">
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="10000000" />
            <div>
              <input type="file" id="fileselect" name="fileselect[]" accept="image/*" 
              data-validation="required size mime"
              data-validation-allowing="jpg, jpeg, gif, png"
              data-validation-max-size = "10M"
              data-validation-error-msg-required = "You must add an image"
              data-validation-error-msg-size = "Maximum image size is 10MB"
              data-validation-error-msg-mime = "Invalid file type"
              />
              <div id="filedrag">or drop files here</div>
            </div>
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="10000000" />
            <div>
              <input type="file" id="fileselect" name="fileselect[]" accept="image/*" 
              data-validation="required size mime"
              data-validation-allowing="jpg, jpeg, gif, png"
              data-validation-max-size = "10M"
              data-validation-error-msg-required = "You must add an image"
              data-validation-error-msg-size = "Maximum image size is 10MB"
              data-validation-error-msg-mime = "Invalid file type"
              />
              <div id="filedrag">or drop files here</div>
            </div>
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="10000000" />
            <div>
              <input type="file" id="fileselect" name="fileselect[]" accept="image/*" 
              data-validation="required size mime"
              data-validation-allowing="jpg, jpeg, gif, png"
              data-validation-max-size = "10M"
              data-validation-error-msg-required = "You must add an image"
              data-validation-error-msg-size = "Maximum image size is 10MB"
              data-validation-error-msg-mime = "Invalid file type"
              />
            </div>
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="10000000" />
            <div>
              <input type="file" id="fileselect" name="fileselect[]" accept="image/*" 
              data-validation="size mime"
              data-validation-allowing="jpg, jpeg, gif, png"
              data-validation-max-size = "10M"
              data-validation-error-msg-size = "Maximum image size is 10MB"
              data-validation-error-msg-mime = "Invalid file type"
              />
            </div>	
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="10000000" />
            <div>
              <input type="file" id="fileselect" name="fileselect[]" accept="image/*" 
              data-validation="size mime"
              data-validation-allowing="jpg, jpeg, gif, png"
              data-validation-max-size = "10M"
              data-validation-error-msg-size = "Maximum image size is 10MB"
              data-validation-error-msg-mime = "Invalid file type"
              />
            </div>		
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="10000000" />
            <div>
              <input type="file" id="fileselect" name="fileselect[]" accept="image/*" 
              data-validation="size mime"
              data-validation-allowing="jpg, jpeg, gif, png"
              data-validation-max-size = "10M"
              data-validation-error-msg-size = "Maximum image size is 10MB"
              data-validation-error-msg-mime = "Invalid file type"
              />
            </div>		
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="10000000" />
            <div>
              <input type="file" id="fileselect" name="fileselect[]" accept="image/*" 
              data-validation="size mime"
              data-validation-allowing="jpg, jpeg, gif, png"
              data-validation-max-size = "10M"
              data-validation-error-msg-size = "Maximum image size is 10MB"
              data-validation-error-msg-mime = "Invalid file type"
              />
            </div>					
          </div>
          <div class="clearfix"></div>
        </div>
        <label>Select State <span>*</span></label>
        <select id="state" data-validation="required" data-validation-error-msg="Select a state" data-validation-error-msg-container="#stateErr" name="state">
          <option value="">Select State</option>
          <?php $states = States::find_all_by_order('state', 'asc'); ?>
          <?php foreach($states as $state):?>
          <option value="<?php echo $state->id;?>"><?php echo $state->state; ?></option>
          <?php endforeach; ?>
        </select>
        <div id="stateErr" class="clearfix"></div>
         <label>Select Region <span>*</span></label>
        <select id="lga" data-validation="required" data-validation-error-msg="Select a region" data-validation-error-msg-container="#regionErr" name="region">
          <option value="">Select LGA</option>
        </select>
        <div id="regionErr" class="clearfix"></div>
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
