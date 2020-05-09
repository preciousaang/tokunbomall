<style>
.logo{
    text-align:left;
}
.logo img{
	width:150px;
	height:70px;
}
</style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header logo"> <img src="assets/images/Logo.jpeg" /> </div>
    <ul class="nav navbar-nav navbar-right">
      <?php
      	if($session->is_logged_in()){?>
      <?php $user = User::find_by_id($session->user_id); ?>
      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-2x" style="color: rgb(1, 161, 133);">&nbsp;</i><strong style="color: rgb(243, 197, 0); font-size:18px;"><?php echo $user->full_name(); ?></strong><span class="caret"></span></a>
        <ul class="dropdown-menu">
		<?php if($session->is_admin()){?>
		<li><a href="<?php echo url_root."dashboard"; ?>"><strong style="color: rgb(243, 197, 0); font-size:18px;">Dashboard</strong></a>
		
		<?php }?>
          <li><a href="<?php echo url_root."profile"; ?>"><strong style="color: rgb(243, 197, 0); font-size:18px;">Profile</strong></a></li>
          <li><a href="<?php echo url_root."myads" ?>"><strong style="color: rgb(243, 197, 0); font-size:18px;">My Ads</strong></a></li>
          <li><a href="<?php echo url_root."logout"?>"><strong style="color: rgb(243, 197, 0); font-size:18px;">Logout</strong></a></li>
        </ul>
      </li>
      <?php }else{?>
      <li><a href="<?php echo url_root."register"?>"><button class="btn btn-success fa fa-user-plus">&nbsp; &nbsp;Register</button></a></li>
      <li><a href="<?php echo url_root."login"?>"><button class="btn btn-success fa fa-sign-in">&nbsp; &nbsp;Login</button></a></li>
      <?php }?>
    </ul>
  </div>
</nav>
