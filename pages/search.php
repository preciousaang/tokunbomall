<?php 
$keyword = isset($_GET['q'])?$_GET['q']:null;
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$per_page = 20;
$total_count = Products::count_search_products($keyword);
$pagination = new Pagination($page, $per_page, $total_count);
$products = Products::find_search_products_by_pagination($keyword, $per_page, $pagination->offset());
$data = array();
$data['q'] = $keyword;
?>
<?php page_header("Product Search")?>
<?php include(doc_root."nav.php"); ?>
<?php include(doc_root."banner.php"); ?>

<div class="total-ads main-grid-border">
  <div class="container">
    <?php include(doc_root."select-box.php"); ?>
    <ol class="breadcrumb" style="margin-bottom: 5px;">
      <li><a href="index.php">Home</a></li>
      <li><a href="categories.php">Categories</a></li>
      <li class="active">Cars</li>
    </ol>
    <div class="ads-grid">
      <div class="side-bar col-md-3">
        <div class="featured-ads">
          <h2 class="sear-head fer">Trending Ads</h2>
          <?php $trend_p = Products::find_all_trends();foreach($trend_p as $trend):?>
          <div class="featured-ad"> <a href="<?php echo url_root."single/".$trend->id."/{$trend->slug}";?>">
            <?php $img_arr = json_decode($trend->product_image); ?>
            <div class="featured-ad-left"> <img src="<?php echo url_root. "{$trend->upload_dir}/". $img_arr[0]; ?>" title="ad image" alt="" /> </div>
            <div class="featured-ad-right">
              <h4><?php echo $trend->title; ?></h4>
              <p>₦<?php echo $trend->price; ?></p>
            </div>
            <div class="clearfix"></div>
            </a> </div>
          <?php endforeach;?>
        </div>
      </div>
      <div class="ads-display col-md-9">
        <div class="wrapper">
          <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
              <li role="presentation" class="active"> <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"> <span class="text">All Ads</span> </a> </li>
              <li role="presentation" class="next"> <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile"> <span class="text">Ads with Photos</span> </a> </li>
              <li role="presentation"> <a href="#samsa" role="tab" id="samsa-tab" data-toggle="tab" aria-controls="samsa"> <span class="text">Company</span> </a> </li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                <div>
                  <div id="container">
                    <div class="view-controls-list" id="viewcontrols">
                      <label>view :</label>
                      <a class="gridview"><i class="glyphicon glyphicon-th"></i></a> <a class="listview active"><i class="glyphicon glyphicon-th-list"></i></a> </div>
                    <div class="sort">
                      <div class="sort-by">
                        <label>Sort By : </label>
                        <select>
                          <option value="">Most recent</option>
                          <option value="">Price: Rs Low to High</option>
                          <option value="">Price: Rs High to Low</option>
                        </select>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <!--List--->
                    
                    <ul class="list">
                    	<?php if(empty($products)){
                    		echo "No product matches your search";
                    	}
                    	?>
                      <?php foreach($products as $product):?>
                      <a href="<?php echo url_root."single/{$product->id}/{$product->slug}";?>">
                      <?php $img = json_decode($product->product_image)[0]; ?>
                      <li> <img src="<?php echo url_root.$product->upload_dir."/{$img}"; ?>" title="" alt="" />
                        <section class="list-left">
                          <h5 class="title"><?php echo $product->title; ?></h5>
                          <span class="adprice">₦<?php echo $product->price; ?></span>
                          <p class="catpath">Cars » Other Vehicles</p>
                        </section>
                        <section class="list-right"> <span class="date"><?php echo timeago($product->upload_time); ?></span> <span class="cityname"><?php echo $product->find_product_region(); ?></span> </section>
                        <div class="clearfix"></div>
                      </li>
                      </a>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <ul class="pagination pagination-sm">
                <?php
              	if($pagination->total_pages()>1){
	              	
	              		$uri = "search";
	              	
	              	$data['page'] = $pagination->last_page();
	              	$param = http_build_query($data);
	              	              	
	              		if($pagination->has_previous_page()){
	              			echo "<li><a href=\"".url_root.$uri."?{$param}"."\">Prev</a></li>";
	              		}
	              	
					?>
                <?php
						for($i=1; $i<=$pagination->total_pages(); $i++){
							$data['page'] = $i;
							$param = http_build_query($data);
							if($i==$page){
								echo " <li><span class=\"selected\">{$i}</span><li>";
							}else{
								echo " <li><a href=\"".url_root."{$uri}?{$param}\">{$i}</a><li>";
							}
						}
						
					if($pagination->has_next_page()){
						echo "<li><a href=\"".url_root.$uri."?{$param}\">Next</a></li>";
					}
				}
				?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<?php include_script("jquery.min.js"); ?>
<?php include_script("bootstrap.min.js"); ?>
<?php include_script("bootstrap-select.js"); ?>
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
<?php include_script("jquery.leanModal.min.js"); ?>
<?php include_script("jquery.uls.data.js"); ?>
<?php include_script("jquery.uls.data.utils.js"); ?>
<?php include_script("jquery.uls.lcd.js"); ?>
<?php include_script("jquery.uls.languagefilter.js"); ?>
<?php include_script("jquery.uls.regionfilter.js"); ?>
<?php include_script("jquery.uls.core.js"); ?>
<?php include_script("jquery.form-validator.min.js"); ?>
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
<?php include_script("js/tabs.js"); ?>
<script>
$('#myModal').modal('');
</script> 
<script type="text/javascript">
$(document).ready(function () {    
var elem=$('#container ul');      
	$('#viewcontrols a').on('click',function(e) {
		if ($(this).hasClass('gridview')) {
			elem.fadeOut(1000, function () {
				$('#container ul').removeClass('list').addClass('grid');
				$('#viewcontrols').removeClass('view-controls-list').addClass('view-controls-grid');
				$('#viewcontrols .gridview').addClass('active');
				$('#viewcontrols .listview').removeClass('active');
				elem.fadeIn(1000);
			});						
		}
		else if($(this).hasClass('listview')) {
			elem.fadeOut(1000, function () {
				$('#container ul').removeClass('grid').addClass('list');
				$('#viewcontrols').removeClass('view-controls-grid').addClass('view-controls-list');
				$('#viewcontrols .gridview').removeClass('active');
				$('#viewcontrols .listview').addClass('active');
				elem.fadeIn(1000);
			});									
		}
	});
});
</script>
<?php include_script("jquery-ui.js"); ?>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
 $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 9000,
      values: [ 50, 6000 ],
      slide: function( event, ui ) {  $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
 });
$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );

});//]]>  

$(document).ready(function(){
	$.validate({});
	state = $("#selectRegion").val();
	
	category = $("#selectCategory").val();
	$("#selectRegion").change(function(){
		state = $(this).val();
		window.location.assign("<?php echo url_root?>classified/"+category+"?state="+state);
	});
	$("#selectCategory").change(function(){
		category = $(this).val();
		window.location.assign("<?php echo url_root?>classified/"+category);
	});
	
});

</script>
<?php include(doc_root."footer.php")?>
