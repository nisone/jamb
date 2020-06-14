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
	$subjects = $db->getRows('SELECT * FROM jamb_subject WHERE id NOT IN (SELECT subject_id FROM jamb_enrollment WHERE user_id=?) AND 4 > (SELECT COUNT(user_id) FROM jamb_enrollment WHERE user_id=?)',[$id, $id]);
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
	<h4>Select your JAMB subjects</h4>
	<form class="form-horizontal" role="form" action="scripts/enroll.php" method="POST">
		<input type="hidden" name="user_id" value="<?php echo $id; ?>">
		<div class="form-group">
			<label for="st" class="control-label">First Subject</label>
			<select class="form-control" name="st" id="st">
				<option>--SELECT-SUBJECT--</option>
				<?php
					foreach ($subjects as $row => $col) {
						echo "<option value=$col[id]>$col[title]</option>";
					}
				 ?>
			</select>
		</div>
		<div class="form-group">
			<label for="ss" class="control-label">Second Subject</label>
			<select class="form-control" name="ss" id="ss">
				<option>--SELECT-SUBJECT--</option>
				<?php
					foreach ($subjects as $row => $col) {
						echo "<option value=$col[id]>$col[title]</option>";
					}
				 ?>
			</select>
		</div>
		<div class="form-group">
			<label for="ts" class="control-label">Third Subject</label>
			<select class="form-control" name="ts" id="ts">
				<option>--SELECT-SUBJECT--</option>
				<?php
					foreach ($subjects as $row => $col) {
						echo "<option value=$col[id]>$col[title]</option>";
					}
				 ?>
			</select>
		</div>
		<div class="form-group">
			<label for="fs" class="control-label">Forth Subject</label>
			<select class="form-control" name="fs" id="fs">
				<option>--SELECT-SUBJECT--</option>
				<?php
					foreach ($subjects as $row => $col) {
						echo "<option value=$col[id]>$col[title]</option>";
					}
				 ?>
			</select>
		</div>
		<div class="form-group">
			<div class="">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
		</div>
	</form>
</div>
</div>
<div class="row">
	<div class="col-md-8 col-md-offset-2" style="color: whitesmoke; text-align: center;">
		<h1>Select your JAMB subjects combination, to complete your REGISTERATION</h1>
	</div>


<?php require_once('includes/footer.php');?>