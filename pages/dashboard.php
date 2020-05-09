<?php 
if(!$session->is_admin()){redirect_to(url_root."post_ad");}

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
			redirect_to(url_root."dashboard");
		}elseif($_POST['action']=="delete"){
			foreach($_POST['option'] as $key=>$value){
				$prod = Products::find_by_id($value);
				$prod->delete();
			}
			$session->message("Product(s) Deleted");
			redirect_to(url_root."dashboard/unapproved");
		}
	}
}

if(isset($_GET['approve'])){
	$prod = Products::find_by_id($_GET['approve']);
	$prod->approved = TRUE;
	$prod->save();	
	$session->message("Product approved");
	redirect_to(url_root."dashboard");
}elseif(isset($_GET['unapprove'])){
	$prod = Products::find_by_id($_GET['unapprove']);
	$prod->approved = FALSE;
	$prod->save();		
	$session->message("Product Unapproved") ;
	redirect_to(url_root."dashboard");	
}elseif(isset($_GET['delete'])){
	$product = Products::find_by_id($_GET['delete']);
	$product->delete();
	$session->message("Product Deleted");
	redirect_to(url_root."dashboard/unapproved");	
}
$page = !empty($_GET['page']) ? (int)$_GET['page']:1;
$per_page = 10;
//$approved_products = Products::find_all_aprroved();
//$unapproved_products = Products::find_all_unapproved();
$approved_products_count = Products::count_products_by_query(array("approved"=>1));
$unapproved_products_count = Products::count_products_by_query(array("approved"=>0));
if(isset($action[1]) && $action[1]=="unapproved"){
	//$products = $approved_products;
	
	$unapproved_products_count = Products::count_products_by_query(array("approved"=>0));
	$pagination = new Pagination($page, $per_page, $unapproved_products_count);
	$products = Products::find_product_by_status_paginate(0, $per_page, $pagination->offset());
	$uri = url_root."dashboard/unapproved";	
	

}else{
 	$approved_products_count = Products::count_products_by_query(array("approved"=>1));
	$pagination = new Pagination($page, $per_page, $approved_products_count);
	$products = Products::find_product_by_status_paginate(1, $per_page, $pagination->offset());
	$uri = url_root."dashboard";   
    
    
    

}
?>
<?php page_header("Admin Dashbord"); ?>
<?php include(doc_root."nav.php"); ?>
<div class="terms main-grid-border">
  <div class="container">
    <h2 class="head">Dashboard</h2>
    <hr>
	<a class="btn btn-info" href="<?php echo url_root."post_ad"?>"><i class="fa fa-plus"></i> Post New Add</a>
	&nbsp;&nbsp;
	
	<a class="btn btn-success" href="<?php echo url_root."dashboard"; ?>">Approved(<?php echo $approved_products_count;?>)</a>
	&nbsp;&nbsp;
    <a class="btn <?php if($unapproved_products_count==0){echo " disabled ";} ?>  btn-danger" href="<?php echo url_root."dashboard/unapproved" ?>">Unapproved(<?php echo $unapproved_products_count; ?>)</a>
    &nbsp;&nbsp; 
    
	
    <hr>
    <?php if($message!=null){ ?>
    	<div class="alert alert-info"><strong><?php echo $message; ?></strong></div><hr>
    <?php }?>
    
    <form action="<?php echo url_root;?>dashboard" method="post">
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
       			<th>Select</th>
       			<th>User</th>
       			<th>Title</th>
       			<th>Price</th>
       			<th>Category</th>
       			<th>Uploaded</th>
       			<th>State</th>
       		</tr>
       	</thead>
       	<tbody>
       		<tr>
       			<td><input name="option[]" type="checkbox" value="<?php echo $product->id?>"></td>
       			<td><?php echo $product->product_owner()->full_name(); ?></td>
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
		  <a target="_blank" class="btn btn-info btn-sm" href="<?php echo url_root."admin_single/{$product->id}/{$product->slug}";?>">View</a>
          <a onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm" href="<?php echo url_root."dashboard?delete=".urlencode($product->id); ?>">Delete</a>
          <?php 
          if(isset($action[1]) && $action[1]=="unapproved"){?>
          		<a class="btn btn-success btn-sm" href="<?php echo url_root."dashboard?approve=".urlencode($product->id);?>">Approve</a>
         <?php }else{?>
         <a class="btn btn-info btn-sm" href="<?php echo url_root."dashboard?unapprove=".urlencode($product->id);?>">Unapprove</a>
         
         
         <?php }?>
          
        
      </div>
    </div>
    <hr>
    <?php endforeach; ?>
    <select name="action">
    	<option value="">Select Bulk Action</option>
    	<?php
    		if($action[1]=="unapproved"){?>
    	?>
    	<option value="approve">Approve</option><?php }else{?>
    	<option value="unapprove">Unpprove</option><?php }?>
    	<option value="delete">Delete</option>
    </select>&nbsp; &nbsp;
    <input class="btn btn-info btn-sm" type="submit" name="submit" value="Apply">
    </form>
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
