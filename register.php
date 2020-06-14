<?php require_once('includes/head.php');
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
	<h4>Enter your details to register</h4>
	<form class="form-horizontal" role="form" action="scripts/register.php" method="POST">
		<div class="form-group">
			<label for="jamb_no" class="col-sm-2 control-label">Jamb no.</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="jamb_no" id="jamb_no" placeholder="Enter Jamb no." required>
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" required>
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="col-sm-2 control-label">Phone</label>
			<div class="col-sm-10">
				<input type="phone" class="form-control" name="phone" id="phone" placeholder="Enter phone no." required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
		</div>
	</form>
</div>
</div>
<div class="row">
	<div class="col-md-8 col-md-offset-2" style="color: whitesmoke; text-align: center;">
		<h1>Type in your JAMB registration number, email and phone number to REGISTER</h1>
	</div>


<?php require_once('includes/footer.php');?>