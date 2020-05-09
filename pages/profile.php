<?php if(!$session->is_logged_in()){redirect_to(url_root."login");}?>
<?php page_header("User Profile"); ?>
<?php
  $user = User::find_by_id($session->user_id);
  if(isset($_POST['submit'])){
  	$user = User::find_by_id($session->user_id);
	$full_name = trim($_POST['full_name']);
    
	if(strlen($_POST['password'])>0){
	    $password = sha1($_POST['password']);
	    $confirm_password = sha1($_POST['confirm_password']);		
	}else{
		$currpass = User::find_by_id($session->user_id);
		$password = $currpass->password;
	    $confirm_password = $currpass->password;
	}
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
	$state = trim($_POST['state']);
	$lga = trim($_POST['lga']);
    $user->full_name = $full_name;
	
	$user->password = $password;
	$user->confirm_password = $confirm_password;	
	
	$temail = User::find_by_email($email)->username;
	if(isset($temail) && ($temail!= $user->username)){
		$session->message("Email Exists already");
		redirect_to(url_root."profile");
	}else{
		$user->email = $email;
	}
    
    $user->phone = $phone;
	$user->state = $state;
	$user->lga = $lga;
    $user->validate();
    if(empty($user->errors)){
      $user->update();
      $session->message("Updated profile Successfully");
	  redirect_to(url_root."profile");
    }else{
    	$session->message(join("<br>", $user->errors));
		redirect_to(url_root."profile");
    }
  }
 ?>
<?php include(doc_root.'nav.php'); ?>

<section>
  <div id="page-wrapper" class="sign-in-wrapper">
    <div class="graphs">
      <div class="sign-up">
        <h1>Edit Your Account</h1>
        <h2>Personal Information</h2>
        <div class="reg-form">
        	<?php if(!empty($message)){echo "<div class=\"alert alert-info\">{$message}</div>"; }?>
          <form action="<?php echo url_root."profile"; ?>" method="post">
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Username*</h4>
              </div>
              <div class="sign-up2">
                <input readonly name="username" type="text" value="<?php echo htmlentities($user->username); ?>" required id="username" placeholder=" "/>
              </div>
              <div class="clearfix"> </div>
            </div>
             <div class="sign-u">
              <div class="sign-up1">
                <h4>Full Name*</h4>
              </div>
              <div class="sign-up2">
                <input name="full_name" type="text" value="<?php echo htmlentities($user->full_name); ?>" required id="full_name" placeholder=" "/>
              </div>
              <div class="clearfix"> </div>
            </div>
            
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Phone No*</h4>
              </div>
              <div class="sign-up2">
                <input name="phone" maxlength="11" type="text" required id="phone" value="<?php echo htmlentities($user->phone); ?>" placeholder="08012345678"/>
              </div>
              <div class="clearfix"> </div>
            </div>
            
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Email Address*</h4>
              </div>
              <div class="sign-up2">
                <input name="email" type="text" value="<?php echo htmlentities($user->email); ?>" required id="username" placeholder="abcd@email.com"/>
              </div>
              <div class="clearfix"> </div>
            </div>
            <div class="sign-u">
              <div class="sign-up1">
                <h4>New Password*</h4>
              </div>
              <div class="sign-up2">
                <input name="password" type="password" placeholder=" "/>
              </div>
              <div class="clearfix"> </div>
            </div>
            <div class="sign-u">
              <div class="sign-up1">
                <h4>Confirm New Password*</h4>
              </div>
              <div class="sign-up2">
                <input type="password" name="confirm_password" placeholder=" "/>
              </div>
              <div class="clearfix"> </div>
            </div>
            <div class="sub_home">
              <div class="sub_home_left">
                <input name="submit" type="submit" value="Update">
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
<?php include_script("mform2.js"); ?>
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