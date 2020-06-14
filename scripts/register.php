<?php
if (file_exists('../includes/config.php')){
	try{
		require_once('../includes/config.php');
	}catch(Exception $e){
		//echo $e->getMessage();
	}

	$regNo = (isset($_POST['jamb_no'])) ? $_POST['jamb_no'] : '';
	$email = (isset($_POST['email'])) ? $_POST['email'] : '';
	$phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';

	$data = '<form name="data" method="POST" action="../register.php">
				<input type="hidden" name="class" value="%s">
				<input type="hidden" name="error" value="%s">
				<input type="hidden" name="info" value="%s">
				<input type="hidden" name="warning" value="%s">
			</form>
			<script type="text/javascript">
				//alert(\'Processing...\');
				document.data.submit();
			</script>';

	if(!empty($regNo) && (!empty($phone) && !empty($email))){
		$testData = $db->getRow('SELECT id, regno FROM user_login WHERE regno=?', [$regNo]);
		if($testData != false || is_array($testData)){
			echo sprintf($data, 'danger', 'Registration failed', 'User already exist', '<a href=login.php>click here</a> to  Login.');
			// $profile = $db->getRow("SELECT * FROM user_profile WHERE user_id=?", [$testData['id']]);
			// $_SESSION['fullName'] = sprintf("%s %s %s", $profile['lname'], $profile['fname'], $profile['mname']);
			// $_SESSION['photo'] = ($profile['photo'] == 'x') ? 'assets/images/MIB.jpg' : $profile['photo']; 
			// $_SESSION['center'] = $profile['lga'];
			// $_SESSION['state'] = $profile['state'];
			// $_SESSION['user_id'] = $testData['id'];
			// $_SESSION['regNo'] = $testData['regno'];
			// header("Location: ../index.php");
		}else{
			//Insert user detial to database and procced to profile update
			$result = $db->insertRow("INSERT INTO user_login(regno, email, phone) VALUES(?,?,?)", [$regNo, $email, $phone]);
			//echo $result;
			//if every process completed successfull move to profile update
			if ($result==1){
				$_SESSION['regNo'] = $regNo;
				echo sprintf($data, 'info', 'Success!', 'You can now complete your profile',
				 'don\'t have a profile? <a href=profile.php>click to here</a> to update your profile');
			}else{
				echo sprintf($data, 'danger', 'Registration failed', 'Something whent wrong', '***');
			}
		}
	} else {
		echo sprintf($data, 'danger', 'Login failed', 'Required field empty', 'not registered? <a href=register.php>click to register</a> online');
	}
}
?>
