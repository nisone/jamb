<?php
	require_once('includes/head.php');
	$class = (isset($_POST['class'])) ? $_POST['class'] : '';
	$error = (isset($_POST['error'])) ? $_POST['error'] : '';
	$info = (isset($_POST['info'])) ? $_POST['info'] : '';
	$warning = (isset($_POST['warning'])) ? $_POST['warning'] : '';
	if(!empty($error)){
?>

<div class="row">
	<div class="col-md-12">
		<div class="alert alert-<?php echo $class; ?>">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<span id="msg"><strong><?php echo $error; ?>!</strong> <?php echo $info . ", " . $warning; ?> </span>
		</div>
	</div>
</div>

<?php }?>

<div class="col-md-6" id="leftContent">
	<center><img src="assets/images/logo.jpg" class="img-responsive" id="bLogo" alt="logo" width="150px" height="150px" hspace="10px" style="padding: 100px 0px 0px 0px;"></center>
</div>
<div class="col-md-6" id="rightContent">
	<center><h4>Enter your Registration No.</h4>
	<form role="form" class="form-inline" action="scripts/login.php" method="POST"> 
		<center><div class="form-group">
			<input type="text" class="form-control" name="regNo" placeholder="Enter Registration No." maxlength="10" required>
		</div>
		<input type="submit" class="form-control" name="login" value="Login">
		<div>
			<hr>
			<p><h4>Not yet registered? </h4></p>
			<p><h3><a href="register.php" title="registeration link">Register</a></h3></p>

		</div>
	</form>
	</center>
</div>
</div>
<div class="row">
	<div class="col-md-8 col-md-offset-2" style="color: whitesmoke; text-align: center;">
		<h1>Type in your JAMB registration number into the textbox, and click on LOG IN</h1>
	</div>


<?php
	require_once('includes/footer.php');
?>