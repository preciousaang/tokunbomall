<?php
if($session->is_logged_in()){redirect_to("dashboard");}
if(isset($_POST['submit'])){
	$username = $database->escape_value(trim($_POST["username"]));
	$password = $database->escape_value($_POST['password']);
	$found_user = User::authenticate($username, $password);
	if($found_user){
		$session->login($found_user);
		$session->is_admin() ? redirect_to("dashboard") : redirect_to("post_ad");
		
	}else{
		$msg = "Username/Password combination incorrect.";
	}
}else{
	$username = "";
}
?>
<?php page_header("Login"); ?>
<?php include(doc_root."nav.php"); ?>

<section>
  <div id="page-wrapper" class="sign-in-wrapper">
    <div class="graphs">
      <div class="sign-in-form">
        <div class="sign-in-form-top">
          <h1>Log in</h1>
        </div>
        <?php
        if(isset($msg)){ ?>
        <div class="alert alert-danger"><?php echo $msg; ?></div>
        <?php } ?>
        <?php if(!empty($message)){
        	echo "<div class=\"alert alert-info\">{$message}</div>";
        } ?>
        <div class="signin">
          <div class="signin-rit"> <span class="checkbox1">
            <label class="checkbox">
              <input type="checkbox" name="checkbox" checked="">
              Forgot Password ?</label>
            </span>
            <p><a href="#">Click Here</a> </p>
            <div class="clearfix"> </div>
          </div>
          <form action="<?php echo url_root ?>login" method="post">
            <div class="log-input">
              <div class="log-input-left">
                <input type="text" class="user" value="<?php echo htmlentities($username); ?>" placeholder="Your Username" name="username">
              </div>
              <span class="checkbox2">
              <label class="checkbox">
                <input type="checkbox" name="checkbox" checked="">
                <i> </i></label>
              </span>
              <div class="clearfix"> </div>
            </div>
            <div class="log-input">
              <div class="log-input-left">
                <input type="password" class="lock" placeholder="*************" name="password">
              </div>
              <span class="checkbox2">
              <label class="checkbox">
                <input type="checkbox" name="checkbox" checked="">
                <i> </i></label>
              </span>
              <div class="clearfix"> </div>
            </div>
            <input name="submit" type="submit" value="Log in">
          </form>
        </div>
        <div class="new_people"> <a href="<?php echo url_root."register"; ?>">Register Now!</a> </div>
      </div>
    </div>
  </div>
  <!--footer section start-->
  <footer class="diff">
    <p class="text-center">&copy 2018 Tokunbo Mall. All Rights Reserved | Design by <a href="https://webmirandum.com/" target="_blank">WebMirandum.</a></p>
  </footer>
  <!--footer section end--> 
</section>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
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
<script>
    $('#myModal').modal('');
    </script>
</div>
</div>
</div>
</div>
</body></html>