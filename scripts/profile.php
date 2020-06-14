<?php
if (file_exists('../includes/config.php')){
	try{
		require_once('../includes/config.php');
	}catch(Exception $e){
		//echo $e->getMessage();
	}

	$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';
	$fname = (isset($_POST['fname'])) ? $_POST['fname'] : '';
	$mname = (isset($_POST['mname'])) ? $_POST['mname'] : '';
	$lname = (isset($_POST['lname'])) ? $_POST['lname'] : '';
	$address = (isset($_POST['address'])) ? $_POST['address'] : '';
	$lga = (isset($_POST['lga'])) ? $_POST['lga'] : '';
	$state = (isset($_POST['state'])) ? $_POST['state'] : '';
	$dob = (isset($_POST['dob'])) ? $_POST['dob'] : '';

	$data = '<form name="data" method="POST" action="../profile.php">
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
		$testData = $db->getRow('SELECT user_id FROM user_profile WHERE user_id=?', [$user_id]);
		if(isset($_FILES['photo'])){
			$destination = '../uploads/profileimages/' . $user_id . substr($_FILES['photo']['name'], strripos($_FILES['photo']['name'], '.'));
			move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
			if(file_exists($destination))
				$photo = substr($destination, 1);
			else
				$photo = 'x';
		}else{
			$photo = 'x';
		}

		if($testData != false || is_array($testData)){
			//update user profile
			$result = $db->updateRow('UPDATE user_profile SET fname=?,mname=?,lname=?,address=?,lga=?,state=?,dob=?,photo=? WHERE user_id=?',
				[$fname,$mname,$lname,$address,$lga,$state,$dob,$photo,$user_id]);

			if ($result==1){
				echo sprintf($data, 'info', 'Success', 'Profile updated continue to <a href=enroll.php>enrollment</a>',
				 '');
			}else{
				echo sprintf($data, 'danger', 'Action failed', 'Something whent wrong', '***');
			}
		}else{
			//Insert user profile
			$result = $db->insertRow("INSERT INTO user_profile(fname, mname, lname, address, lga, state, dob, photo, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
			 [$fname,$mname,$lname,$address,$lga,$state,$dob,$photo,$user_id]);
			//echo $result;
			//if every process completed successfull move to profile update
			if ($result==1){
				echo sprintf($data, 'info', 'Success', 'Profile created continue to <a href=enroll.php>enrollment</a>',
				 '');
			}else{
				echo sprintf($data, 'danger', 'Profile creation failed', 'Something whent wrong', '***');
			}
		}
	} else {
		echo sprintf($data, 'danger', 'Action failed', 'Required field empty', 'not registered? <a href=register.php>click to register</a> online');
	}
}
?>
