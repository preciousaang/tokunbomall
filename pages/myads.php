<?php 
if(!$session->is_logged_in()){redirect_to(url_root."post_ad");}

if(isset($_POST['submit'])){
	if(isset($_POST['option'])){
		if($_POST['action']=="approve"){
			foreach($_POST['option'] as $key=>$value){
				$prod = Products::find_by_id($value);
				$prod->approved = TRUE;
				$prod->save();
			}
			$session->message("Product(s) approved");
			redirect_to(url_root."dashboard");
		}elseif($_POST['action']=="unapprove"){
			foreach($_POST['option'] as $key=>$value){
				$prod = Products::find_by_id($value);
				$prod->approved = FALSE;
				$prod->save();				
			}
			$session->message("Product(s) Unapproved") ;
			redirect_to(url_root."dashboard/approved");
		}
	}
}

$page = !empty($_GET['page']) ? (int)$_GET['page']:1;
$per_page = 10;
$approved_products_count = Products::count_product_by_user($session->user_id, 1);
$unapproved_products_count = Products::count_product_by_user($session->user_id, 0);
if(isset($action[1]) && $action[1]=="unapproved"){
    
	$unapproved_products_count = Products::count_product_by_user($session->user_id, 0);
	$pagination = new Pagination($page, $per_page, $unapproved_products_count);
	$products = Products::find_product_by_user_paginate($session->user_id, 0, $per_page, $pagination->offset());
	$uri = url_root."myads/unapproved";    
    
    
    
    

}else{
	$approved_products_count = Products::count_product_by_user($session->user_id, 1);
	$pagination = new Pagination($page, $per_page, $approved_products_count);
	$products = Products::find_product_by_user_paginate($session->user_id, 1, $per_page, $pagination->offset());
	$uri = url_root."myads";
}
if(isset($_GET['delete'])){
	$product = Products::find_by_id($_GET['delete']);
	if($product->user_id==$session->user_id){
		$product->delete_product($_GET['delete']);
		$session->message("Product Deleted");
	}else{
		$session->message("You are not the owner of this product");
	}
	redirect_to($uri);
}

?>
<?php page_header("My Ads"); ?>
<?php include(doc_root."nav.php"); ?>
<div class="terms main-grid-border">
  <div class="container">
    <h2 class="head">My ADS</h2>
    <hr>
	<a class="btn btn-info" href="<?php echo url_root."post_ad"?>"><i class="fa fa-plus"></i> Post New Add</a>
	&nbsp;&nbsp;
	
	 <!--a class="btn btn-success" href="<?php echo url_root."myads"; ?>">Approved(<?php echo $approved_products_count;?>)</a>
	 &nbsp;&nbsp; 
	
    <a class="btn btn-danger" href="<?php echo url_root."myads/unapproved" ?>">Unapproved(<?php echo $unapproved_products_count; ?>)</a-->
   
   
    <hr>
    <?php if($message!=null){ ?>
    	<div class="alert alert-success"><?php echo $message; ?></div><hr>
    <?php }?>
    
    	 <?php if(empty($products)){
        echo "<strong>You have no Products in the section</strong><br>";
    }?>
    <?php foreach($products as $product):?>
    <div class="row">
    	 <?php $img = json_decode($product->product_image)[0]; ?>
      <div class="col-md-3"> <img class="img-rounded" src="<?php echo url_root.$product->upload_dir."/{$img}" ?>" width="300px" height="250px"  /> </div>
      
      <div class="col-md-6">
        <h3>
        Product Description 
       <table class="table product-info">
       	<thead>
       		<tr>
       			<th>Title</th>
       			<th>Price</th>
       			<th>Category</th>
       			<th>Upload Time</th>
       			<th>State</th>
       		</tr>
       	</thead>
       	<tbody>
       		<tr>
       			<td><?php echo $product->title; ?></td>
       			<td><?php echo "₦$product->price"; ?></td>
       			<td><?php echo $product->find_product_category(); ?></td>
       			<td><?php echo $product->upload_time; ?></td>
       			<td><?php echo $product->find_product_state(); ?></td>
       		</tr>
       	</tbody>
       </table> 
       </div>
      <div class="col-md-3" style="vertical-align:bottom">
      	
          <a onclick="return confirm('Are You sure');" class="btn btn-danger btn-sm" href="<?php echo $uri."?delete=".urlencode($product->id);?>">Delete</a>
          <a class="btn btn-info btn-sm" href="<?php echo url_root."edit_ad?id=".urlencode($product->id); ?>">Edit</a>
        
      </div>
    </div>
    <hr>
    <?php endforeach; ?>
    <hr>
    <div class="row">
    <?php if($pagination->total_pages()>1):?>
      <nav  aria-label="Page navigation">
		  <ul class="pagination">
		  	<?php 
		  	
		  	if($pagination->has_previous_page()):?>
		    <li>
		      <a href="<?php echo $uri."?page=".urlencode($pagination->last_page()); ?>" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>
		    <?php endif ?>
		    <?php for($i=1; $i<=$pagination->total_pages(); $i++):?>
		    <?php if($i==$page):?>
				<li class="disabled"><a href="#"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
				<?php else: ?><li><a href="<?php echo $uri."?page=".urlencode($i)?>"><?php echo $i; ?></a></li>
			<?php endif; ?>
		    
		    <?php endfor; ?>
		    <?php if($pagination->has_next_page()):?>
		    <li>
		      <a href="<?php echo $uri."?page=".urlencode($pagination->next_page());?>" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		    <?php endif; ?>
		  </ul>
	  </nav>
	  <?php endif; ?>
    </div>
  </div>
</div>
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
<?php include(doc_root."footer.php");?>
