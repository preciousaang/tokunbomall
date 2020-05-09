<?php
//workpagination
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$total_count = Products::count_all();
$pagination = new Pagination($page, $per_page, $total_count);
//check url stuff
if(isset($action[1])){
	if($action[1] != 'all'){
		$slug = $action[1];
		$categ = Categories::find_by_slug($slug);
		if($categ){
			if(isset($_GET['state'])){
				$arr = array('region'=>$_GET['state'], 'category_id'=>$categ->id);
				$total_count = Products::count_products_by_query($arr);
				$pagination = new Pagination($page, $per_page, $total_count);
				$array = array('region'=>$_GET['state'], 'category_id'=>$categ->id, 'upload_time'=>'desc', 'limit'=>20, 'offset'=>$pagination->offset());
				$products = Products::find_products_by_region($array);
				
			}else{
				$arr = array('category_id'=>$categ->id);
				$total_count = Products::count_products_by_query($arr);
				$pagination = new Pagination($page, $per_page, $total_count);
				$array = array('category_id'=>$categ->id, 'upload_time'=>'desc', 'limit'=>20, 'offset'=>$pagination->offset());
				$products = Products::find_products_by_region($array);
			}
		}else{
			die404();
		}		
	}else{
		$categ = Categories::find_all_by_order('title', 'asc');
		//continue from stoppage
		$arr = isset($_GET['state']) ? array('region'=>$_GET['state']) : array('region'=>null);
		$ttotal_count = Products::count_all_products_by_query($arr);
		$pagination = new Pagination($page, $per_page, $ttotal_count);		
		$products = Products::find_all_products_by_region_in_order($arr, 20, $pagination->offset());
	}
}else{die404();}
$data = array();
if(isset($_GET['state'])){
	$data['state'] = $_GET['state'];
}
?>
<?php if(!is_array($categ)){page_header($categ->title);}else{page_header("All Ads");} ?>
<?php include(doc_root."nav.php")?>
<?php include(doc_root."banner.php"); ?>
<!-- Cars -->
<div class="total-ads main-grid-border">
  <div class="container">
<?php include(doc_root."select-box.php"); ?>
    <ol class="breadcrumb" style="margin-bottom: 5px;">
      <li><a href="<?php echo url_root;?>index.php">Home</a></li>
      
      <li class="active"><?php echo $categ->title;?></li>
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
              <p>₦<?php echo number_format($trend->price); ?></p>
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
            </ul>
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                <div>
                  <div id="container">
                    <div class="view-controls-list" id="viewcontrols">
                      <label>view :</label>
                      <a class="gridview"><i class="glyphicon glyphicon-th"></i></a> <a class="listview active"><i class="glyphicon glyphicon-th-list"></i></a> </div>
                    <div class="clearfix"></div>
                    <!--List--->
                    
                    <ul class="list">
                    	<?php if(empty($products)){
                    		echo "No Products in this category";
                    	}
                    	?>
                      <?php foreach($products as $product):?>
                      <a href="<?php echo url_root."single/{$product->id}/{$product->slug}";?>">
                      <?php $img = json_decode($product->product_image)[0]; ?>
                      <li> <img src="<?php echo url_root.$product->upload_dir."/{$img}"; ?>" title="" alt="" />
                        <section class="list-left">
                          <h5 class="title"><?php echo $product->title; ?></h5>
                          <span class="adprice">₦<?php echo number_format($product->price); ?></span>
                          <p class="catpath">Buying and Selling made Easier and Faster</p>
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
	              	if(isset($action[1])){
	              		$uri = "classified/{$action[1]}";
	              	}else{
	              		$uri = "classified/".basename(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')));
	              	}
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
