<?php page_header("The Biggest online Market for selling used things");?>
<?php include(doc_root."nav.php"); ?>

<div class="main-banner banner text-center">
  <div class="container">
    <h1>Sell or Advertise <span class="segment-heading"> anything online </span> with TokunboMall</h1>
    <p>The Biggest online Market for selling used things</p>
    <a href="<?php link_page("post_ad"); ?>">Post Free Ad</a> </div>
</div>
<!-- content-starts-here -->
<div class="content">
  <div class="categories">
    <div class="container">
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/mobiles";?>"">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-mobile"></i></div>
            <h4 class="clrchg">Mobiles</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/electronics"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-laptop"></i></div>
            <h4 class="clrchg"> Electronics & Appliances</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/cars"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-car"></i></div>
            <h4 class="clrchg">Cars</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/bikes"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-motorcycle"></i></div>
            <h4 class="clrchg">Bikes</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/furniture"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-wheelchair"></i></div>
            <h4 class="clrchg">Furnitures</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/pets"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-paw"></i></div>
            <h4 class="clrchg">Pets</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/books-sports-hobbies"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-book"></i></div>
            <h4 class="clrchg">Books, Sports & Hobbies</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/fashion"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-asterisk"></i></div>
            <h4 class="clrchg">Fashion</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/kids"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-gamepad"></i></div>
            <h4 class="clrchg">Kids</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/services"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-shield"></i></div>
            <h4 class="clrchg">Services</h4>
          </div>
        </div>
        </a> </div>
      <div class="col-md-2 focus-grid"> <a href="<?php echo url_root."classified/real-estate"; ?>">
        <div class="focus-border">
          <div class="focus-layout">
            <div class="focus-image"><i class="fa fa-home"></i></div>
            <h4 class="clrchg">Real Estate</h4>
          </div>
        </div>
        </a> </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="trending-ads">
    <div class="container"> 
      <!-- slider -->
      <div class="trend-ads">
        <h2>Trending Ads</h2>
        <ul id="flexiselDemo3">
         <li>
          	<?php $offset = 4*(1-1); $trending_ads = Products::find_trending_products($offset);
			foreach($trending_ads as $ad):?> 
            <div class="col-md-3 biseller-column"> <a href="<?php echo url_root."single/{$ad->id}/{$ad->slug}";?>">
              <?php $img = json_decode($ad->product_image)[0]; ?>
              <img width="350" height="250" src="<?php echo url_root.$ad->upload_dir."/{$img}"; ?>" alt="<?php $ad->title; ?>">
              <span class="price">₦<?php echo number_format($ad->price); ?></span> </a>
              <div class="ad-info">
                <h5><?php echo $ad->title;?></h5>
                <span>30 minutes ago</span> </div>
            </div>
            <?php endforeach; ?>
          </li>
          <li>
          	<?php $offset = 4*(2-1); $trending_ads = Products::find_trending_products($offset);
			foreach($trending_ads as $ad):?>
            <div class="col-md-3 biseller-column"> <a href="<?php echo url_root."single/{$ad->id}/{$ad->slug}";?>">
              <?php $img = json_decode($ad->product_image)[0]; ?>
              <img width="350" height="250" src="<?php echo url_root.$ad->upload_dir."/{$img}"; ?>" alt="<?php $ad->title; ?>">
              <span class="price">₦<?php echo number_format($ad->price); ?></span> </a>
              <div class="ad-info">
                <h5><?php echo $ad->title; ?></h5>
                <span>1 hour ago</span> </div>
            </div>
            <?php endforeach; ?>
          </li>
          <li>
          	<?php $offset = 4*(3-1); $trending_ads = Products::find_trending_products($offset);
			foreach($trending_ads as $ad):?>
            <div class="col-md-3 biseller-column"> <a href="<?php echo url_root."single/{$ad->id}/{$ad->slug}";?>">
              <?php $img = json_decode($ad->product_image)[0]; ?>
              <img width="350" height="250" src="<?php echo url_root.$ad->upload_dir."/{$img}"; ?>" alt="<?php $ad->title; ?>">
              <span class="price">₦<?php echo number_format($ad->price); ?></span> </a>
              <div class="ad-info">
                <h5><?php echo $ad->title; ?></h5>
                <span>3 hour ago</span> </div>
            </div>
           <?php endforeach; ?>
          </li>
        </ul>
      </div>
    </div>
    <!-- //slider --> 
  </div>
  <div class="mobile-app">
    <div class="container">
      <div class="col-md-5 app-left"> <a href="mobileapp.html"><img src="images/app.png" alt=""></a> </div>
      <div class="col-md-7 app-right">
        <h3>Tokunbomall App is the <span>Easiest</span> way for Selling and buying second-hand goods</h3>
        <p>Our Mobile App Will Be Available soon</p>
        <div class="app-buttons">
          <div class="app-button"> <a href="#"><img src="images/1.png" alt=""></a> </div>
          <div class="app-button"> <a href="#"><img src="images/2.png" alt=""></a> </div>
          <div class="clearfix"> </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> 

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
<script type="text/javascript">
   $(window).load(function() {
    $("#flexiselDemo3").flexisel({
      visibleItems:1,
      animationSpeed: 1000,
      autoPlay: true,
      autoPlaySpeed: 5000,    		
      pauseOnHover: true,
      enableResponsiveBreakpoints: true,
      responsiveBreakpoints: { 
        portrait: { 
          changePoint:480,
          visibleItems:1
        }, 
        landscape: { 
          changePoint:640,
          visibleItems:1
        },
        tablet: { 
          changePoint:768,
          visibleItems:1
        }
      }
    });
    
  });
</script> 
<script>
$('#myModal').modal('');
</script>
<?php include(doc_root."footer.php"); ?>
