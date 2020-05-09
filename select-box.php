
<div class="select-box">
  <div class="select-city-for-local-ads ads-list">
    <label>Select your city to see local ads</label>
    <select <?php if(isset($action[1])&&$action[1]=='all'){echo " disabled";}?> id="selectRegion" class="selectpicker show-tick">
    	<?php if(isset($_GET['state'])){
    		$sel_lga = $_GET['state'];
    	}else{
    		$sel_lga = 0;
    	}
		?>
		<option value="0" <?php if($sel_lga==0){echo "selected";} ?>>All States</option>
      <?php $states = States::find_all();?>
      <?php foreach($states as $state):?>
      <optgroup label="<?php echo $state->state; ?>">
      <?php $lgas = Lga::find_lga_by_state($state->id);?>
      <?php foreach($lgas as $lga):?>
      <option <?php if($lga->id==$sel_lga){echo "selected";} ?> value="<?php echo $lga->id; ?>"><?php echo $lga->local_govt; ?></option>
      <?php endforeach; ?>
      </optgroup>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="browse-category ads-list">
    <label>Browse Categories</label>
    <select id="selectCategory" class="selectpicker show-tick" data-live-search="true">
    	<option value="all">All Ads</option>
      <?php $categories = Categories::find_all_by_order('title', 'asc'); 
			foreach($categories as $category):?>
      <option <?php if(isset($categ->slug)){if($categ->slug == $category->slug){echo "selected ";}} ?> value="<?php echo $category->slug; ?>"><?php echo $category->title; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="search-product ads-list">
  	<form method="get" action="<?php echo url_root. "search"; ?>" id="searchForm">
    <label>Search for a specific product</label>
    <div class="search">
      <div id="custom-search-input">
        <div class="input-group">
          <input data-validation="required" type="text" id="search" name="q" class="form-control input-lg" placeholder="Search Products..." />
          <span class="input-group-btn">
          <button class="btn btn-info btn-lg" type="submit"> <i class="glyphicon glyphicon-search"></i> </button>
          </span> </div>
      </div>
 
    </div>
    </form>
  </div>
  <div class="clearfix"></div>
</div>
