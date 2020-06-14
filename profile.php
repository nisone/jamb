<?php require_once('includes/head.php');
	if(!isset($_SESSION['regNo'])){
		$data = '<form name="data" method="POST" action="login.php">
				<input type="hidden" name="class" value="%s">
				<input type="hidden" name="error" value="%s">
				<input type="hidden" name="info" value="%s">
				<input type="hidden" name="warning" value="%s">
			</form>
			<script type="text/javascript">
				//alert(\'Processing...\');
				document.data.submit();
			</script>';
		echo sprintf($data, 'info', 'You are not logged in', 'Please login with your registration number', 'not registered? <a href=register.php>click to register</a> online');
		exit();
	}
	$id = $db->getRow('SELECT id FROM user_login WHERE regno=?', [$_SESSION['regNo']])['id'];
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
	<h4>Update your profile details</h4>
	<form class="form-horizontal" role="form" action="scripts/profile.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="user_id" value="<?php echo $id; ?>">
		<div class="form-group">
			<label for="firstname" class="col-sm-2 control-label">First Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="fname" id="firstname" placeholder="Enter First Name">
			</div>
		</div>
		<div class="form-group">
			<label for="lastname" class="col-sm-2 control-label">Middle Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="mname" id="middlename" placeholder="Enter Middle Name">
			</div>
		</div>
		<div class="form-group">
			<label for="lastname" class="col-sm-2 control-label">Last Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="lname" id="lastname" placeholder="Enter Last Name">
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="col-sm-2 control-label">Address</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="address" id="address" placeholder="Enter Address">
			</div>
		</div>
		<div class="form-group">
			<label for="lga" class="col-sm-2 control-label">LGA</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="lga" id="lga" placeholder="Enter LGA">
			</div>
		</div>
		<div class="form-group">
			<label for="state" class="col-sm-2 control-label">State</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="state" id="state" placeholder="Enter State">
			</div>
		</div>
		<div class="form-group">
			<label for="photo" class="col-sm-2 control-label">Photo</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" name="photo" id="photo">
			</div>
		</div>
		<div class="form-group">
			<label for="dob" class="col-sm-2 control-label">Date of Birth</label>
			<div class="col-sm-10">
				<input type="date" class="form-control" name="dob" id="dob" placeholder="YYYY-MM-DD">
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