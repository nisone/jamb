<?php
if (file_exists('../includes/config.php')){
	try{
		require_once('../includes/config.php');
	}catch(Exception $e){
		//echo $e->getMessage();
	}

	$regNo = (isset($_POST['regNo'])) ? $_POST['regNo'] : '';
	$data = '<form name="data" method="POST" action="../login.php">
				<input type="hidden" name="class" value="%s">
				<input type="hidden" name="error" value="%s">
				<input type="hidden" name="info" value="%s">
				<input type="hidden" name="warning" value="%s">
			</form>
			<script type="text/javascript">
				//alert(\'Processing...\');
				document.data.submit();
			</script>';

	if(!empty($regNo)){
		$testData = $db->getRow('SELECT id, regno FROM user_login WHERE regno=?', [$regNo]);
		if(count($testData) > 0){
			$profile = $db->getRow("SELECT * FROM user_profile WHERE user_id=?", [$testData['id']]);
			$_SESSION['fullName'] = sprintf("%s %s %s", $profile['lname'], $profile['fname'], $profile['mname']);
			$_SESSION['photo'] = ($profile['photo'] == 'x') ? 'assets/images/MIB.jpg' : $profile['photo']; 
			$_SESSION['center'] = $profile['lga'];
			$_SESSION['state'] = $profile['state'];
			$_SESSION['user_id'] = $testData['id'];
			$_SESSION['regNo'] = $testData['regno'];
			header("Location: ../index.php");
		}else{
			echo sprintf($data, 'warning', 'Login failed', 'Invalid Registration number', 'not registered? <a href=register.php>click to register</a> online');
		}
	} else {
		echo sprintf($data, 'danger', 'Login failed', 'Required field empty', 'not registered? <a href=register.php>click to register</a> online');
	}
}
?>
