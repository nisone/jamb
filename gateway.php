<?php
require('includes/config.php');
header("Content-Type: application/json");
header("X-Powered-By: nisone");

if(!isset($_SESSION['user_id'])){
	http_response_code(403);
	echo json_encode(['STATUS'=>'ERROR','INFO'=>'UNAUTHORIZE ACCESS']);
	exit();	
}

$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
$subId = (isset($_REQUEST['subId'])) ? $_REQUEST['subId'] : '';
$question = (isset($_REQUEST['question'])) ? $_REQUEST['question'] : '';
$curOptCho = (isset($_REQUEST['optCho'])) ? $_REQUEST['optCho'] : '';


if(!empty($subId) & !empty($action)){
	switch ($action) {
		case 'getFirst':
			echo getFirst($subId);
			break;
		case 'getCur':
			echo getCur($subId);
			break;
		case 'updateOpt':
			echo updateCho($subId, $curOptCho);
			break;
		case 'prev':
			echo prevQ($subId, $curOptCho);
			break;
		case 'next':
			echo nextQ($subId, $curOptCho);
			break;
		case 'submit':
			echo submit($db, $subId);
			break;
		case 'getTime':
			echo getTime($subId);
			break;
		default:
			echo json_encode(['STATUS'=>'ERROR','INFO'=>'INVALID ACTION QUERY']);
			break;
	}
}

function getFirst($subId){
	//$_SESSION['qCur'][$subId] = 0;
	if(count($_SESSION['qBank'][$subId]) <= 0){
		return json_encode(['ERROR'=>'No questions available for this subject.']);
	}
	return json_encode($_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]);
}

function getCur($subId){
	if(count($_SESSION['qBank'][$subId]) <= 0){
		return json_encode(['ERROR'=>'No questions available for this subject.']);
	}
	return json_encode($_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]);
}

function updateCho($subId, $curOptCho){
	$correct_opt = $_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['correct_Opt'];
	$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['cOptCho'] = $curOptCho;

	if($curOptCho == $correct_opt){
		$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['mark'] = 1;
	}else{
		$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['mark'] = 0;
	}

	return json_encode(['STATUS'=>'OK']);
}

function nextQ($subId, $curOptCho){
	$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['cOptCho'] = $curOptCho;
	$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['mark'] = ($_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['cOptCho']==$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['correct_Opt'])? 1 : 0;
	$pos = $_SESSION['qCur'][$subId] + 1;
	if($pos < count($_SESSION['qBank'][$subId])){
		$_SESSION['qCur'][$subId] += 1;
		return json_encode($_SESSION['qBank'][$subId][$pos]);	
	}else{
		return json_encode(['ERROR'=>'Last question']);
	}
}

function prevQ($subId, $curOptCho){
	$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['cOptCho'] = $curOptCho;
	$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['mark'] = ($_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['cOptCho']==$_SESSION['qBank'][$subId][$_SESSION['qCur'][$subId]]['correct_Opt'])? 1 : 0;
	$pos = $_SESSION['qCur'][$subId] - 1;
	if($pos >= 0){
		$_SESSION['qCur'][$subId] -= 1;
		return json_encode($_SESSION['qBank'][$subId][$pos]);
	}else{
		return getFirst($subId);
	}
}

function submit($db, $subId){
	/* Field to submit to database
	 * id(NULL), user_id($_SESSION['user_id']), subject_id($subId), score(), session(), datetime(NULL)
	 */

	$_SESSION['qAns'][$subId] = 0;
	//NOTE the line bellow cost me time debugging this code, i accidentily put 1 inplace of $subId which course all the score to be the same with first subject score to be submit
	foreach ($_SESSION['qBank'][$subId] as $key => $value) {
		$_SESSION['qAns'][$subId] += $value['mark'];
	}

	try{
		$res = $db->insertRow('INSERT INTO jamb_result(id, user_id, subject_id, score, session) VALUES(NULL, ?, ?, ?, ?)', [
			$_SESSION['user_id'],
			$subId,
			$_SESSION['qAns'][$subId],
			session_id()
		]);

		if($res == TRUE){
			return json_encode(['STATUS'=>'OK','INFO'=>'SUBMITTED: Submition successfull']);
		}
	}catch(Exception $e){
		return json_encode(['STATUS'=>'ERROR','INFO'=>'Submition failed!']);
	}	

}

function setTime($subId){
	//;
}

function getTime($subId){
	if(isset($_SESSION['time'][$subId])){
		return json_encode(['STATUS' => 'OK', 'TIME' => $_SESSION['time'][$subId]-time()]);	
	}else{
		$time = strtotime('+5 minutes');//strtotime('+1 hours 30 minutes');
		$_SESSION['time'][$subId] = $time;
		return json_encode(['STATUS' => 'OK', 'TIME' => $_SESSION['time'][$subId]-strtotime('now')]);		
	}
}
?>