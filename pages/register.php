<?php if($session->is_logged_in()){redirect_to(url_root."dashboard");}?>
<?php page_header("Register"); ?>
<?php
  if(isset($_POST['submit'])){
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $user = new User();
	$user->is_admin = FALSE;
    $user->full_name = $full_name;
    $user->username = $username;
    $user->password = sha1($password);
    $user->confirm_password = sha1($confirm_password);
    $user->email = $email;
    $user->phone = $phone;
	$user->validate();
    if(empty($user->errors)){
      $user->create();
      $session->message("You have created a new account. Please Login!!!");
	  redirect_to(url_root."login");
    }else{
    	$message = join("<br>", $user->errors);
		//print_r($user->errors);
    }
  }else{
   $full_name = "";
    $username = "";
    $email = "";
    $region = "";
    $phone = "";
  }
 ?>
<?php include(doc_root.'nav.php'); ?>

<section>
  <div id="page-wrapper" class="sign-in-wrapper">
    <div class="graphs">
      <div class="sign-up">

        <h1>Create an account</h1>
        <h2>Personal Information</h2>
      	<?php
	      	if(!empty($message)){
	      		echo "<div class=\"alert alert-danger\">{$message}</div>";
	      	}
		?>        
        <div class="reg-form">
          <form action="<?php echo url_root."register"; ?>" method="post">
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Username* :</h4>
              </div>
              <div class="sign-up2">
                <input data-validation="required alphanumeric length" data-validation-length="max40" maxlength="40" data-validation-allowing="-_" name="username" type="text" value="<?php echo htmlentities($username); ?>" required id="username" placeholder=" "/>
              </div>
              <div class="clearfix"> </div>
            </div>
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Full Name* :</h4>
              </div>
              <div class="sign-up2">
                <input data-validation="required" type="text" name="full_name" placeholder="" value="<?php echo htmlentities($full_name); ?>" required/>
              </div>
              <div class="clearfix"> </div>
            </div>
          
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Phone No* :</h4>
              </div>
              <div class="sign-up2">
                <input data-validation="required number length" data-validation-length="min11 max11" name="phone" maxlength="11" type="text" required id="phone" value="<?php echo htmlentities($phone); ?>" placeholder="08012345678"/>
              </div>
              <div class="clearfix"> </div>
            </div>
            
            
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Email Address* :</h4>
              </div>
              <div class="sign-up2">
                <input data-validation="required email" name="email" type="text" value="<?php echo htmlentities($email); ?>" required id="username" placeholder="abcd@email.com"/>
              </div>
              <div class="clearfix"> </div>
            </div>
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Password* :</h4>
              </div>
              <div class="sign-up2">
                <input data-validation="required" id="password" name="password" type="password" placeholder=" " required/>
              </div>
              <div class="clearfix"> </div>
            </div>
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Confirm Password* :</h4>
              </div>
              <div class="sign-up2">
                <input data-validation-confirm="password" data-validation="required confirmation"  type="password" name="confirm_password" placeholder=" " required/>
              </div>
              <div class="clearfix"> </div>
            </div>
            <div class="sub_home">
              <div class="sub_home_left">
                <input name="submit" type="submit" value="Register">
              </div>
            </div>
          </form>
        </div>
        <div class="sub_home_right">
          <p>Go Back to <a href="index.php">Home</a></p>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
  </div>
</section>
<!--footer section start-->
<footer class="diff">
  <p class="text-center">&copy 2018 Tokunbo Mall. All Rights Reserved | Design by <a href="https://webmirandum.com/" target="_blank">WebMirandum.</a></p>
</footer>
<!--footer section end--> 

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
<?php include_script("jquery.form-validator.min.js"); ?>
<?php include_script("mform.js"); ?>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> 
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
    $.validate({});
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
	
    $("#myModal").modal('');
  </script>
</body></html>