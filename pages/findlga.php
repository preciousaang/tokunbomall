
<?php

if(isset($_POST['state']) && $_POST['state'] > 0){
	$state = (int)$_POST['state'];
	$lgas = Lga::find_lga_by_state($state);
}else{
	echo '<option value="0">Select LGA</option>';
}
?>

<option value="0">Select LGA</option>
<?php
foreach($lgas as $lga):
?>

<option value="<?php echo $lga->id; ?>"><?php echo $lga->local_govt; ?></option>

<?php endforeach; ?>
