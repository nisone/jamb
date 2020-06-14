<?php
if (file_exists('../includes/config.php')){
	try{
		require_once('../includes/config.php');
	}catch(Exception $e){
		//echo $e->getMessage();
	}

	$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';
	$st = (isset($_POST['st'])) ? $_POST['st'] : '';
	$ss = (isset($_POST['ss'])) ? $_POST['ss'] : '';
	$ts = (isset($_POST['ts'])) ? $_POST['ts'] : '';
	$fs = (isset($_POST['fs'])) ? $_POST['fs'] : '';

	$data = '<form name="data" method="POST" action="../enroll.php">
				<input type="hidden" name="class" value="%s">
				<input type="hidden" name="error" value="%s">
				<input type="hidden" name="info" value="%s">
				<input type="hidden" name="warning" value="%s">
			</form>
			<script type="text/javascript">
				//alert(\'Processing...\');
				document.data.submit();
			</script>';

	if(!empty($user_id)){
		if (strcasecmp($st, "--SELECT-SUBJECT--") != 0) {
			$result = $db->insertRow("INSERT INTO jamb_enrollment(user_id, subject_id) VALUES(?,?)", [$user_id, $st]);
		}

		if (strcasecmp($ss, "--SELECT-SUBJECT--") != 0) {
			$result = $db->insertRow("INSERT INTO jamb_enrollment(user_id, subject_id) VALUES(?,?)", [$user_id, $ss]);
		}

		if (strcasecmp($ts, "--SELECT-SUBJECT--") != 0) {
			$result = $db->insertRow("INSERT INTO jamb_enrollment(user_id, subject_id) VALUES(?,?)", [$user_id, $ts]);
		}

		if (strcasecmp($fs, "--SELECT-SUBJECT--") != 0) {
			$result = $db->insertRow("INSERT INTO jamb_enrollment(user_id, subject_id) VALUES(?,?)", [$user_id, $fs]);
		}
		
		header("Location: logout.php");
		exit();
	} else {
		echo sprintf($data, 'danger', 'Action failed', 'Required field empty', 'not registered? <a href=register.php>click to register</a> online');
	}
}
?>
